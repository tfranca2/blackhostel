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
});
</script>
<?php 
//dump($data);
echo extractValues($data,"Di�ria");
echo '<br>';
//echo extractValues($data,"Hora");
?>


<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
		