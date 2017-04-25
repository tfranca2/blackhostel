<script>
$(document).ready(function(){
	$('#ip').mask('000.000.000.000');
});
</script>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Ã�rea da tela responsÃ¡vel pela pesquisa e exibiÃ§Ã£o da lista de resultados
*/
	if($part =="searching"){
	

?>

	<form action="<?php echo site_url();?>/impressora/searching">
	<div class="row">
		<div class="col-md-5 form-group">
			<input type="text" placeholder="Descrição da Impressora" name="descricao" class="form-control"/>
		</div>
		<div class="col-md-5 form-group">
			<input type="submit" name="submit" value="Buscar" class="btn btn-success">
		</div>
	</div>
	<div class="row">
		<div class="col-md-1 col-often-11 form-group pull-right">
			<a class="btn btn-info" href="<?php echo site_url();?>/impressora/inserting">Novo</a>
		</div>
	</div>
	</form>
	<div class="row">
		<div class="large-12 columns">
		<table class="table table table-striped table-bordered table-responsive"> 
			<tr>
				<th>ID</th>
				<th>Descrição</th>
				<th>IP</th>
				<th>Perfil</th>
				<th>Opções</th>
			</tr>
			<?php foreach($tabledata as $impressora){ ?>
			<tr>
				<td><?php echo $impressora->id_impressora ?></td>
				<td><?php echo $impressora->descricao ?></td>
				<td><?php echo $impressora->ip ?></td>
				<td><?php echo $impressora->perfil ?></td>
				<td>
					<a href="<?php echo site_url();?>/impressora/editing/<?php  echo $impressora->id_impressora ?>"
					class="btn btn-default btn-sm">Editar 
						<span class="glyphicon glyphicon-edit"></span>
					</a>
				
					<a href="<?php echo site_url();?>/impressora/deleting/<?php  echo $impressora->id_impressora ?>"
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
* Ã�rea da tela responsÃ¡vel pelo formulÃ¡rio de inserÃ§Ã£o de dados
*/
	}else if($part =="inserting"){
		
	echo form_open('impressora/save');	
?>

<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php
		echo form_label('Descricao');
		echo form_input(array('name'=>'descricao','class'=>'form-control','placeholder'=>'Descrição da impressora'),set_value('descricao'),'autofocus');
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-3 form-group">
	  <?php
		echo form_label('IP');
		echo form_input(array('name'=>'ip','id'=>'ip','class'=>'form-control','placeholder'=>'IP da impressora'),set_value('ip'));
	  ?>
	</div>
	<div class="col-md-3 form-group">
	  <?php
		echo form_label('Perfil');
		echo form_input(array('name'=>'perfil','id'=>'perfil','class'=>'form-control','placeholder'=>'Perfil da impressora'),set_value('perfil'));
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
		<a class="btn btn-info" href="<?php echo site_url();?>/impressora" class="button success">Voltar</a>  
	</div>
</div>

<?php 

/**
* Ã�rea da tela responsÃ¡vel pelo formulÃ¡rio de ediÃ§Ã£o de dados
*/
	}else if($part =="editing"){
		
	echo form_open('impressora/edit');
	echo form_hidden('id_impressora', $impressora->id_impressora);
?>

<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php
		echo form_label('Descrição');
		echo form_input(array('name'=>'descricao','class'=>'form-control','placeholder'=>'Descrição da impressora'),$impressora->descricao ,'autofocus');
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-3 form-group">
	  <?php
		echo form_label('IP');
		echo form_input(array('name'=>'ip','id'=>'ip','class'=>'form-control','placeholder'=>'IP da impressora'),$impressora->ip);
	  ?>
	</div>
	<div class="col-md-3 form-group">
	  <?php
		echo form_label('Perfil');
		echo form_input(array('name'=>'perfil','id'=>'perfil','class'=>'form-control','placeholder'=>'Perfil da impressora'),$impressora->perfil);
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
		<a class="btn btn-info" href="<?php echo site_url();?>/impressora" class="button success">Voltar</a>  
	</div>
</div>

<?php
/**
* Ã�rea da tela responsÃ¡vel pela confirmaÃ§Ã£o de deleÃ§Ã£o dos dados
*/
	}else if($part =="deleting"){
		
	echo form_open('impressora/delete');
	echo form_hidden('id_impressora', $impressora->id_impressora);
?>

<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php
		echo form_label('Descrição');
		echo form_input(array('name'=>'descricao','class'=>'form-control','readonly'=>'readonly'),$impressora->descricao);
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-3 form-group">
	  <?php
		echo form_label('IP');
		echo form_input(array('name'=>'ip','id'=>'ip','class'=>'form-control','readonly'=>'readonly'),$impressora->ip);
	  ?>
	</div>
	<div class="col-md-3 form-group">
	  <?php
		echo form_label('Perfil');
		echo form_input(array('name'=>'perfil','id'=>'perfil','class'=>'form-control','readonly'=>'readonly'),$impressora->perfil);
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
		<a class="btn btn-info" href="<?php echo site_url();?>/impressora" class="button success">Voltar</a>  
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
