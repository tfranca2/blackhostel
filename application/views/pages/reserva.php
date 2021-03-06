<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<script>
	$(document).ready(function(){
		$('#duallist').DualListBox({json:false, available:'Disponiveis', selected:'Selecionados',showing:'mostrando',filterLabel:'Filtro'});
		$('.calendar').datetimepicker({	
		  beforeShow: function(input, inst) {
				var calendar = inst.dpDiv;
				setTimeout(function() {
					$('.ui_tpicker_time_label').text("Tempo");
					$('.ui_tpicker_hour_label').text("Hora");
					$('.ui_tpicker_minute_label').text("Minuto");
					calendar.position({
						my: 'left top',
						at: 'left bottom',
						collision: 'none',
						of: input
					});
				}, 1);
				customRange(input);
			},
			onSelect: function(){
				$('#tipo-quarto').prop('selectedIndex',0);
			}
		});

		function customRange(input) {   
			if (input.id == 'entrada'){     
				var x = $('#saida').datepicker("getDate");
				$( "#entrada" ).datepicker( "option", "maxDate",x ); 
			}else if (input.id == 'saida') {     
				var x=$('#entrada').datepicker("getDate");
				$( "#saida" ).datepicker( "option", "minDate",x ); 
			} 
		}
		
		
		$("#tipo-quarto").on('change', function(){
           loadQuartos();
		   if($("#tipo-quarto").val() == 1){
			$("#saida").attr("required","true");
		   }else{
			$("#saida").removeAttr("required");
		   }
         });

		$(".filter-unselected").on('keyup', function(){
				if($(this).val().length >= 4 && ($(this).val().length % 2) ==0 )
	           		loadClientes($(this).val());
				else
					$('.unselected').empty();
	    });

		 function loadClientes(clienteName){
				$('.unselected').empty();
	 			var url =  "<?php echo site_url()."/cliente/load/" ;?>";
				$.ajax({
						url: url ,
						type: 'GET',
						data: {clienteName:clienteName},
						success: function(data){
							//console.log(data);
 							cliente = JSON.parse(data);
 							console.log(cliente);
							$.each(cliente, function(i,cliente) {
								if($('#selectclientes').val() != cliente.id_cliente)
								$('.unselected').append( '<option value="' + cliente.id_cliente+ '" >'+ cliente.cliente + '</option>' ); 
							});	
						}
				});
			 }
		 $('#selectclientes').change(function(){
			 $('.unselected, .selected').empty();
		 });
		 
		 function loadQuartos(){
			$('#selectquartos').empty();
 			var url =  "<?php echo site_url()."/reserva/quartos/" ;?>"+ $("#tipo-quarto").val()+"/"+<?php echo ($this->uri->segment(3))?$this->uri->segment(3):'0'; ?>;
			$.ajax({
					url: url ,
					type: 'GET',
					data: {entrada:$("#entrada").val(), saida:$("#saida").val()},
					success: function(data){
						console.log(data);
						obj = JSON.parse(data);
						$('#selectquartos').append( '<option> -- Selecione -- </option>' );
						$.each(obj, function(i,quarto) {
							sel = (quarto.id_quarto == <?php echo (@$reserva->id_quarto)?@$reserva->id_quarto:0; ?> )?
								"selected":"";
							
							$('#selectquartos').append( '<option value="' + quarto.id_quarto+ '" '+sel+'>'+ quarto.perfil +' - Nº '+ quarto.numero + '</option>' ); 
						});	
					}
			});
		 }
		
	});
</script>
<div class="row">
	<?php 
	$a = validation_errors();
	if(!empty($a)){ ?>
	<div class="alert alert-success">
		<?php echo $a; ?>
	</div>
	<?php } 
	
	$b = $this->session->flashdata('msg');
	if(!empty($b)){ ?>
	<div class="alert alert-success">
	  <?php echo $b; ?>	
	</div>
	<?php } ?>
