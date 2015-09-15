<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
?><!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/foundation.css"/>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-latest.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.mask.min.js"></script>
<meta charset="utf-8">
<title>Welcome to CodeIgniter</title>
<script>
	$(document).ready(function(){
		$('#preco').mask('000.000.000.000.000,00', {reverse: true});
	});
</script>
</head>
<body>
<div id="row">
	<h1>Cadastro de Item</h1>
	
		<?php 
		/**
		* Área da tela responsável pela pesquisa e exibição da lista de resultados
		*/
			if($part =="search"){
		?>
		
			<div class="row">
				<p> Consulta </p>
				<a href="<?php echo site_url();?>/item/insert">Novo</a>
			</div>
			<div class="row">
				<form action="<?php echo site_url();?>/item/search">
				<div class="large-4 columns">
				
					<label>Descrição
						<input type="text" placeholder="Descrição do item" name="descricao" />
					</label>	
					<input type="submit" name="submit" value="Buscar" class="button success">
				
				</div>				
				</form>
				<hr>
			
			</div>
			<div class="row">
				<table> 
					<tr>
						<th>ID</th>
						<th>Descrição</th>
						<th>Preço</th>
						<th>Opções</th>
					</tr>
					<?php foreach($tabledata as $item){ ?>
					<tr>
						<td><?php echo $item->id_item ?></td>
						<td><?php echo $item->descricao ?></td>
						<td><?php echo $item->preco ?></td>
						<th></th>
					</tr>
					<?php } ?>
				</table> 
			</div>
			
		<?php 
		/**
		* Área da tela responsável pelo formulário de inserção de dados
		*/
			}else if($part =="insert"){
				
			echo form_open('item/save');	
		?>
	
	    <div class="row">
			<div class="large-4 columns">		  
			  <?php
				echo form_label('Descrição');
				echo form_input(array('name'=>'descricao','placeholder'=>'Descrição do item'),set_value('descricao'),'autofocus');
			  ?>
			</div>
	    </div>
		<div class="row">
			<div class="large-4 columns">
			  <?php
				echo form_label('Preço');
				echo form_input(array('name'=>'preco','placeholder'=>'Preço do item'),set_value('preco'));
			  ?>
			</div>
		</div>
		<div class="row">
			<div class="large-4 columns">
			 <?php
				echo form_submit(array('name'=>'cadastrar','class' =>'button success'),'Cadastrar')." ";
				echo form_reset(array('name'=>'limpar','class' =>'button success'),'Limpar');
			  ?>
			 <a href="<?php echo site_url();?>/item" class="button success">Voltar</a>  
			</div>
		</div>
		
		<?php echo form_close(); ?>
		
		<div class="row">
			<?php echo validation_errors(); ?>
			
			<?php if(!empty($msg)){ ?>
			<div data-alert class="alert-box success radius">
			  <?php echo @$msg; ?>
			  <a href="#" class="close">&times;</a>
			</div>
			<?php } ?>
		</div>	
		
		<?php } ?>


</div>

</body>
</html>