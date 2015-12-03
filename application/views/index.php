<?php

$user = $this->session->get_userdata();
$gerente = $user['user_session']['gerente'];
$admin = $user['user_session']['admin'];

?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
	    <link rel="icon" href="<?php echo base_url();?>assets/img/favicon.jpg">
	
	    <title>BlackHostel</title>
	
	    <!-- Bootstrap core CSS -->
	    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
	
	    <!-- Custom styles for this template -->
	    <link href="<?php echo base_url();?>assets/css/dashboard.css" rel="stylesheet">
		
		<link href="<?php echo base_url();?>assets/css/jquery-ui.css" rel="stylesheet">
		<link href="<?php echo base_url();?>assets/css/jquery-ui.theme.css" rel="stylesheet">
		<link href="<?php echo base_url();?>assets/css/jquery-ui-timepicker-addon.css" rel="stylesheet">
		 
		<!-- Tables Plug-In -->
	    <link href="<?php echo base_url();?>assets/css/bootstrap-table.css" rel="stylesheet">
		<!---
		<link href="<?php echo base_url();?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
		-->
	    <link href="<?php echo base_url();?>assets/css/custom.css" rel="stylesheet">
	    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
	    <!--[if lt IE 9]><script src="<?php echo base_url();?>assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
	    <script src="<?php echo base_url();?>assets/js/ie-emulation-modes-warning.js"></script>
	
	    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
		
		
	    <!-- Bootstrap core JavaScript
	    ================================================== -->
	    <!-- Placed at the end of the document so the pages load faster 
		-->
	    <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
		
		 <script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
		 
		 <script src="<?php echo base_url();?>assets/js/jquery-ui-timepicker-addon.js"></script>
	
		<!-- Bootstrap -->
	    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
	
		<!-- Mask JQuery -->
		<script src="<?php echo base_url();?>assets/js/jquery.mask.min.js"></script>
	   
	    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug-->
	    <script src="<?php echo base_url();?>assets/js/ie10-viewport-bug-workaround.js"></script>
		
		<!-- DualList Plug-in -->
		<script src="<?php echo base_url();?>assets/js/dual-list-box.min.js"></script>
		
		<!-- DualList Plug-in-->
		<script src="<?php echo base_url();?>assets/js/search.js"></script>
		
		<script src="<?php echo base_url();?>assets/js/locales/bootstrap-datetimepicker.pt-BR.js"></script>
		
		<!-- PrintScreenShopJs https://github.com/jeffersonphp/printScreenShotJs -->
		<script src="<?php echo base_url();?>assets/js/html2canvas.js"></script>
		
		<script src="<?php echo base_url();?>assets/js/printScreeShot.js"></script>

  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo site_url();?>">BlackHostel</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?php echo site_url().'/main/reports'?>" > Relatórios</a></li>
            <li><a href="<?php echo site_url().'/main/manual'?>" > Manual</a></li>
            <!-- <li><a href="assets/Dashboard Template for Bootstrap.html">Configurações</a></li> -->
            <?php if($admin) { ?><li><a href="<?php echo site_url()."/usuario"?>">Usuáios</a></li><?php } ?>
            <li>
				<a href="<?php echo site_url();?>/login/logout">
					Sair <span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> 
				</a>
			</li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Buscar..." id="search">
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
			<li class="<?php echo styleMenuActive('cliente') ?>">
				<a href="<?php echo site_url()."/cliente"?>">
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span> Clientes 
				</a>
			</li>
		    <li class="<?php echo styleMenuActive('reserva') ?>">
				<a href="<?php echo site_url()."/reserva"?>">
					<span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Reservas
				</a>
			</li>
			<li class="<?php echo styleMenuActive('comanda') ?>">
				<a href="<?php echo site_url()."/comanda"?>">
					<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Comandas
				</a>
			</li>
			<li class="<?php echo styleMenuActive('estoque') ?>">
				<a href="<?php echo site_url()."/estoque"?>">
					<span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> Movimento de Estoque
				</a>
			</li>
			<li class="<?php echo styleMenuActive('caixa') ?>">
				<a href="<?php echo site_url()."/caixa"?>">
					<span class="glyphicon glyphicon-usd" aria-hidden="true"></span> Movimento de Caixa
				</a>
			</li>
		  </ul>
		  
          <ul class="nav nav-sidebar">
            <li class="<?php echo styleMenuActive('item') ?>">
				<a href="<?php echo site_url()."/item"?>">
					<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Itens
				</a>
			</li>
			<li class="<?php echo styleMenuActive('perfil') ?>">
				<a href="<?php echo site_url()."/perfil"?>">
					<span class="glyphicon glyphicon-tags" aria-hidden="true"></span> Perfis
				</a>
			</li>
			<li class="<?php echo styleMenuActive('produto') ?>">
				<a href="<?php echo site_url()."/produto"?>">
					<span class="glyphicon glyphicon-glass" aria-hidden="true"></span> Produtos 
				</a>
			</li>
			<li class="<?php echo styleMenuActive('quarto') ?>">
				<a href="<?php echo site_url()."/quarto"?>"> 
					<span class="glyphicon glyphicon-lamp" aria-hidden="true"></span> Quartos 
				</a>
			</li>

          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		
          <h1 class="page-header"><?php echo @$title ?></h1>
			<?php $this->load->view("pages/".$page); ?>	
		
        </div>
      </div>
    </div>

	<img src="<?php echo base_url();?>assets/js/x.gif" style="position: absolute; top: -9999px; left: -9999px;">
	<img src="<?php echo base_url();?>assets/js/x(1).gif" style="position: absolute; top: -9999px; left: -9999px;">
</body>
</html>
