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
						abreModal( obj );
					}
            });
            return false;
        });

        $(".modal-body").on( "click", ".minus", function(){
            $(this).parent().attr("op",2);
        });

        $(".modal-body").on( "click", ".more", function(){
            $(this).parent().attr("op",1);
        });

		$(".adcproduto").click(function(){
			$.ajax({
					url: '<?php echo site_url();?>/reserva/adicionar/',
					data: {'reserva':$('#reserva').val(), 'produto':$('#newproduto').val()},
					type: 'POST',
					success: function(data){
                        detalhes( $('#reserva').val() );
                        $("#newproduto").val('');
                        $(".info").text('');

                        var obj = JSON.parse(data);
                        if (obj.hasOwnProperty('erro')) {
                            alert(obj.erro);
                        }
					}
			});
		});

        $("#newproduto").keyup(function(e){
            if(e.which == 13) {
                $.ajax({
                    url: '<?php echo site_url();?>/reserva/adicionar/',
                    data: {'reserva':$('#reserva').val(), 'produto':$('#newproduto').val()},
                    type: 'POST',
                    success: function(data){
//                        console.log(data);
                        detalhes( $('#reserva').val() );
                        $("#newproduto").val('');
                        $(".info").text('');

                        var obj = JSON.parse(data);
                        if (obj.hasOwnProperty('erro')) {
                            alert(obj.erro);
                        }
                    }
                });
            } else {
                $.ajax({
                    url: '<?php echo site_url();?>/produto/pesquisaProduto/',
                    data: {'codigo': $('#newproduto').val()},
                    type: 'POST',
                    success: function (data) {
//                        console.log(data);
                        var obj = JSON.parse(data);
                        if (obj !== null)
                            $(".info").text('- ' + obj.produto);
                        else
                            $(".info").text('');
                    }
                });
            }
        });

		$(document).on("click", ".remove-produto", function(e){
            e.preventDefault();
            var elem = $(this);
            if( confirm("Deseja realmemte excluir o produto da comanda?") ) {
                $.ajax({
                    url: elem.attr('href'),
                    type: 'POST',
                    success: function (data) {
//                    console.log(data);
                        var obj = JSON.parse(data);
                        if (obj.exclusion) {
                            detalhes( $('#reserva').val() );
                        }

                        if (obj.hasOwnProperty('erro')) {
                            alert(obj.erro);
                        }
                    }
                });
            }
		});

		// pegar produto e saldo
		$(document).on("click", ".itens", function(){
		    var elem = $(this);
			$.ajax({
				url: '<?php echo site_url();?>/reserva/atualizaSaldoProduto/',
                data: {
				          'reserva': $('#reserva').val()
                        , 'produto': elem.find('.qtd').attr('id')
                        , 'quantidade': elem.find('.qtd').val()
                        , 'operacao': elem.attr('op')
                },
				type: 'POST',
				success: function(data){
//                    console.log(data);
                    var obj = JSON.parse( data );
                    elem.find('.qtd').val( obj.quantidade );
                    if( obj.hasOwnProperty('erro') ) {
                        alert( obj.erro );
                    } else {
                        detalhes( $('#reserva').val() );
                    }
				}
			});
		});

        $(document).on("click", ".ocupantes", function(){
            $.ajax({
                url: '<?php echo site_url();?>/reserva/atualizaOcupantes/',
                data: {
                      'reserva': $('#reserva').val()
                    , 'quantidade': $('.ocupantes .qtd').val()
                    , 'operacao': $('.ocupantes').attr('op')
                },
                type: 'POST',
                success: function(data) {
//                    console.log(data);
                    var obj = JSON.parse( data );
                    $('.ocupantes .qtd').val( obj.quantidade );
                    if( obj.hasOwnProperty('erro') ) {
                        console.log( obj.erro );
                    } else {
                        detalhes( $('#reserva').val() );
                    }
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

	function abreModal( obj ) {
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
		$('#couvert').val(obj.couvert);
		$('#taxaAtendimento').val(obj.taxaAtendimento);
		$('#total').val(obj.total);

		$('.print').attr('href', '<?php echo site_url();?>/comanda/imprimir/'+obj.id);
		// $('.finalizar').attr('href', '<?php echo site_url();?>/comanda/finalizar/'+obj.id);

		$('#produtos').empty();

		$('#produtos').append('<tr class="row"><th class="col-md-3 form-group">Produto</th><th class="col-md-6 form-group">Valor</th><th class="col-md-6 form-group">Quantidade</th><?php if($gerente) { ?><th class="col-md-6 form-group">Opções</th><?php } ?></tr>');

		if(obj.produtos.length > 0){
			$.each(obj.produtos, function(i,produto) {
				$('#produtos').append(
			'<tr class="row"> <td class="col-md-3 form-group"><span>'+produto.produto+'</span></td>'+
            '<td class="col-md-3 form-group"><span>R$ '+produto.preco+'</span></td>'+
            '<td class="col-md-3 form-group"> <div class="input-group itens">'+
            <?php if($gerente) { ?>
                '<div class="input-group-addon btn btn-danger minus"><span class="glyphicon glyphicon-minus"></span></div>'+
            <?php } ?>
            '<input type="text" id="'+produto.id_produto+'" value="'+produto.quantidade+'" disabled class="form-control qtd"/>'+
            '<div class="input-group-addon btn btn-success more"><span class="glyphicon glyphicon-plus"></span></div>'+
            '</div> </div> </td>'+
            <?php if($gerente) { ?>
                '<td class="col-md-3 form-group"> <a href="<?php echo site_url();?>/reserva/remover/'+produto.id_reserva_produto+' " class="btn btn-danger btn-sm remove-produto">Remover <span class="glyphicon glyphicon-trash"></span></a> </td>'+
            <?php } ?>
            '</tr>'
				);
			});
		}else{
			$('#produtos').empty();
			$('#produtos').append('<div class="alert alert-success">Nenhum produto adicionado a essa comanda.</div>');
		}

        $('#myModal').modal('show');

    }

	function detalhes( id ){
        $('#newproduto').focus();
		$.ajax({
			url: "<?php echo site_url();?>/comanda/detail/" + id ,
			type: 'GET',
			success: function(data){
				obj = JSON.parse(data);
				abreModal( obj );
//                document.getElementById("newproduto").focus();
			}
		});
        return false;
	}

	$(document).on("click", ".info", function(){
	    $("#newproduto").focus();
    });
</script>
<style>
.modal-dialog {
        width: 830px;
        margin: 30px auto;
    }

    .mesas {
        border: 1px solid #ccc;
        display: block;
        height: 100px;
        line-height: 4;
        text-align: center;
        width: 100px;
    }

    .val {
        text-align: right;
    }

    .qtd {
        text-align: center;
    }

    .info {
        color: #8C97E7;
        display: block;
        width: 100%;
        text-align: center;
        margin-top: -26px;
        height: 20px;
        overflow: hidden;
    }
</style>
<?php
	if($part =="searching"){
?>

	<form action="<?php echo site_url();?>/comanda/searching">
	<div class="row">
		<div class="col-md-5 form-group">
			<input type="text" placeholder="Número da mesa" name="numero" class="form-control" />
		</div>
		<div class="col-md-5 form-group">
			<input type="submit" name="submit" value="Buscar" class="btn btn-success">
		</div>
	</div>
	</form>
	<div class="row">
		<div class="large-12 columns">
			<fieldset>
				<legend>COPA</legend>
				<?php 
					if( isset($result) and $result->operacao == 1 ) {
						foreach( $tabledata as $comanda ) {
							$hora = explode( " ", $comanda->entrada );
				?>
				<div class="mesas" onclick="javascript:detalhes( <?php echo $comanda->id_reserva; ?> )" >
					<span class="glyphicon glyphicon-search"></span>
					Mesa nº <strong><?php echo $comanda->numero ?></strong>
					<br/><sub><?php echo substr( $hora[1], 0, 5 ); ?></sub>
				</div>
				<?php
						}
					} else {
						echo '<table class="table table-striped table-bordered"><tr><td colspan="4">É necessário realizar a abertura de caixa para gerenciar as comandas</td></tr></table>';
					}
				?>
			</fieldset>	
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
                            <div class="panel-heading">Mesa</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <label> Cod. Conta </label>
                                        <input text="text" disabled id="reserva" class="form-control"/>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>	Setor </label>
                                        <input text="text" disabled id="perfil" class="form-control"/>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>	N° da Mesa </label>
                                        <input text="text" disabled id="numero" class="form-control"/>
                                    </div>

                                    <!--<div class="col-md-3 form-group">
                                        <label>	Preço do perfil </label>
                                        <div class="input-group">
                                          <div class="input-group-addon">R$</div>
                                          <input type="text" class="form-control" id="precoPerfil" disabled />
                                        </div>
                                    </div>-->

                                </div>
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <label>	Entrada </label>
                                        <input text="text" disabled id="entrada" class="form-control"/>
                                    </div>
                                    <!--<div class="col-md-3 form-group">
                                        <label>	Saída </label>
                                        <input text="text" disabled id="saida" class="form-control"/>
                                    </div>-->
                                    <div class="col-md-3 form-group">
                                        <label>	Permanência: </label>
                                        <input text="text" disabled id="permanencia" class="form-control"/>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>	Ocupantes: </label>
                                        <div class="input-group ocupantes">
                                            <div class="input-group-addon btn btn-danger minus"><span class="glyphicon glyphicon-minus"></span></div>
                                            <input text="text" disabled id="ocupantes" class="form-control qtd"/>
                                            <div class="input-group-addon btn btn-success more"><span class="glyphicon glyphicon-plus"></span></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>	Atendente: </label>
                                        <input text="text" disabled value="<?php echo $user['user_session']['nome']; ?>" class="form-control"/>
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
                              <input class="form-control" id="newproduto" />
                              <span class="info"></span>
                              <!-- <select class="form-control" id="newproduto" >
                                  <option value=""> -- Selecione -- </option>
                                  <?php foreach ($produtos as $produto){?>
                                      <option value="<?php echo $produto->id_produto?>"> <?php echo $produto->produto.'- R$ '.monetaryOutput( $produto->preco) ?> </option>
                                  <?php }?>
                              </select> -->
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
                              <label>Total consumido</label>
                                  <div class="input-group">
                                  <div class="input-group-addon">R$</div>
                                  <input type="text" class="form-control val" id="valorProdutos" disabled />
                              </div>
                          </div>

                          <!-- <div class="col-md-3 form-group">
                              <label>Valor do quarto</label>
                              <div class="input-group">
                                  <div class="input-group-addon">R$</div>
                                  <input type="text" class="form-control val" id="precoQuarto" disabled />
                              </div>
                          </div> -->

                          <div class="col-md-3 form-group">
                              <label>Taxa de atendimento</label>
                              <div class="input-group">
                                  <div class="input-group-addon">R$</div>
                                  <input type="text" class="form-control val" id="taxaAtendimento" value="0,00" disabled />
                              </div>
                          </div>

                          <div class="col-md-3 form-group">
                              <label>Courvert artístico</label>
                              <div class="input-group">
                                  <div class="input-group-addon">R$</div>
                                  <input type="text" class="form-control val" id="couvert" value="0,00" disabled />
                              </div>
                          </div>

                          <div class="col-md-3 col-md-offset-9 form-group">
                              <label>Total Geral</label>
                              <div class="input-group">
                                  <div class="input-group-addon">R$</div>
                                  <input type="text" class="form-control val" id="total" disabled />
                              </div>
							</div>
						</div>
					
				  </div>
				</div>

              <div class="panel panel-primary">
                  <div class="panel-heading">
                      Formas de Pagamento
                      <button type="button" class="btn btn-sm btn-default" style="float: right; margin-top: -5px;" title="Adicionar forma de pagamento" ><span class="glyphicon glyphicon-plus"></span></button>
                  </div>
                  <div class="panel-body">
                      <div class="row">
                          <div class="col-md-3 form-group">
                              <label>Descrição</label>
                              <select class="formapagamento" style="width: 170px">
                                  <?php foreach ($formasPagamento as $formaPagamento){?>
                                      <option value="<?php echo $formaPagamento->id_forma_pagamento?>">
                                          <?php echo $formaPagamento->descricao ?></option>
                                  <?php }?>
                              </select>
                          </div>

                          <div class="col-md-3 form-group">
                              <label>Valor</label>
                              <div class="input-group">
                                  <div class="input-group-addon">R$</div>
                                  <input type="text" class="form-control val" value="0,00" />
                              </div>
                          </div>

                          <div class="col-md-3 form-group">
                              <label>Parcelas</label>
                              <div class="input-group">
                                  <div class="input-group">
                                      <div class="input-group-addon btn btn-danger minus"><span class="glyphicon glyphicon-minus"></span></div>
                                      <input text="text" disabled class="form-control qtd" value="0"/>
                                      <div class="input-group-addon btn btn-success more"><span class="glyphicon glyphicon-plus"></span></div>
                                  </div>
                              </div>
                          </div>

                          <div class="col-md-3 form-group">
                              <label><br/></label>
                              <div class="input-group">
                                  <button class="btn btn-danger btn-sm">Remover <span class="glyphicon glyphicon-trash"></span></button>
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


