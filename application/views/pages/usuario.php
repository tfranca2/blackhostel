<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Área da tela responsável pela pesquisa e exibição da lista de resultados
*/
	if($part =="searching"){
	

?>


	<form action="<?php echo site_url();?>/usuario/searching">
	<div class="row">
		<div class="col-md-5 form-group">
			<input type="text" placeholder="Nome do usuráio" name="nome" class="form-control"/>
		</div>
		<div class="col-md-5 form-group">
			<input type="submit" name="submit" value="Buscar" class="btn btn-sucess">
		</div>
	</div>
	<div class="row">
		<div class="col-md-1 col-often-11 form-group pull-right">
			<a class="btn btn-info" href="<?php echo site_url();?>/usuario/inserting">Novo</a>
		</div>
	</div>
	</form>
	<div class="row">
		<div class="large-12 columns">
		<table class="table table-responsive"> 
			<tr>
				<th>ID</th>
				<th>Nome</th>
				<th>Login</th>
				<th>Opções</th>
			</tr>
			<?php foreach($tabledata as $usuario){ ?>
			<tr>
				<td><?php echo $usuario->id_usuario ?></td>
				<td width="50%"><?php echo $usuario->nome ?></td>
				<td><?php echo $usuario->login ?></td>
				<td>
					<a href="<?php echo site_url();?>/usuario/editing/<?php  echo $usuario->id_usuario ?>">Editar 
						<span class="glyphicon glyphicon-edit"></span>
					</a>
				
					<a href="<?php echo site_url();?>/usuario/deleting/<?php  echo $usuario->id_usuario ?>">Deletar 
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
		
	echo form_open('usuario/save');	
?>

<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php
		echo form_label('Nome');
		echo form_input(array('name'=>'nome','class'=>'form-control','placeholder'=>'Nome do usuário'),set_value('nome'),'autofocus');
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Login');
		echo form_input(array('name'=>'login','id'=>'cpf','class'=>'form-control','placeholder'=>'E-mail do usuário'),set_value('login'));
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Senha');
		echo form_input(array('name'=>'senha','id'=>'senha','type'=>'password','class'=>'form-control','placeholder'=>'Senha do usuario'),set_value('senha'));
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
		<a class="btn btn-info" href="<?php echo site_url();?>/usuario" class="button success">Voltar</a>  
	</div>
</div>

<?php 

/**
* Área da tela responsável pelo formulário de edição de dados
*/
	}else if($part =="editing"){
		
	echo form_open('usuario/edit');
	echo form_hidden('id_usuario', $usuario->id_usuario);
?>

<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php
		echo form_label('Nome');
		echo form_input(array('name'=>'nome','class'=>'form-control','placeholder'=>'Nome do usuário'),$usuario->nome ,'autofocus');
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Login');
		echo form_input(array('name'=>'login','id'=>'login','class'=>'form-control','placeholder'=>'E-mail do usuário'),$usuario->login);
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Senha');
		echo form_input(array('name'=>'senha','id'=>'senha','type'=>'password','class'=>'form-control','placeholder'=>'Senha do usuário'),$usuario->senha);
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
		<a class="btn btn-info" href="<?php echo site_url();?>/usuario" class="button success">Voltar</a>  
	</div>
</div>

<?php
/**
* Área da tela responsável pela confirmação de deleção dos dados
*/
	}else if($part =="deleting"){
		
	echo form_open('usuario/delete');
	echo form_hidden('id_usuario', $usuario->id_usuario);
	echo form_hidden('senha', true);
?>

<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php
		echo form_label('Nome');
		echo form_input(array('name'=>'nome','class'=>'form-control','readonly'=>'readonly'),$usuario->nome);
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Login');
		echo form_input(array('name'=>'login','id'=>'login','class'=>'form-control','readonly'=>'readonly'),$usuario->login);
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
		<a class="btn btn-info" href="<?php echo site_url();?>/usuario" class="button success">Voltar</a>  
	</div>
</div>

<?php
echo form_close();
}
?>

<div class="row">
	
	<?php /* if(!empty(validation_errors())){ ?>
	<div class="alert alert-success">
		<?php echo validation_errors(); ?>
	</div>
	<?php } ?>
	
	
	<?php  if(!empty($this->session->flashdata('msg'))){ ?>
	<div class="alert alert-success">
	  <?php echo $this->session->flashdata('msg'); ?>	
	</div>
	<?php } */ ?>
</div>	
