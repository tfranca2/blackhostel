<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<script>
	$(document).ready(function(){
	
		$(".detail").click(function(){
                
			$.ajax({
					url: $(this).attr('href'),
					type: 'GET',
					success: function(data){
						obj = JSON.parse(data);
						console.log(obj);
						$('#reserva').val(obj.id);
						$('#numero').val(obj.numero);
						$('#perfil').val(obj.perfil);
						$('#entrada').val(obj.entrada);
						$('#saida').val(obj.saida);
						$('#permanencia').val(obj.permanencia+' Hr');
						$('#precoQuarto').val(obj.precoQuarto);
						$('#valorProdutos').val(obj.valorProdutos);
						$('#total').val(obj.total);
						
						$('#produtos').append('<tr><th>Produto</th><th>Valor</th></tr>');
						
						$.each(obj.produtos, function(i,produto) {
							$('#produtos').append( 
							'<tr> <td>'+produto.produto+'</td> <td> R$ '+produto.preco+'</td> </tr>'
							); 
						});
						
						$('#produtos').append('<tr><th>Total de Produtos</th><th> R$ '+obj.valorProdutos+'</th></tr>');					
							
						$('#myModal').modal('show');
					}
				});
                        return false;
         });
		
	});
</script>

<?php
	if($part =="searching"){
?>

	<form action="<?php echo site_url();?>/comanda/searching">
	<div class="row">
		<div class="col-md-5 form-group">
			<input type="text" placeholder="Nome do cliente" name="nome" class="form-control" />
		</div>
		<div class="col-md-5 form-group">
			<input type="submit" name="submit" value="Buscar" class="btn btn-sucess">
		</div>
	</div>
	<div class="row">
		<div class="col-md-5 form-group">
			&nbsp;
		</div>
	</div>
	</form>
	<div class="row">
		<div class="large-12 columns">
		<table class="table table-responsive"> 
			<tr>
				<th>ID Reserva</th>
				<th>Quarto</th>
				<th>Total</th>
				<th>Opções</th>
			</tr>
			<?php foreach($tabledata as $comanda){ ?>
			<tr>
				<td width="20%"><?php echo $comanda->id_reserva ?></td>
				<td width="20%"><?php echo $comanda->numero; ?></td>
				<td width="20%"><?php echo $comanda->valor_perfil+$comanda->valor_itens+$comanda->valor_produtos; ?></td>
				<td>
					<a href="<?php echo site_url();?>/comanda/detail/<?php  echo $comanda->id_reserva ?>" class="btn btn-default btn-sm detail">Detalhar 
						<span class="glyphicon glyphicon-search"></span>
					</a>
				
					<a href="<?php echo site_url();?>/comanda/print/<?php  echo $comanda->id_reserva ?>" class="btn btn-default btn-sm">Imprimir 
						<span class="glyphicon glyphicon-print"></span>
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
			<h4 class="modal-title" id="myModalLabel">Detalhamento de Comanda</h4>
		  </div>
		  <div class="modal-body">
				<div class="row">
					<div class="col-md-3 form-group">
						<label>	Reserva </label>
						<input text="text" disabled id="reserva" class="form-control"/>	
					</div>
					<div class="col-md-6 form-group">
						<label>	Quarto </label>
						<input text="text" disabled id="perfil" class="form-control"/>	
					</div>
					<div class="col-md-3 form-group">
						<label>	Número </label>
						<input text="text" disabled id="numero" class="form-control"/>	
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 form-group">
						<label>	Entrada: </label>
						<input text="text" disabled id="entrada" class="form-control"/>	
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 form-group">
						<label>	Saída: </label>
						<input text="text" disabled id="saida" class="form-control"/>	
					</div>
					
					<div class="col-md-5 form-group"> &nbsp; </div>
					<div class="col-md-3 form-group">
						<label>	Permanência: </label>
						<input text="text" disabled id="permanencia" class="form-control"/>	
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-5 form-group">
						&nbsp;
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12 form-group">
						<h4>Produtos consumidos</h4>
						<table class="table" id="produtos">
						</table>
					</div>
				</div>

				<div class="row">
					<div class="col-md-5 form-group">
						&nbsp;
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 form-group">
						<label>	Preço do quarto </label>	
						<div class="input-group">
						  <div class="input-group-addon">R$</div>
						  <input type="text" class="form-control" id="precoQuarto" disabled />
						</div>
					</div>

					<div class="col-md-3 form-group">
					</div>
					<div class="col-md-3 form-group">
					</div>
					
					<div class="col-md-3 form-group">
						<label>	Total </label>	
						<div class="input-group">
						  <div class="input-group-addon">R$</div>
						  <input type="text" class="form-control" id="total" disabled />
						</div>
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
		echo form_close(); 
	} 
?>

<div class="row">
	
	<?php /* if(! (validation_errors())){ ?>
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
