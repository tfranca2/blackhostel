<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$operacoes = array (
					1 => "Abertura de Caixa",
					2 => "Sangria",
					5 => "Venda",
					3 => "Ressuprimento",
					6 => "Compra",
					4 => "Fechamento de Caixa",
					0 => "Venda Avulso"
				);
				
?>
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
<script>
	$(document).ready(function(){
		$('#valor').mask('000.000.000.000.000,00', {reverse: true});

		
		$('label > input').click( function( event ){

			$('.produtos').hide();
			if( event.target.value == 1 || event.target.value == 4 ){
				$('#valor').val("");
				$('#valor').attr("disabled", "disabled");
			}else if(event.target.value == 0 && $(this).is(':checked')){
				$('.produtos').show();
				$('#valor').val("");
				$('#valor').attr("readonly", "true");
			}else {
				$('#valor').removeAttr("disabled");
			}
		});

		

		$('#newproduto').click( function( event ){
			console.log($('#newproduto option:selected').attr('valor'))
			
			$('#valor').val($('#newproduto option:selected').attr('valor'));
			$('#observacao').val($('#newproduto option:selected').attr('desc'));
			
			
		});
		
	});
</script>
<?php
	if($part =="show"){
	
?>
	<form action="<?php echo site_url();?>/caixa/show">
		<div class="row">
			<div class="col-md-1 col-often-11 form-group pull-right">
				<a class="btn btn-info" href="<?php echo site_url();?>/caixa/inserting">Adicionar</a>
			</div>
		</div>
	</form>
	<div class="row">
		<div class="large-12 columns">
		<table class="table table-bordered"> 
			<tr>
				<th>Operação</th>
				<th>
					<span class="glyphicon glyphicon-usd" aria-hidden="true"></span> 
				Valor
				</th>
				<th>Observação</th>
				<th>Usuário</th>
				<th>Data</th>
				<!-- <th>Opções</th> -->
			</tr>
			<?php 	
			$total = 0; 
			
			foreach($tabledata as $caixa){ 
				// TODO Wtf. Um hit no banco a cada iteração. 	
				$usuario = $this->db->get_where('usuario', array('id_usuario' => $caixa->id_usuario))->row();
				
				if( $caixa->operacao == 1 || $caixa->operacao == 3 || $caixa->operacao == 5 ) 
					// ressuprimento ou venda
					$total += $caixa->valor;
				if( $caixa->operacao == 2 || $caixa->operacao == 6 ) 
					// sangria ou compra
					$total -= $caixa->valor;
				
			?>
			<tr>
				<td>
				<?php
				echo ((($caixa->operacao==1)?
						'<span class="circle green"></span>'
						:(($caixa->operacao==2)?
								'<span class="circle red"></span>'
								:(($caixa->operacao==4)?
										'<span class="circle yellow"></span>'
										:'')))). $operacoes[$caixa->operacao]; 
				?></td>
				<td><?php echo ( $caixa->operacao==1 || $caixa->operacao==4 )?"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-":"R$ ".(($caixa->operacao==2 || $caixa->operacao==6)?'- ':"" ).monetaryOutput($caixa->valor); ?></td>
				<td><?php echo $caixa->observacao; ?></td>
				<td><?php echo $usuario->nome; ?></td>
				<td><?php echo dateTimeToBr($caixa->data); ?></td>
				
				<?php if(false){  ?>
					<td>
						<a href="<?php echo site_url();?>/caixa/editing/<?php  echo $caixa->id_caixa ?>">Editar 
							<span class="glyphicon glyphicon-edit"></span>
						</a>
					
						<a href="<?php echo site_url();?>/caixa/deleting/<?php  echo $caixa->id_caixa ?>">Deletar 
							<span class="glyphicon glyphicon-remove"></span>
						</a>
					</td>
				<?php }  ?>
			</tr>
			<?php }  ?>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<th>Total</th>
				<th><?php echo "R$ ". monetaryOutput($total); ?></th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
		</table> 
		</div>
	</div>
	
<?php 
/**
* Área da tela responsável pelo formulário de inserção de dados
*/
	} else if( $part =="inserting" ) {
		
	echo form_open('caixa/save');
	
	
?>

<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php	
		echo form_label('Operação:');
		echo "<br/>";
		foreach($operacoes as $chave => $valor ){
			if($chave>4) continue;
			echo "<label>".form_radio('operacao', $chave, false).$valor."</label><br/>";
		}
	  ?>
	</div>
</div>
<div class="row">	
	
	<div class="col-md-4 form-group produtos" style="display:none;" >
  		<label>Produto</label>
		  <select class="form-control" id="newproduto" name="id_produto" >
		  	<option value=""> -- Selecione -- </option>
		  	<?php foreach ($produtos as $produto){?>
	  		<option value="<?php echo $produto->id_produto?>" 
	  			valor="<?php echo monetaryOutput($produto->preco) ?>"
	  			desc="<?php echo $produto->produto ?>"
	  			> <?php echo $produto->produto.' - R$ '.monetaryOutput( $produto->preco) ?> </option>	
	  	<?php }?>
	  </select>
	  </div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Valor');
		echo form_input(array('name'=>'valor','id'=>'valor','class'=>'form-control','placeholder'=>'Valor da Operação'),set_value('valor'));
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Observação');
		echo form_textarea(array('name'=>'observacao','id'=>'observacao','class'=>'form-control','placeholder'=>'Observacao da Operação'),set_value('observacao'));
	  ?>
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
		<a class="btn btn-info" href="<?php echo site_url();?>/caixa" class="button success">Voltar</a>  
	</div>
</div>

<?php 

/**
* Área da tela responsável pelo formulário de edição de dados
*/
	}else if($part =="editing"){
		
	echo form_open('caixa/edit');
	echo form_hidden('id_caixa', $caixa->id_caixa);
?>

<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php	
		echo form_label('Operação:'); 
		echo "<br/>";
		foreach($operacoes as $chave => $valor ){
			if($chave>4) continue;
			echo "<label>".form_radio('operacao', $chave, (($caixa->operacao==$chave)?true:false) ).$valor."</label><br/>";
		}
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Valor');
		echo form_input(array('name'=>'valor','id'=>'valor','class'=>'form-control','placeholder'=>'Valor da Operação'), $caixa->valor);
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Observação');
		echo form_textarea(array('name'=>'observacao','id'=>'observacao','class'=>'form-control','placeholder'=>'Observacao da Operação'),$caixa->observacao);
	  ?>
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
		<a class="btn btn-info" href="<?php echo site_url();?>/caixa" class="button success">Voltar</a>  
	</div>
</div>

<?php
/**
* Área da tela responsável pela confirmação de deleção dos dados
*/
	}else if($part =="deleting"){
		
	echo form_open('caixa/delete');
	echo form_hidden('id_caixa', $caixa->id_caixa);
?>
<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php	
		echo form_label('Operação:'); 
		echo "<br/>";
		foreach($operacoes as $chave => $valor ){
			if($chave>4) continue;
			echo "<label>".form_radio('operacao', $chave, (($caixa->operacao==$chave)?true:false), 'disabled' ).$valor."</label><br/>";
		}
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Valor');
		echo form_input(array('name'=>'valor','id'=>'valor','class'=>'form-control','readonly'=>'readonly'),$caixa->valor);
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Observação');
		echo form_textarea(array('name'=>'observacao','id'=>'observacao','class'=>'form-control','readonly'=>'readonly'),$caixa->observacao);
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	 <?php
		echo form_submit(array('name'=>'deletar','class' =>'btn btn-danger'),'Deletar')." ";
	  ?>
	
	</div>
	<div class="col-md-6 form-group">
		<a class="btn btn-info" href="<?php echo site_url();?>/caixa" class="button success">Voltar</a>  
	</div>
</div>

<?php
echo form_close();
}
?>

