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
	</form>
	<div class="row">
		<div class="large-12 columns">
		<table class="table table-striped table-bordered table-responsive"> 
			<tr>
				<th>Produto</th>
				<th>Estoque</th>
				<th>Opções</th>
			</tr>
			<?php foreach($tabledata as $produto){ ?>
			<tr>
				<td><?php echo $produto->produto ?></td>
				<td><?php echo $produto->estoque ?></td>
				<td> <center>
					<a href="<?php echo site_url();?>/estoque/editing/<?php  echo $produto->id_produto ?>">Editar 
							<span class="glyphicon glyphicon-edit"></span>
						</a>
					</center>
				</td>
			</tr>
			<?php } ?>
		</table> 
		</div>
	</div>
	
<?php 
	}else if($part =="editing"){
		
		echo form_open('estoque/edit');	
		
		echo form_hidden('id_produto',$produto->id_produto);
?>

<div class="row">
	<div class="col-md-6 form-group">
	<?php
		echo form_label('Produto');
		echo form_input(array('name'=>'produto','id'=>'produto','class'=>'form-control','placeholder'=>'Descrição do produto','disabled'=>'disabled'), $produto->produto);
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php
		echo form_label('Estoque');
		echo form_input(array('name'=>'estoque','class'=>'form-control','placeholder'=>'Quantidade do estoque do produto'), $produto->estoque);
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	 <?php
		echo form_submit(array('name'=>'cadastrar','class' =>'btn btn-success'),'Cadastrar')." ";
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
