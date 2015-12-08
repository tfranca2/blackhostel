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
* Área da tela responsável pela pesquisa e exibição da lista de resultados
*/
	if($part =="searching"){
	

?>


	<form action="<?php echo site_url();?>/produto/searching">
	<div class="row">
		<div class="col-md-5 form-group">
			<input type="text" placeholder="Descrição do produto" name="produto" class="form-control"/>
		</div>
		<div class="col-md-5 form-group">
			<input type="submit" name="submit" value="Buscar" class="btn btn-success">
		</div>
	</div>
	<div class="row">
		<div class="col-md-1 col-often-11 form-group pull-right">
			<?php if($gerente) { ?><a class="btn btn-info" href="<?php echo site_url();?>/produto/inserting">Novo</a><?php } ?>
		</div>
	</div>
	</form>
	<div class="row">
		<div class="large-12 columns">
		<table class="table table-striped table-bordered table-responsive"> 
			<tr>
				<th>ID</th>
				<th>Produto</th>
				<th>Preço</th>
				<?php if($gerente) { ?>
				<th>Opções</th>
				<?php } ?>
			</tr>
			<?php foreach($tabledata as $produto){ ?>
			<tr>
				<td><?php echo $produto->id_produto ?></td>
				<td width="50%"><?php echo $produto->produto ?></td>
				<td><?php echo "R$ ".monetaryOutput($produto->preco) ?></td>
				<?php if($gerente) { ?>
				<td>
					<a href="<?php echo site_url();?>/produto/editing/<?php  echo $produto->id_produto ?>" class="btn btn-default btn-sm">Editar 
						<span class="glyphicon glyphicon-edit"></span>
					</a>
				
					<a href="<?php echo site_url();?>/produto/deleting/<?php  echo $produto->id_produto ?>" class="btn btn-default btn-sm">Deletar 
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
* Área da tela responsável pelo formulário de inserção de dados
*/
	}else if($part =="inserting"){
		
	echo form_open('produto/save');	
?>

<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php
		echo form_label('Descrição');
		echo form_input(array('name'=>'produto','class'=>'form-control','placeholder'=>'Descrição do produto'),set_value('produto'),'autofocus');
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Preço');
		echo form_input(array('name'=>'preco','id'=>'preco','class'=>'form-control','placeholder'=>'Preço do produto'),set_value('preco'));
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
		<a class="btn btn-info" href="<?php echo site_url();?>/produto" class="button success">Voltar</a>  
	</div>
</div>

<?php 

/**
* Área da tela responsável pelo formulário de edição de dados
*/
	}else if($part =="editing"){
		
	echo form_open('produto/edit');
	echo form_hidden('id_produto', $produto->id_produto);
?>

<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php
		echo form_label('Descrição');
		echo form_input(array('name'=>'produto','class'=>'form-control','placeholder'=>'Descrição do produto'),$produto->produto ,'autofocus');
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Preço');
		echo form_input(array('name'=>'preco','id'=>'preco','class'=>'form-control','placeholder'=>'Preço do produto'),$produto->preco);
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
		<a class="btn btn-info" href="<?php echo site_url();?>/produto" class="button success">Voltar</a>  
	</div>
</div>

<?php
/**
* Área da tela responsável pela confirmação de deleção dos dados
*/
	}else if($part =="deleting"){
		
	echo form_open('produto/delete');
	echo form_hidden('id_produto', $produto->id_produto);
?>

<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php
		echo form_label('Descrição');
		echo form_input(array('name'=>'produto','class'=>'form-control','readonly'=>'readonly'),$produto->produto);
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Preço');
		echo form_input(array('name'=>'preco','id'=>'preco','class'=>'form-control','readonly'=>'readonly'),$produto->preco);
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
		<a class="btn btn-info" href="<?php echo site_url();?>/produto" class="button success">Voltar</a>  
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
