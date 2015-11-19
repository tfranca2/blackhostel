<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Área da tela responsável pela pesquisa e exibição da lista de resultados
*/
	if($part =="searching"){
	

?>


	<form action="<?php echo site_url();?>/cliente/searching">
	<div class="row">
		<div class="col-md-5 form-group">
			<input type="text" placeholder="Nome do cliente" name="cliente" class="form-control"/>
		</div>
		<div class="col-md-5 form-group">
			<input type="submit" name="submit" value="Buscar" class="btn btn-sucess">
		</div>
	</div>
	<div class="row">
		<div class="col-md-1 col-often-11 form-group pull-right">
			<a class="btn btn-info" href="<?php echo site_url();?>/cliente/inserting">Novo</a>
		</div>
	</div>
	</form>
	<div class="row">
		<div class="large-12 columns">
		<table class="table table-responsive"> 
			<tr>
				<th>ID</th>
				<th>Cliente</th>
				<th>CPF</th>
				<th>RG</th>
				<th>Telefone</th>
				<th>Endereço</th>
				<th>Opções</th>
			</tr>
			<?php foreach($tabledata as $cliente){ ?>
			<tr>
				<td><?php echo $cliente->id_cliente ?></td>
				<td width="30%"><?php echo $cliente->cliente ?></td>
				<td><?php echo $cliente->cpf ?></td>
				<td><?php echo $cliente->rg ?></td>
				<td><?php echo $cliente->telefone ?></td>
				<td><?php echo $cliente->endereco .' - '.$cliente->cep ?></td>
				<td>
					<a href="<?php echo site_url();?>/cliente/editing/<?php  echo $cliente->id_cliente ?>"
					class="btn btn-default btn-sm">Editar 
						<span class="glyphicon glyphicon-edit"></span>
					</a>
				
					<a href="<?php echo site_url();?>/cliente/deleting/<?php  echo $cliente->id_cliente ?>"
					class="btn btn-default btn-sm">Deletar 
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
		
	echo form_open('cliente/save');	
?>

<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php
		echo form_label('Nome');
		echo form_input(array('name'=>'cliente','class'=>'form-control','placeholder'=>'Nome do cliente'),set_value('cliente'),'autofocus');
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('CPF');
		echo form_input(array('name'=>'cpf','id'=>'cpf','class'=>'form-control','placeholder'=>'CPF do cliente'),set_value('cpf'));
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('RG');
		echo form_input(array('name'=>'rg','id'=>'rg','class'=>'form-control','placeholder'=>'RG do cliente'),set_value('rg'));
	  ?>
	</div>
</div>


<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Endereço');
		echo form_input(array('name'=>'endereco','id'=>'endereco','class'=>'form-control','placeholder'=>'Endereço do cliente'),set_value('endereco'));
	  ?>
	</div>
</div>

<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('CEP');
		echo form_input(array('name'=>'cep','id'=>'cep','class'=>'form-control','placeholder'=>'CEP do cliente'),set_value('cep'));
	  ?>
	</div>
</div>

<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Telefone');
		echo form_input(array('name'=>'telefone','id'=>'telefone','class'=>'form-control','placeholder'=>'Telefone do cliente'),set_value('telefone'));
	  ?>
	</div>
</div>

<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Observação');
		echo form_input(array('name'=>'observacao','id'=>'observacao','class'=>'form-control','placeholder'=>'Observacao'),set_value('observacao'));
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
		<a class="btn btn-info" href="<?php echo site_url();?>/cliente" class="button success">Voltar</a>  
	</div>
</div>

<?php 

/**
* Área da tela responsável pelo formulário de edição de dados
*/
	}else if($part =="editing"){
		
	echo form_open('cliente/edit');
	echo form_hidden('id_cliente', $cliente->id_cliente);
?>

<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php
		echo form_label('Nome');
		echo form_input(array('name'=>'cliente','class'=>'form-control','placeholder'=>'Nome do cliente'),$cliente->cliente ,'autofocus');
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('CPF');
		echo form_input(array('name'=>'cpf','id'=>'cpf','class'=>'form-control','placeholder'=>'CPF do cliente'),$cliente->cpf);
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('RG');
		echo form_input(array('name'=>'rg','id'=>'rg','class'=>'form-control','placeholder'=>'RG do cliente'),$cliente->rg);
	  ?>
	</div>
</div>

<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Endereço');
		echo form_input(array('name'=>'endereco','id'=>'endereco','class'=>'form-control','placeholder'=>'Endereço do cliente'),$cliente->endereco);
	  ?>
	</div>
</div>

<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('CEP');
		echo form_input(array('name'=>'cep','id'=>'cep','class'=>'form-control','placeholder'=>'CEP do cliente'),$cliente->cep);
	  ?>
	</div>
</div>

<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Telefone');
		echo form_input(array('name'=>'telefone','id'=>'telefone','class'=>'form-control','placeholder'=>'Telefone do cliente'),$cliente->telefone);
	  ?>
	</div>
</div>

<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Observação');
		echo form_input(array('name'=>'observacao','id'=>'observacao','class'=>'form-control','placeholder'=>'Observacao'),$cliente->observacao);
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
		<a class="btn btn-info" href="<?php echo site_url();?>/cliente" class="button success">Voltar</a>  
	</div>
</div>

<?php
/**
* Área da tela responsável pela confirmação de deleção dos dados
*/
	}else if($part =="deleting"){
		
	echo form_open('cliente/delete');
	echo form_hidden('id_cliente', $cliente->id_cliente);
?>

<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php
		echo form_label('Nome');
		echo form_input(array('name'=>'cliente','class'=>'form-control','readonly'=>'readonly'),$cliente->cliente);
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('CPF');
		echo form_input(array('name'=>'cpf','id'=>'cpf','class'=>'form-control','readonly'=>'readonly'),$cliente->cpf);
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('RG');
		echo form_input(array('name'=>'rg','id'=>'rg','class'=>'form-control','readonly'=>'readonly'),$cliente->rg);
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
		<a class="btn btn-info" href="<?php echo site_url();?>/cliente" class="button success">Voltar</a>  
	</div>
</div>

<?php
echo form_close();
}
?>

<div class="row">
	
	<?php if(!empty(validation_errors())){ ?>
	<div class="alert alert-success">
		<?php echo validation_errors(); ?>
	</div>
	<?php } ?>
	
	
	<?php  if(!empty($this->session->flashdata('msg'))){ ?>
	<div class="alert alert-success">
	  <?php echo $this->session->flashdata('msg'); ?>	
	</div>
	<?php } ?>
</div>	
