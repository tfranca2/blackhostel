<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
?>

<script src="<?php echo base_url();?>assets/js/highcharts.js"></script>
		
<script src="<?php echo base_url();?>assets/js/modules/exporting.js"></script>

<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        title: {
            text: 'Quantidade de Reservas por',
            x: -20 //center
        },
        subtitle: {
            text: 'Fonte: blackhostel.com',
            x: -20
        },
        xAxis: {
            categories: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro',]
        },
        yAxis: {
            title: {
                text: 'Reservas'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ''
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: 'Hora',
            data: [<?php echo extractValues($data,"Hora"); ?>]
        },{
            name: 'Diária',
            data: [<?php echo extractValues($data,"Diária"); ?>]
        }]
    });


	$('.calendar').datetimepicker({	
		  beforeShow: function(input, inst) {
				var calendar = inst.dpDiv;
				setTimeout(function() {
					$('.ui_tpicker_time_label').text("Tempo");
					$('.ui_tpicker_hour_label').text("Hora");
					$('.ui_tpicker_minute_label').text("Minuto");
					calendar.position({
						my: 'left top',
						at: 'left bottom',
						collision: 'none',
						of: input
					});
				}, 1);
				customRange(input);
			}
		});

	function customRange(input) {   
		if (input.id == 'entrada'){     
			var x = $('#saida').datepicker("getDate");
			$( "#entrada" ).datepicker( "option", "maxDate",x ); 
		}else if (input.id == 'saida') {     
			var x=$('#entrada').datepicker("getDate");
			$( "#saida" ).datepicker( "option", "minDate",x ); 
		} 
	}
});
</script>

<!-- 
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
-->
<form method="post">
<div class="row">
	<div class="col-md-3 form-group">
	  	<label>Início</label>
	  	<div class="input-group">
            <input type="datetime" class="form-control calendar" name="inicio" id="entrada" required 
            value="<?php echo $filtro['inicio'] ?>">
            <span class="input-group-addon add-on">
                <span class="glyphicon glyphicon-calendar" data-time-icon="icon-time"></span>
            </span>
		</div>
	</div>
	<div class="col-md-3 form-group">
	  	<label>Fim</label>
	  	<div class="input-group">
            <input type="datetime" class="form-control calendar" name="fim" id="saida"
            value="<?php echo $filtro['fim'] ?>" >
            <span class="input-group-addon add-on">
                <span class="glyphicon glyphicon-calendar" data-time-icon="icon-time"></span>
            </span>
		</div>
	</div>
	<div class="col-md-5 form-group">
		<input type="submit" name="submit" value="Buscar" style="margin-top: 25px;" class="btn btn-success"/>
	</div>
</div>
</form>
<h1>Faturamentos Diários</h1>

<table class="table">
  <tr>
    <th>Data</th>
    <th>Valor</th>
  </tr>
  	<?php foreach($faturamentos as $fat){ ?>
	  <tr>
    	<td><?php echo dateTimeToBr($fat->data) ?></td>
    	<td><?php echo monetaryOutput($fat->valor) ?></td>
  	  </tr>
    <?php }?>
</table>





		