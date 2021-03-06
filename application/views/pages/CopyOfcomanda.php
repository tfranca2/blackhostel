<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//TODO Tirar isso daqui
$user = $this->session->get_userdata();
$gerente = $user['user_session']['gerente'];
$admin = $user['user_session']['admin'];
//TODO Tirar principalmente isso daqui
$result = $this->db->query("SELECT operacao FROM caixa WHERE id_caixa = (SELECT MAX(id_caixa) FROM caixa WHERE operacao IN( 1, 4 ))")->row();

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

<script>
	$(document).ready(function(){
	
		$(".detail").click(function(){
                
			$.ajax({
					url: $(this).attr('href'),
					type: 'GET',
					success: function(data){
						obj = JSON.parse(data);	
						$('#reserva').val(obj.id);
						$('#numero').val(obj.numero);
						$('#perfil').val(obj.perfil);
						$('#entrada').val(obj.entrada);
						$('#saida').val(obj.saida);
						$('#ocupantes').val(obj.ocupantes);
						$('#permanencia').val(obj.permanencia);
						$('#precoPerfil').val(obj.precoPerfil);
						$('#precoQuarto').val(obj.precoQuarto);
						$('#valorProdutos').val(obj.valorProdutos);
						$('#total').val(obj.total);
						
						$('.print').attr('href', '<?php echo site_url();?>/comanda/imprimir/'+obj.id);
						$('.finalizar').attr('href', '<?php echo site_url();?>/comanda/finalizar/'+obj.id);
						
						$('#produtos').empty();

						$('#produtos').append('<tr><th>Produto</th><th>Valor</th><?php if($gerente) { ?><th>Opções</th><?php } ?></tr>');
						
						if(obj.produtos.length > 0){
							$.each(obj.produtos, function(i,produto) {
								$('#produtos').append( 
							'<tr> <td>'+produto.produto+'</td> <td> R$ '+produto.preco+'</td> <?php if($gerente) { ?> <td> <a href="<?php echo site_url();?>/reserva/remover/'+produto.id_reserva_produto+' " class="btn btn-danger btn-sm remove-produto">Remover <span class="glyphicon glyphicon-remove"></span></a> </td> <?php } ?> </tr>'
								); 
							});
						}else{
							$('#produtos').empty();
							$('#produtos').append('<div class="alert alert-success">Nenhum produto adicionado a essa comanda.</div>');
						}				

						$('#myModal').modal('show');
					}
				});
                        return false;
         });

		$(".adcproduto").click(function(){
         
			$.ajax({
					url: '<?php echo site_url();?>/reserva/adicionar/',
					data: {'reserva':$('#reserva').val(), 'produto':$('#newproduto').val()},
					type: 'POST',
					success: function(data){
						$('#myModal').modal('hide');
						window.location.href ='<?php echo site_url();?>/comanda/';	
					}
					
			});

		});

		$(document).on("click", ".remove-produto", function(){
			$.ajax({
				url: $(this).href,
				type: 'POST',
				success: function(data){
					$('#myModal').modal('hide');
					window.location.href ='<?php echo site_url();?>/comanda/';	
				}
			});

		});

		
		$(document).on("click", ".print", function(){
			 
			$.ajax({
				url: $('.print').attr('href'),
				type: 'GET',
				success: function(data){
					//alert("Comanda Enviada para Impressora.");	
				},
				error: function(data){
					alert("Ocorreu um erro ao enviar o comando para impressora.");
				}
			});
			return false;
		});
		
	});
