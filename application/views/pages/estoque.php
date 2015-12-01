<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$user = $this->session->get_userdata();
$gerente = $user['user_session']['gerente'];
$admin = $user['user_session']['admin'];

	if($part =="searching"){
?>

	<form action="<?php echo site_url();?>/estoque/searching">
	<div class="row">
		<div class="col-md-5 form-group">
			<input type="text" placeholder="Produto do estoque" name="produto" class="form-control"/>
		</div>
		<div class="col-md-5 form-group">
			<input type="submit" name="submit" value="Buscar" class="btn btn-success">
		</div>
	</div>
	<div class="row">
		<div class="col-md-1 col-often-11 form-group pull-right">
			<?php if($gerente) { ?><a class="btn btn-info" href="<?php echo site_url();?>/estoque/inserting">Adicionar</a><?php } ?>
		</div>
	</div>
	</form>
	<div class="row">
		<div class="large-12 columns">
		<table class="table table-responsive"> 
			<tr>
				<th>Produto</th>
				<th>Estoque</th>
			</tr>
			<?php foreach($tabledata as $estoque){ ?>
			<tr>
				<td><?php echo $estoque->produto ?></td>
				<td width="50%"><?php echo $estoque->quantidade ?></td>
			</tr>
			<?php } ?>
		</table> 
		</div>
	</div>
	
<?php 
	}else if($part =="inserting"){
		
		echo form_open('estoque/save');	
?>

<div class="row">
	<div class="col-md-6 form-group">
	  <label>Produto</label>
			  <select name="id_produto" class="form-control" id="selectprodutos" >
			  	<option value=""> -- Selecione -- </option>
			  	<?php foreach ($produtos as $produto){?>
			  		<option value="<?php echo $produto->id_produto?>"> <?php echo $produto->produto?> </option>	
			  	<?php }?>
			  </select>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php
		echo form_label('Quantidade');
		echo form_input(array('name'=>'quantidade','class'=>'form-control','placeholder'=>'Quantidade do estoque'),set_value('quantidade'));
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
		<a class="btn btn-info" href="<?php echo site_url();?>/estoque" class="button success">Voltar</a>  
	</div>
</div>

<?php } ?>

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
