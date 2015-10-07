<!DOCTYPE html>
<!-- saved from url=(0044)http://getbootstrap.com/examples/dashboard/# -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo base_url();?>assets/img/favicon.jpg">

    <title>BlackHostel</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url();?>assets/css/dashboard.css" rel="stylesheet">
	
	<!-- Tables Plug-In -->
    <link href="<?php echo base_url();?>assets/css/bootstrap-table.css" rel="stylesheet">

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
	<!-- Bootstrap 
	-->
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>

	<!-- Mask JQuery 
	-->
	<script src="<?php echo base_url();?>assets/js/jquery.mask.min.js"></script>
   
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug 
	-->
    <script src="<?php echo base_url();?>assets/js/ie10-viewport-bug-workaround.js"></script>
	
	<!-- DualList Plug-in 
	-->
	<script src="<?php echo base_url();?>assets/js/dual-list-box.min.js"></script>
	<!--
	<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="http://rawgit.com/Geodan/DualListBox/master/dist/dual-list-box.min.js"></script>
	-->
	

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
          <a class="navbar-brand" href="#">BlackHostel</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="assets/Dashboard Template for Bootstrap.html">Dashboard</a></li>
            <li><a href="assets/Dashboard Template for Bootstrap.html">Settings</a></li>
            <li><a href="assets/Dashboard Template for Bootstrap.html">Profile</a></li>
            <li>
				<a href="<?php echo site_url();?>/login/logout">
					Sair <span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> 
				</a>
			</li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="<?php echo styleMenuActive('item') ?>"><a href="<?php echo site_url()."/item"?>">Itens </a></li>
			<li class="<?php echo styleMenuActive('perfil') ?>"><a href="<?php echo site_url()."/perfil"?>">Perfis </a></li>
			<li class="<?php echo styleMenuActive('quarto') ?>"><a href="<?php echo site_url()."/quarto"?>">Quartos </a></li>
			<li class="<?php echo styleMenuActive('produto') ?>"><a href="<?php echo site_url()."/produto"?>">Produtos </a></li>
			<li class="<?php echo styleMenuActive('situacao') ?>"><a href="<?php echo site_url()."/situacao"?>">Situações </a></li>
          </ul>
          <ul class="nav nav-sidebar">
			<li class="<?php echo styleMenuActive('cliente') ?>"><a href="<?php echo site_url()."/cliente"?>">Cliente </a></li>
            <li><a href="">Nav item</a></li>
            <li><a href="">Nav item again</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		
		
          <h1 class="page-header"><?php echo @$title ?></h1>
			<?php $this->load->view("pages/".$page); ?>	
			
       
        </div>
      </div>
    </div>

  

<img src="<?php echo base_url();?>assets/js/x.gif" style="position: absolute; top: -9999px; left: -9999px;"><img src="<?php echo base_url();?>assets/js/x(1).gif" style="position: absolute; top: -9999px; left: -9999px;"></body></html>