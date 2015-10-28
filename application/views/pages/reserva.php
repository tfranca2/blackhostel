<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<script>
	$(document).ready(function(){
	
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
			},
			onSelect: function(){
				$('#tipo-quarto').prop('selectedIndex',0);
			}
		});
		
		
		$("#tipo-quarto").on('change', function(){
           loadQuartos();
		   if($("#tipo-quarto").val() == 1){
			$("#saida").attr("required","true");
		   }else{
			$("#saida").removeAttr("required");
		   }
         });
		 
		 function loadQuartos(){
			$('#selectquartos').empty();
 			var url =  "<?php echo site_url()."/reserva/quartos/" ;?>"+ $("#tipo-quarto").val()+"/"+<?php echo ($this->uri->segment(3))?$this->uri->segment(3):'0'; ?>;
			console.log(url);
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
							
							$('#selectquartos').append( '<option value="' + quarto.id_quarto+ '" '+sel+'>'+ quarto.descricao+ '</option>' ); 
						});	
					}
			});
		 }
		
	});
</script>

<?php 
/**
* Área da tela responsável pela pesquisa e exibição da lista de resultados
*/
	if($part =="searching"){
?>
	<form action="<?php echo site_url();?>/reserva/searching">
	<div class="row">
		<div class="col-md-5 form-group">
			<label>Descrição</label>
			<input type="text" placeholder="Descrição do Reserva" name="descricao" class="form-control"/>
		</div>
	</div>
	<div class="row">
		<div class="col-md-5 form-group">
			<input type="submit" name="submit" value="Buscar" class="btn btn-sucess">
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
		<table class="table table-responsive"> 
			<tr>
				<th>ID</th>
				<th>Quarto</th>
				<th>Cliente</th>
				<th>Perfil</th>
				<th>Tipo Reserva</th>
				<th>Entrada</th>
				<th>Saída</th>
				<th>Situação</th>
				<th>Opções</th>
			</tr>
			<?php foreach($tabledata as $reserva){?>
			<tr>
				<td><?php echo $reserva->id_reserva ?></td>
				<td><?php echo $reserva->ds_quarto ?></td>
				<td><?php echo $reserva->cliente ?></td>
				<td><?php echo $reserva->descricao ?></td>
				<td><?php echo $reserva->tp_modo_reserva ==1?'Diária':'Hora'; ?></td>
				<td><?php echo dateTimeToBr( $reserva->entrada ) ?></td>
				<td><?php echo dateTimeToBr( $reserva->saida ) ?></td>
				<td><?php
						 if($reserva->id_situacao ==1){
							echo 'EM USO';
						 }else if($reserva->id_situacao == 2){ 
							echo 'RESERVADO';
						 }else if($reserva->id_situacao == 3){
							echo 'LIVRE';
						 }else if($reserva->id_situacao == 4){
							echo 'MANUTENÇÃO';
						 }
					?>
				</td>
				<td>
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
* Área da tela responsável pelo formulário de inserção de dados
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
<div class="row">
	<div class="col-md-6 form-group">
	  <label>Quarto</label>
	  <select name="id_cliente" class="form-control" id="selectclientes" >
	  	<option value=""> -- Selecione -- </option>
	  	<?php foreach ($clientes as $cliente){?>
	  		<option value="<?php echo $cliente->id_cliente?>"> <?php echo $cliente->cliente?> </option>	
	  	<?php }?>
	  </select>
	</div>
</div>

<div class="row">
	<div class="col-md-6 form-group">
	  
	</div>
</div>
<br/><br/>
<br/><br/>
<br/>
<br/>
<br/>
<br/>

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
* Área da tela responsável pelo formulário de edição de dados
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
            <?php echo ($reserva->id_situacao == 2)?'':'disabled'; ?>> 
            <span class="input-group-addon add-on">
                <span class="glyphicon glyphicon-calendar" data-time-icon="icon-time"></span>
            </span>
		</div>
	</div>
	<div class="col-md-3 form-group">
	  <label>Saída</label>
	  	<div class="input-group">
            <input type="datetime" class="form-control calendar" name="saida" id="saida" required value="<?php  echo dateTimeToBr( $reserva->saida ) ?>"
            <?php echo ($reserva->id_situacao == 2)?'':'disabled'; ?>> 
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
			<option value="1" <?php echo ($reserva->tp_modo_reserva ==1 )?'selected':''; ?>>Diárias</option>
			<option value="2" <?php echo ($reserva->tp_modo_reserva ==2 )?'selected':''; ?>>Horas</option>
	  </select>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <label>Quarto</label>
	  <select name="id_quarto" class="form-control" id="selectquartos">
			<option value=""> -- Selecione -- </option>
			<?php foreach($quartos as $quarto){ ?>
			<option value="<?php echo $quarto->id_quarto ?>" <?php tagAsSelected($quarto->id_quarto , $reserva->id_quarto ) ?> ><?php echo $quarto->descricao ?> </option>
			<?php } ?>
	  </select>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <label>Quarto</label>
	  <select name="id_cliente" class="form-control" id="selectclientes" >
	  	<option value=""> -- Selecione -- </option>
	  	<?php foreach ($clientes as $cliente){?>
	  		<option value="<?php echo $cliente->id_cliente?>" <?php tagAsSelected($cliente->id_cliente, $reserva->id_cliente  )?> > <?php echo $cliente->cliente?> </option>	
	  	<?php }?>
	  </select>
	</div>
</div>
<?php dump($reserva)?>
<div class="row">
	<div class="col-md-6 form-group">
	<label>Situação</label>
	    <select name="id_situacao" class="form-control">
			<option value=""> -- Selecione -- </option>
			<option value="1" <?php echo $reserva->id_situacao == 1?'selected':''; ?>> EM USO </option>
			<option value="2" <?php echo $reserva->id_situacao == 2?'selected':''; ?>> RESERVADO </option>
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
* Área da tela responsável pela confirmação de deleção dos dados
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
	  </select>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <label>Quarto</label>
	  <select name="id_quarto" class="form-control" id="selectquartos" disabled>
			<option value=""> -- Selecione -- </option>
			<?php foreach($quartos as $quarto){ ?>
			<option value="<?php echo $quarto->id_quarto ?>" <?php echo $quarto->id_quarto == $reserva->id_quarto?'selected':''; ?>><?php echo $quarto->descricao ?> </option>
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

<div class="row">
	
	<?php  if(!empty(validation_errors())){ ?>
	<div class="alert alert-danger">
		<?php echo validation_errors(); ?>
	</div>
	<?php } ?>
	
	<?php  if(!empty($this->session->flashdata('msg'))){ ?>
	<div class="alert alert-success">
	  <?php echo $this->session->flashdata('msg'); ?>	
	</div>
	<?php } ?>
</div>	
