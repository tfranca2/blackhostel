<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
?>
<script>
	$(document).ready(function(){
		$('#numero').mask('9999');
		
		$(".detail").click(function(){
                 
			$.ajax({
					url: $(this).attr('href'),
					type: 'GET',
					success: function(data){
						obj = JSON.parse(data);
						console.log(obj);
						console.log(obj.quarto.ds_quarto);
						$('#description').val(obj.quarto.ds_quarto);
						$('#number').val(obj.quarto.numero);
						$('#perfil').val(obj.perfil.descricao);
						$('#total-price').val(obj.perfil.total);
						
						if(obj.perfil.tp_modo_reserva ==1){
							modo_reserva = 'Diária';
						}else if(obj.perfil.tp_modo_reserva ==2){
							modo_reserva = 'Hora';
						}
						$('#type').val( modo_reserva );
						
						
						$('#myModal').modal('show');
					}
				});
                        return false;
         });
		
	});
</script>

<?php 
/**
* Área da tela responsável pela pesquisa e exibição da lista de resultados
*/
	if($part =="searching"){

	
?>

	<form action="<?php echo site_url();?>/quarto/searching">
	<div class="row">
		<div class="col-md-3 form-group">
			<label>Descrição</label>
			<input type="text" placeholder="Descrição do quarto" name="descricao" class="form-control"/>
		</div>
		<div class="col-md-3 form-group">
			<label>Perfil</label>
			<select name="id_per" class="form-control">
					<option value="" > -- Selecione -- </option>
				<?php foreach($perfils as $perfil){ ?>
					<option value="<?php echo $perfil->id_perfil ?>" ><?php echo $perfil->descricao ?> </option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-3 form-group">
			<label>&nbsp;</label>
			<input type="submit" name="submit" value="Buscar" style="display: block; border: 1px solid #ccc;" class="btn btn-sucess">
		</div>
	</div>
	<div class="row">
		<div class="col-md-1 col-often-11 form-group pull-right">
			<a class="btn btn-info" href="<?php echo site_url();?>/quarto/inserting">Novo</a>
		</div>
	</div>
	</form>
	<div class="row">
		<div class="large-12 columns">
		<table class="table table-responsive"> 
			<tr>
				<th>ID</th>
				<th>Descrição</th>
				<th>Número</th>
				<th>Perfil de Quarto</th>
				<th style="width:25%; align:center;">Opções</th>
			</tr>
			<?php foreach($tabledata as $quarto){ ?>
			<tr>
				<td><?php echo $quarto->id_quarto ?></td>
				<td><?php echo $quarto->ds_quarto ?></td>
				<td><?php echo $quarto->numero ?></td>
				<td><?php echo $quarto->ds_perfil ?></td>
				<td>
					<a href="<?php echo site_url();?>/quarto/detail/<?php  echo $quarto->id_quarto ?>" class="btn btn-default btn-sm detail">Detalhes 
						<span class="glyphicon glyphicon-search"></span>
					</a>
					
					<a href="<?php echo site_url();?>/quarto/editing/<?php  echo $quarto->id_quarto ?>" class="btn btn-default btn-sm">Editar 
						<span class="glyphicon glyphicon-edit"></span>
					</a>
				
					<a href="<?php echo site_url();?>/quarto/deleting/<?php  echo $quarto->id_quarto ?>" class="btn btn-default btn-sm">Deletar 
						<span class="glyphicon glyphicon-remove"></span>
					</a>
				</td>
			</tr>
			<?php } ?>
		</table> 
		</div>
	</div>
	
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Detalhamento de Quarto</h4>
		  </div>
		  <div class="modal-body">
				<div class="row">
					<div class="col-md-6 form-group">
						<label>	Descrição </label>
						<input text="text" disabled id="description" class="form-control"/>	
					</div>
					<div class="col-md-3 form-group">
						<label>	Número </label>
						<input text="text" disabled id="number" class="form-control"/>	
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 form-group">
						<label>	Perfil </label>
						<input text="text" disabled id="perfil" class="form-control"/>	
					</div>
					<div class="col-md-3 form-group">
						<label>	Preço Total </label>	
						<div class="input-group">
						  <div class="input-group-addon">R$</div>
						  <input type="text" class="form-control" id="total-price" disabled />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 form-group">
						<label>	Tipo De Reserva </label>
						<input type="text" class="form-control" id="type" disabled />
					</div>
				</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
		  </div>
		</div>
	  </div>
	</div>
	
<?php 
/**
* Área da tela responsável pelo formulário de inserção de dados
*/
	}else if($part =="inserting"){
		
	echo form_open('quarto/save');	
?>

<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php
		echo form_label('Descrição');
		echo form_input(array('name'=>'descricao','class'=>'form-control','placeholder'=>'Descrição do quarto'),set_value('descricao'),'autofocus');
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Número');
		echo form_input(array('name'=>'numero','id'=>'preco','class'=>'form-control','placeholder'=>'Número do quarto'),set_value('numero'));
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <label>Perfil</label>
	  <select name="id_perfil" class="form-control">
	  <option > -- Selecione -- </option>
			<?php foreach($perfils as $perfil){ ?>
				<option value="<?php echo $perfil->id_perfil ?>"><?php echo $perfil->descricao.' - R$ '.$perfil->preco_base ?> </option>
			<?php } ?>
	  </select>
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
		<a class="btn btn-info" href="<?php echo site_url();?>/quarto" class="button success">Voltar</a>  
	</div>
</div>

<?php 

/**
* Área da tela responsável pelo formulário de edição de dados
*/
	}else if($part =="editing"){
		
	echo form_open('quarto/edit');
	echo form_hidden('id_quarto', $quarto->id_quarto);
?>

<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php
		echo form_label('Descrição');
		echo form_input(array('name'=>'descricao','class'=>'form-control','placeholder'=>'Descrição do quarto'),$quarto->ds_quarto ,'autofocus');
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Número');
		echo form_input(array('name'=>'numero','id'=>'preco','class'=>'form-control','placeholder'=>'Número do quarto'),$quarto->numero);
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <label>Perfil</label>
	  <select name="id_perfil" class="form-control">
	  <option > -- Selecione -- </option>
			<?php foreach($perfils as $perfil){ ?>
				<option value="<?php echo $perfil->id_perfil ?>" <?php echo ($perfil->id_perfil == $quarto->idperfil)?'selected="true"':'' ?> ><?php echo $perfil->descricao.' - R$ '.$perfil->preco_base ?> </option>
			<?php } ?>
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
		<a class="btn btn-info" href="<?php echo site_url();?>/quarto" class="button success">Voltar</a>  
	</div>
</div>

<?php
/**
* Área da tela responsável pela confirmação de deleção dos dados
*/
	}else if($part =="deleting"){
		
	echo form_open('quarto/delete');
	echo form_hidden('id_quarto', $quarto->id_quarto);
?>

<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php
		echo form_label('Descrição');
		echo form_input(array('name'=>'descricao','class'=>'form-control','disabled'=>'true'),$quarto->ds_quarto);
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Número');
		echo form_input(array('name'=>'numero','id'=>'preco','class'=>'form-control','disabled'=>'true'),$quarto->numero);
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <label>Perfil</label>
	  <select name="id_perfil" class="form-control" disabled="true">
			<option > -- Selecione -- </option>
			<?php foreach($perfils as $perfil){ ?>
				<option value="<?php echo $perfil->id_perfil ?>" <?php echo ($perfil->id_perfil == $quarto->idperfil)?'selected="true"':'' ?> ><?php echo $perfil->descricao.' - R$ '.$perfil->preco_base ?> </option>
			<?php } ?>
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
		<a class="btn btn-info" href="<?php echo site_url();?>/quarto" class="button success">Voltar</a>  
	</div>
</div>

<?php
echo form_close();
}
?>

<div class="row">
	
	<?php /* if(!empty(validation_errors())){ ?>
	<div class="alert alert-danger">
		<?php echo validation_errors(); ?>
	</div>
	<?php } ?>
	
	
	<?php  if(!empty($this->session->flashdata('msg'))){ ?>
	<div class="alert alert-success">
	  <?php echo $this->session->flashdata('msg'); ?>	
	</div>
	<?php } */ ?>
</div>	