</script>
<style>
.modal-dialog {
    width: 830px;
    margin: 30px auto;
}
</style>
<?php
	if($part =="searching"){
?>

	<form action="<?php echo site_url();?>/comanda/searching">
	<div class="row">
		<div class="col-md-5 form-group">
			<input type="text" placeholder="Numero do quarto" name="numero" class="form-control" />
		</div>
		<div class="col-md-5 form-group">
			<input type="submit" name="submit" value="Buscar" class="btn btn-success">
		</div>
	</div>
	</form>
	<div class="row">
		<div class="large-12 columns">
		<table class="table table-striped table-bordered"> 
			<tr>
				<th>Cod. Reserva</th>
				<th>Quarto</th>
				<th>Entrada</th>
				<th>Saída (Prévia)</th>
				<th>Tipo</th>
				<th>Opções</th>
			</tr>
			<?php 
			if(isset($result) and $result->operacao == 1 ) {
			
				foreach($tabledata as $comanda){ ?>
			<tr>
				<td><?php echo $comanda->id_reserva ?></td>
				<td><?php echo $comanda->perfil." - Nº ".$comanda->numero; ?></td>
				<td><?php echo dateTimeToBr( $comanda->entrada ) ?></td>
				<td><?php echo dateTimeToBr( $comanda->saida ) ?></td>
				<td><?php 
					if ($comanda->tipo ==1){
						echo 'Diária';
					}elseif($comanda->tipo ==2){
						echo 'Hora';
					}elseif($comanda->tipo ==3){
						echo 'Pernoite';
					} 
				?></td>
				<td>
					<a href="<?php echo site_url();?>/comanda/detail/<?php  echo $comanda->id_reserva ?>" class="btn btn-default btn-sm detail">Detalhar 
						<span class="glyphicon glyphicon-search"></span>
					</a>
				</td>
			</tr>
			<?php } 
			} else {  ?>
				<tr>
					<td colspan="4">É necessário realizar a abertura de caixa para gerenciar as comandas</td>
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
				<div class="panel panel-primary">
				  <div class="panel-heading">Reserva</div>
				  <div class="panel-body">
					  <div class="row">
							<div class="col-md-2 form-group">
								<label> Cod. Reserva </label>
								<input text="text" disabled id="reserva" class="form-control"/>	
							</div>
							<div class="col-md-5 form-group">
								<label>	Perfil </label>
								<input text="text" disabled id="perfil" class="form-control"/>	
							</div>
							<div class="col-md-2 form-group">
								<label>	N° do Quarto </label>
								<input text="text" disabled id="numero" class="form-control"/>	
							</div>
							<div class="col-md-3 form-group">
								<label>	Preço do perfil </label>
								<div class="input-group">
								  <div class="input-group-addon">R$</div>
								  <input type="text" class="form-control" id="precoPerfil" disabled />
								</div>	
							</div>
						</div>
						<div class="row">
							<div class="col-md-3 form-group">
								<label>	Entrada </label>
								<input text="text" disabled id="entrada" class="form-control"/>	
							</div>
							<div class="col-md-3 form-group">
								<label>	Saída </label>
								<input text="text" disabled id="saida" class="form-control"/>	
							</div>
							<div class="col-md-3 form-group">
								<label>	Permanência: </label>
								<input text="text" disabled id="permanencia" class="form-control"/>	
							</div>
							<div class="col-md-3 form-group">
								<label>	Ocupantes: </label>
								<input text="text" disabled id="ocupantes" class="form-control"/>	
							</div>
						</div>
				  
				  </div>
				</div>
				<div class="panel panel-primary">
				  <div class="panel-heading">Produtos</div>
				  <div class="panel-body">
				  	<div class="row">
				  		<div class="col-md-3 form-group">
						</div>
				  		<div class="col-md-4 form-group">
				  		<label>Produto</label>
						  <select class="form-control" id="newproduto" >
						  	<option value=""> -- Selecione -- </option>
						  	<?php foreach ($produtos as $produto){?>
						  		<option value="<?php echo $produto->id_produto?>"> <?php echo $produto->produto.'- R$ '.monetaryOutput( $produto->preco) ?> </option>	
						  	<?php }?>
						  </select>
						  </div>
						  <div class="col-md-3 form-group">
						  	<input type="button" value="Adicioinar" class="btn btn-primary adcproduto " style="margin-top:24px;"/>
						  </div>
						  <div class="col-md-4 form-group">
						  </div>
				  	</div>
					<div class="row">
						<h4>&nbsp;Consumo:</h4>
						<table class="table" id="produtos"></table>
					</div>
				  </div>
				</div>
				<div class="panel panel-primary">
				  <div class="panel-heading">Totalização</div>
				  <div class="panel-body">
						<div class="row">
							<div class="col-md-3 form-group">
								<label>	Soma dos produtos </label>	
								<div class="input-group">
								  <div class="input-group-addon">R$</div>
								  <input type="text" class="form-control" id="valorProdutos" disabled />
								</div>	
							</div>
						
							<div class="col-md-3 form-group">
								<label>	Preço do quarto </label>	
								<div class="input-group">
								  <div class="input-group-addon">R$</div>
								  <input type="text" class="form-control" id="precoQuarto" disabled />
								</div>
							</div>
							
							<div class="col-md-3 col-md-offset-3 form-group">
								<label>	Total </label>	
								<div class="input-group">
								  <div class="input-group-addon">R$</div>
								  <input type="text" class="form-control" id="total" disabled />
								</div>
							</div>
						</div>
					
				  </div>
				</div>
				
		  </div>
		  <div class="modal-footer">
			<a href="<?php echo site_url();?>/comanda/imprimir/" style="float:left;" id="" class="print btn btn-default">Imprimir 
				<span class="glyphicon glyphicon-print"></span>
			</a>
			<a href="" id="" class="finalizar btn btn-default">Finalizar 
				<span class="print glyphicon glyphicon-usd"></span>
			</a>
			<button type="button" class="btn btn-default" data-dismiss="modal">Fechar<span class="glyphicon glyphicon-remove"></span></button>
		  </div>
		</div>
	  </div>
	</div>
	
<?php 
		echo form_close(); 
	} 
?>