</div>	
<?php 
/**
* Ã�rea da tela responsÃ¡vel pela pesquisa e exibiÃ§Ã£o da lista de resultados
*/
	if($part =="searching"){
?>
	<form action="<?php echo site_url();?>/reserva/searching" method="post">
	<div class="row">
		<div class="col-md-4 form-group">
		<label>Situação</label>
		    <select name="id_sit" class="form-control">
				<option value=""> -- Selecione -- </option>
				<option value="1"> EM USO </option>
				<option value="2"> RESERVADO </option>
				<option value="3"> MANUTENCAO </option>
				<option value="4"> FINALIZADO </option>
				<option value="5"> FECHADO </option>
				<option value="6"> CANCELADO </option>
		    </select>
		</div>
		<div class="col-md-5 form-group">
			<input type="submit" name="submit" value="Buscar" style="margin-top: 25px;" class="btn btn-success"/>
		</div>
	</div>
	<div class="row">
		<div class="col-md-1 col-often-11 form-group pull-right">
			<a class="btn btn-info" href="<?php echo site_url();?>/reserva/inserting">Novo</a>
		</div>
	</div>
	</form>
	<div class="row">
		<div class="large-12 columns">
		<table class="table table-striped table-bordered"> 
			<tr>
				<th>ID</th>
				<th>Cliente</th>
				<th>Perfil</th>
				<th>Quarto</th>
				<th>Tipo Reserva</th>
				<th>Entrada</th>
				<th>Saída</th>
				<th>Situação</th>
				<th  style="text-align: center;">Opções</th>
			</tr>
			<?php foreach($tabledata as $reserva){?>
			<tr>
				<td><?php echo $reserva->id_reserva ?></td>
				<td><?php echo $reserva->cliente ?></td>
				<td><?php echo $reserva->descricao ?></td>
				<td><?php echo $reserva->numero ?></td>
				<td><?php echo ($reserva->tp_modo_reserva ==1?'Diária':(($reserva->tp_modo_reserva == 2)?'Hora': 'Pernoite')); ?></td>
				<td><?php echo dateTimeToBr( $reserva->entrada ) ?></td>
				<td><?php echo dateTimeToBr( $reserva->saida ) ?></td>
				<td  style="text-align: center;"><?php 
						 if($reserva->id_situacao ==1){
							echo 'EM USO';
						 }else if($reserva->id_situacao == 2){ 
							echo 'RESERVADO';
						 }
						 else if($reserva->id_situacao == 4){
						 	echo 'FINALIZADO';
						 }
						 else if($reserva->id_situacao == 5){
						 	echo 'FECHADO';
						 }
						 else if($reserva->id_situacao == 6){
						 	echo 'CANCELADO';
						 }
					?>
				</td>
				<td style="text-align: center;">
					<?php if($reserva->id_situacao == 2){ ?>
					<a href="<?php echo site_url();?>/reserva/ativar/<?php  echo $reserva->id_reserva ?>" class="btn btn-success btn-sm">Ativar
						<span class="glyphicon glyphicon-ok"></span>
					</a>
					<?php } ?>
					<a href="<?php echo site_url();?>/reserva/editing/<?php  echo $reserva->id_reserva ?>" class="btn btn-default btn-sm">Editar 
						<span class="glyphicon glyphicon-edit"></span>
					</a>
				
					<a href="<?php echo site_url();?>/reserva/deleting/<?php  echo $reserva->id_reserva ?>" class="btn btn-default btn-sm">Deletar 
						<span class="glyphicon glyphicon-remove"></span>
					</a>
				</td>
			</tr>
			<?php } ?>
		</table> 
		</div>
	</div>
	
<?php 
/**
* Ã�rea da tela responsÃ¡vel pelo formulÃ¡rio de inserÃ§Ã£o de dados
*/
	}else if($part =="inserting"){
		
	echo form_open('reserva/save');	
?>

<div class="row">
	<div class="col-md-3 form-group">
	  	<label>Entrada</label>
	  	<div class="input-group">
            <input type="datetime" class="form-control calendar" name="entrada" id="entrada" required>
            <span class="input-group-addon add-on">
                <span class="glyphicon glyphicon-calendar" data-time-icon="icon-time"></span>
            </span>
		</div>
	</div>
	<div class="col-md-3 form-group">
	  	<label>Saída</label>
	  	<div class="input-group">
            <input type="datetime" class="form-control calendar" name="saida" id="saida" >
            <span class="input-group-addon add-on">
                <span class="glyphicon glyphicon-calendar" data-time-icon="icon-time"></span>
            </span>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3 form-group">
	  <label>Tipo Reserva</label>
	  <select name="id_tipo_reserva" class="form-control" id="tipo-quarto" required>
			<option value=""> -- Selecione -- </option>
			<option value="1">Diárias</option>
			<option value="2">Horas</option>
			<option value="3">Pernoites</option>
	  </select>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <label>Quarto</label>
	  <select name="id_quarto" class="form-control" id="selectquartos" required >
	  	<option value=""> -- Selecione -- </option>
	  </select>
	</div>
</div>
<div class="panel panel-primary">
  <div class="panel-heading">Clientes</div>
  <div class="panel-body">
	  <div class="row">
			<div class="col-md-6 form-group">
			  <label>Cliente Titular da Reserva</label>
			  <select name="id_cliente" class="form-control" id="selectclientes" >
			  	<option value=""> -- Selecione -- </option>
			  	<?php foreach ($clientes as $cliente){?>
			  		<option value="<?php echo $cliente->id_cliente?>"> <?php echo $cliente->cliente?> </option>	
			  	<?php }?>
			  </select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 form-group">
				<label>Acompanhantes</label>
			</div>
	  	</div>
	  	<div class="row">
			<div class="col-md-12 form-group">
				<select name="clientes[]" class="form-control" id="duallist" multiple="true">
				</select>
			</div>
	  	</div>
  </div>
</div>

<div class="row">
	<div class="col-md-6 form-group">
	 <?php
		echo form_submit(array('name'=>'cadastrar','class' =>'btn btn-success'),'Cadastrar')." ";
		echo form_reset(array('name'=>'limpar','class' =>'btn btn-danger'),'Limpar');
	  ?>
	</div>
	<div class="col-md-6 form-group">
		<a class="btn btn-info" href="<?php echo site_url();?>/reserva" class="button success">Voltar</a>  
	</div>
</div>

<?php 

/**
* Ã�rea da tela responsÃ¡vel pelo formulÃ¡rio de ediÃ§Ã£o de dados
*/
	}else if($part =="editing"){
		
	echo form_open('reserva/edit');
	echo form_hidden('id_reserva', $reserva->id_reserva);
	
?>
<div class="row">
	<div class="col-md-3 form-group">
	  <label>Entrada</label>
	  	<div class="input-group">
            <input type="datetime" class="form-control calendar" name="entrada" id="entrada" required 
            value="<?php echo dateTimeToBr( $reserva->entrada ) ?>"
            > 
            <span class="input-group-addon add-on">
                <span class="glyphicon glyphicon-calendar" data-time-icon="icon-time"></span>
            </span>
		</div>
	</div>
	<div class="col-md-3 form-group">
	  <label>Saída</label>
	  	<div class="input-group">
            <input type="datetime" class="form-control calendar" name="saida" id="saida" required value="<?php  echo dateTimeToBr( $reserva->saida ) ?>"
            > 
            <span class="input-group-addon add-on">
                <span class="glyphicon glyphicon-calendar" data-time-icon="icon-time"></span>
            </span>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3 form-group">
	  <label>Tipo Reserva</label>
	  <select name="id_tipo_reserva" class="form-control" id="tipo-quarto">
			<option value=""> -- Selecione -- </option>
			<option value="1" <?php tagAs('selected',$reserva->tp_modo_reserva , 1 ) ?>>Diárias</option>
			<option value="2" <?php tagAs('selected',$reserva->tp_modo_reserva , 2 ) ?>>Horas</option>
			<option value="3" <?php tagAs('selected',$reserva->tp_modo_reserva , 3 ) ?>>Pernoites</option>
	  </select>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <label>Quarto</label>
	  <select name="id_quarto" class="form-control" id="selectquartos">
			<option value=""> -- Selecione -- </option>
			<?php foreach($quartos as $quarto){ ?>
			<option value="<?php echo $quarto->id_quarto ?>" <?php tagAs('selected',$quarto->id_quarto , $reserva->id_quarto ) ?> ><?php echo $quarto->perfil.' - Nº '.$quarto->numero ?> </option>
			<?php } ?>
	  </select>
	</div>
</div>
<div class="panel panel-primary">
  <div class="panel-heading">Clientes</div>
  <div class="panel-body">
  	 <div class="row">
		<div class="col-md-6 form-group">
		  <label>Cliente Titular da Reserva</label>
		  <select name="id_cliente" class="form-control" id="selectclientes" >
		  	<option value=""> -- Selecione -- </option>
		  	<?php foreach ($todos_clientes as $cliente){?>
		  		<option value="<?php echo $cliente->id_cliente?>" <?php tagAs('selected',$cliente->id_cliente, $reserva->id_cliente  )?> > <?php echo $cliente->cliente?> </option>	
		  	<?php }?>
		  </select>
		</div>
	</div>
  	<div class="row">
		<div class="col-md-12 form-group">
			<select name="clientes[]" class="form-control" id="duallist" multiple="true">
				<?php foreach($clientes as $cliente){ ?>
					<option value="<?php echo $cliente->id_cliente ?>" selected><?php echo $cliente->cliente ?> </option>
				<?php } ?>
			</select>
		</div>
  	</div>
  </div>
</div>

<div class="row">
	<div class="col-md-6 form-group">
	<label>Situação</label>
	    <select name="id_situacao" class="form-control">
			<option value=""> -- Selecione -- </option>
			<option value="1" <?php tagAs('selected',$reserva->id_situacao, 1) ?>> EM USO </option>
			<option value="2" <?php tagAs('selected',$reserva->id_situacao, 2) ?>> RESERVADO </option>
			<option value="4" <?php tagAs('selected',$reserva->id_situacao, 4) ?>> FINALIZADO </option>
			<option value="6" <?php tagAs('selected',$reserva->id_situacao, 6) ?>> CANCELADO </option>
	    </select>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	 <?php
		echo form_submit(array('name'=>'editar','class' =>'btn btn-success'),'Editar')." ";
		echo form_reset(array('name'=>'limpar','class' =>'btn btn-danger'),'Limpar');
	  ?>	
	</div>
	<div class="col-md-6 form-group">
		<a class="btn btn-info" href="<?php echo site_url();?>/reserva" class="button success">Voltar</a>  
	</div>
</div>

<?php
/**
* Ã�rea da tela responsÃ¡vel pela confirmaÃ§Ã£o de deleÃ§Ã£o dos dados
*/
	}else if($part =="deleting"){
		
	echo form_open('reserva/delete');
	echo form_hidden('id_reserva', $reserva->id_reserva);
?>
<div class="row">
	<div class="col-md-3 form-group">
	  <label>Entrada</label>
	  	<div class="input-group">
            <input type="datetime" class="form-control calendar" name="entrada" id="entrada" required value="<?php  echo dateTimeToBr( $reserva->entrada ) ?>"
            disabled="true"> 
            <span class="input-group-addon add-on">
                <span class="glyphicon glyphicon-calendar" data-time-icon="icon-time"></span>
            </span>
		</div>
	</div>
	<div class="col-md-3 form-group">
	  <label>Saída</label>
	  	<div class="input-group">
            <input type="datetime" class="form-control calendar" name="entrada" id="entrada" required value="<?php  echo dateTimeToBr( $reserva->saida ) ?>"
            disabled="true"> 
            <span class="input-group-addon add-on">
                <span class="glyphicon glyphicon-calendar" data-time-icon="icon-time"></span>
            </span>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3 form-group">
	  <label>Tipo Reserva</label>
	  <select name="id_tipo_reserva" class="form-control" id="tipo-quarto" disabled>
			<option value=""> -- Selecione -- </option>
			<option value="1" <?php echo ($reserva->tp_modo_reserva ==1 )?'selected':''; ?>>Diárias</option>
			<option value="2" <?php echo ($reserva->tp_modo_reserva ==2 )?'selected':''; ?>>Horas</option>
			<option value="3" <?php echo ($reserva->tp_modo_reserva ==3 )?'selected':''; ?>>Pernoites</option>
	  </select>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <label>Quarto</label>
	  <select name="id_quarto" class="form-control" id="selectquartos" disabled>
			<option value=""> -- Selecione -- </option>
			<?php foreach($quartos as $quarto){ ?>
			<option value="<?php echo $quarto->id_quarto ?>" <?php echo $quarto->id_quarto == $reserva->id_quarto?'selected':''; ?>><?php echo $quarto->perfil.' - Nº '.$quarto->numero ?> </option>
			<?php } ?>
	  </select>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	<label>Cliente</label>
	  <input type="text" value="<?php echo $reserva->cliente?>" class="form-control" disabled/>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	<label>Situação</label>
	    <select name="id_situacao" class="form-control" disabled>
			<option value=""> -- Selecione -- </option>
			<option value="1" <?php echo $reserva->id_situacao == 1?'selected':''; ?>> EM USO </option>
			<option value="2" <?php echo $reserva->id_situacao == 2?'selected':''; ?>> RESERVADO </option>
	    </select>
	</div>
</div>	
<div class="row">
	<div class="col-md-6 form-group">
	 <?php
		echo form_submit(array('name'=>'deletar','class' =>'btn btn-danger'),'Deletar')." ";
		//echo form_reset(array('name'=>'limpar','class' =>'btn btn-danger'),'Limpar');
	  ?>	
	</div>
	<div class="col-md-6 form-group">
		<a class="btn btn-info" href="<?php echo site_url();?>/reserva" class="button success">Voltar</a>  
	</div>
</div>

<?php
echo form_close();
}
?>

