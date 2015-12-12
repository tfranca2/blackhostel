
<?php
defined('BASEPATH') OR exit('No direct script access allowed');



 
$user = $this->session->get_userdata();
$gerente = $user['user_session']['gerente'];
$admin = $user['user_session']['admin'];
 
?>
<script>
	$(document).ready(function(){
		$('#preco').mask('000.000.000.000.000,00', {reverse: true});
	});
</script>

<?php 
/**
* Ã�rea da tela responsÃ¡vel pela pesquisa e exibiÃ§Ã£o da lista de resultados
*/
	if($part =="searching"){
	

?>


	<form action="<?php echo site_url();?>/item/searching">
	<div class="row">
		<div class="col-md-5 form-group">
			<input type="text" placeholder="Descrição do item" name="descricao" class="form-control"/>
		</div>
		<div class="col-md-5 form-group">
			<input type="submit" name="submit" value="Buscar" class="btn btn-success">
		</div>
	</div>
	<div class="row">
		<div class="col-md-1 col-often-11 form-group pull-right">
			<?php if($gerente) { ?><a class="btn btn-info" href="<?php echo site_url();?>/item/inserting">Novo</a><?php } ?>
		</div>
	</div>
	</form>
	<div class="row">
		<div class="large-12 columns">
		<table class="table table-striped table-bordered table-responsive"> 
			<tr>
				<th>ID</th>
				<th>Descrição</th>
				<th>Preço</th>
				<?php if($gerente) { ?><th>Opções</th><?php } ?>
			</tr>
			<?php foreach($tabledata as $item){ ?>
			<tr>
				<td><?php echo $item->id_item ?></td>
				<td width="70%"><?php echo $item->descricao ?></td>
				<td><?php echo "R$ ".monetaryOutput($item->preco) ?></td>
				<?php if($gerente) { ?><td>
					<a href="<?php echo site_url();?>/item/editing/<?php  echo $item->id_item ?>" class="btn btn-default btn-sm">Editar 
						<span class="glyphicon glyphicon-edit"></span>
					</a>
				
					<a href="<?php echo site_url();?>/item/deleting/<?php  echo $item->id_item ?>" class="btn btn-default btn-sm">Deletar 
						<span class="glyphicon glyphicon-remove"></span>
					</a>
				</td><?php } ?>
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
		
	echo form_open('item/save');	
?>

<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php
		echo form_label('Descrição');
		echo form_input(array('name'=>'descricao','class'=>'form-control','placeholder'=>'Descrição do item'),set_value('descricao'),'autofocus');
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Preço');
		echo form_input(array('name'=>'preco','id'=>'preco','class'=>'form-control','placeholder'=>'Preço do item'),set_value('preco'));
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
		<a class="btn btn-info" href="<?php echo site_url();?>/item" class="button success">Voltar</a>  
	</div>
</div>

<?php 

/**
* Ã�rea da tela responsÃ¡vel pelo formulÃ¡rio de ediÃ§Ã£o de dados
*/
	}else if($part =="editing"){
		
	echo form_open('item/edit');
	echo form_hidden('id_item', $item->id_item);
?>

<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php
		echo form_label('Descrição');
		echo form_input(array('name'=>'descricao','class'=>'form-control','placeholder'=>'Descrição do item'),$item->descricao ,'autofocus');
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Preço');
		echo form_input(array('name'=>'preco','id'=>'preco','class'=>'form-control','placeholder'=>'Preço do item'),$item->preco);
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
		<a class="btn btn-info" href="<?php echo site_url();?>/item" class="button success">Voltar</a>  
	</div>
</div>

<?php
/**
* Ã�rea da tela responsÃ¡vel pela confirmaÃ§Ã£o de deleÃ§Ã£o dos dados
*/
	}else if($part =="deleting"){
		
	echo form_open('item/delete');
	echo form_hidden('id_item', $item->id_item);
?>

<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php
		echo form_label('Descrição');
		echo form_input(array('name'=>'descricao','class'=>'form-control','readonly'=>'readonly'),$item->descricao);
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Preço');
		echo form_input(array('name'=>'preco','id'=>'preco','class'=>'form-control','readonly'=>'readonly'),$item->preco);
	  ?>
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
		<a class="btn btn-info" href="<?php echo site_url();?>/item" class="button success">Voltar</a>  
	</div>
</div>

<?php
echo form_close();
}
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
