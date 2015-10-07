<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
?>
<script>
	$(document).ready(function(){
		$('#preco').mask('000.000.000.000.000,00', {reverse: true});
		$('#duallist').DualListBox({json:false, available:'Disponiveis', selected:'Selecionados',showing:'mostrando',filterLabel:'Filtro'});
	});
</script>

<?php 
/**
* Área da tela responsável pela pesquisa e exibição da lista de resultados
*/
	if($part =="searching"){
	

?>


	<form action="<?php echo site_url();?>/perfil/searching">
	<div class="row">
		<div class="col-md-5 form-group">
			<label>Descrição</label>
			<input type="text" placeholder="Descrição do perfil" name="descricao" class="form-control"/>
		</div>
		<div class="col-md-5 form-group">
			<input type="submit" name="submit" value="Buscar" class="btn btn-sucess">
		</div>
	</div>
	<div class="row">
		<div class="col-md-1 col-often-11 form-group pull-right">
			<a class="btn btn-info" href="<?php echo site_url();?>/perfil/inserting">Novo</a>
		</div>
	</div>
	</form>
	<div class="row">
		<div class="large-12 columns">
		<table class="table table-responsive"> 
			<tr>
				<th>ID</th>
				<th>Descrição</th>
				<th>Reserva</th>
				<th>Preço Perfil</th>
				<th>Preço Itens (Soma)</th>
				<th>Total Perfil</th>
				<th>Opções</th>
			</tr>
			<?php foreach($tabledata as $perfil){ ?>
			<tr>
				<td><?php echo $perfil->id_perfil ?></td>
				<td><?php echo $perfil->descricao ?></td>
				<td><?php echo $perfil->tp_modo_reserva == 1?'Diária':'Hora'; ?></td>
				<td><?php echo monetaryOutput($perfil->preco_base) ?> R$</td>
				<td><?php echo monetaryOutput($perfil->preco_itens) ?> R$</td>
				<td><?php echo monetaryOutput($perfil->preco_base + $perfil->preco_itens) ?> R$</td>
				<td>
					<a href="<?php echo site_url();?>/perfil/editing/<?php  echo $perfil->id_perfil ?>" class="btn btn-default btn-sm">Editar 
						<span class="glyphicon glyphicon-edit"></span>
					</a>
				
					<a href="<?php echo site_url();?>/perfil/deleting/<?php  echo $perfil->id_perfil ?>" class="btn btn-default btn-sm">Deletar 
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
		
	echo form_open('perfil/save');	
?>

<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php
		echo form_label('Descrição');
		echo form_input(array('name'=>'descricao','class'=>'form-control','placeholder'=>'Descrição do perfil'),set_value('descricao'),'autofocus');
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Preço');
		echo form_input(array('name'=>'preco_base','id'=>'preco','class'=>'form-control','placeholder'=>'Preço base do perfil'),set_value('preco'));
		
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
		<label>Modalidade de Reserva</label>
		<select name="tp_modo_reserva" class="form-control" required="true">
				<option value=""> -- Selecione --</option>
				<option value="1">Diária </option>
				<option value="2">Hora </option>
		
		</select>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
		<label>Itens</label>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
		<select name="itens[]" class="form-control" id="duallist" multiple="true">
			<?php foreach($itens as $item){ ?>
				<option value="<?php echo $item->id_item ?>"><?php echo $item->descricao.' - '.$item->preco ?> </option>
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
		<a class="btn btn-info" href="<?php echo site_url();?>/perfil" class="button success">Voltar</a>  
	</div>
</div>

<?php 

/**
* Área da tela responsável pelo formulário de edição de dados
*/
	}else if($part =="editing"){
		
	echo form_open('perfil/edit');
	echo form_hidden('id_perfil', $perfil->id_perfil);
?>

<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php
		echo form_label('Descrição');
		echo form_input(array('name'=>'descricao','class'=>'form-control','placeholder'=>'Descrição do perfil'),$perfil->descricao ,'autofocus');
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Preço');
		echo form_input(array('name'=>'preco_base','id'=>'preco','class'=>'form-control','placeholder'=>'Preço do perfil'),$perfil->preco_base);
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
		<label>Modalidade de Reserva</label>
		<select name="tp_modo_reserva" class="form-control" required="true">
				<option value=""> -- Selecione --</option>
				<option value="1" <?php echo ($perfil->tp_modo_reserva ==1)?'selected="true"':'' ?> >Diária </option>
				<option value="2" <?php echo ($perfil->tp_modo_reserva ==2)?'selected="true"':'' ?>>Hora </option>
		
		</select>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
		<select name="itens[]" class="form-control" id="duallist" multiple="true">
			<?php echo ($perfilItens)?>
			<?php foreach($itens as $item){ ?>
				<option value="<?php echo $item->id_item ?>" <?php echo (@in_array($item->id_item, $perfilItens))?'selected="true"':'' ?> ><?php echo $item->descricao.' - '.$item->preco ?> </option>
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
		<a class="btn btn-info" href="<?php echo site_url();?>/perfil" class="button success">Voltar</a>  
	</div>
</div>

<?php
/**
* Área da tela responsável pela confirmação de deleção dos dados
*/
	}else if($part =="deleting"){
		
	echo form_open('perfil/delete');
	echo form_hidden('id_perfil', $perfil->id_perfil);
?>

<div class="row">
	<div class="col-md-6 form-group">		  
	  <?php
		echo form_label('Descrição');
		echo form_input(array('name'=>'descricao','class'=>'form-control','readonly'=>'readonly'),$perfil->descricao);
	  ?>
	</div>
</div>
<div class="row">
	<div class="col-md-6 form-group">
	  <?php
		echo form_label('Preço');
		echo form_input(array('name'=>'preco','id'=>'preco','class'=>'form-control','readonly'=>'readonly'),$perfil->preco_base);
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
		<a class="btn btn-info" href="<?php echo site_url();?>/perfil" class="button success">Voltar</a>  
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
