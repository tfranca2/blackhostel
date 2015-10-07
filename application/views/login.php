<!DOCTYPE html>
<!-- saved from url=(0062)http://azmind.com/demo/bootstrap-login-forms/form-3/index.html -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap Login Form Template</title>

        <!-- CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/form-elements.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="icon" href="<?php echo base_url();?>assets/img/favicon.jpg">
        
    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>BlackHostel</strong> Login Form</h1>
							 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Formulário de login e acesso ao sistema. </h3>
                            		<p>Informe seu e-mail e senha para realizar o login.</p>
									<p class="input-error"> <?php echo @$this->session->flashdata('message');  ?></p>
									
                        		</div>
                        		
                            </div>
                            <div class="form-bottom">
			                    <form role="form" action="<?php echo site_url();?>/login/login" method="post" class="login-form">
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Usuário</label>
			                        	<input type="text" name="username" placeholder="Usuário..." class="form-username form-control" id="form-email" >
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Senha</label>
			                        	<input type="password" name="password" placeholder="Senha..." class="form-password form-control" id="form-password">
			                        </div>
			                        <button type="submit" class="btn">Entrar!</button>
			                    </form>
		                    </div>
                        </div>
                    </div>
                 
                </div>
            </div>
            
        </div>


        <!-- Javascript -->
        <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.backstretch.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/scripts.js"></script>
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    

<div class="backstretch" style="left: 0px; top: 0px; overflow: hidden; margin: 0px; padding: 0px; height: 650px; width: 1349px; z-index: -999999; position: fixed;">
<img src="<?php echo base_url();?>assets/img/1.jpg" style="position: absolute; margin: 0px; padding: 0px; border: none; width: 1349px; height: 899.333px; max-height: none; max-width: none; z-index: -999999; left: 0px; top: -150.167px;"></div>
<img src="<?php echo base_url();?>assets/img/x.gif" style="position: absolute; top: -9999px; left: -9999px;"></body></html>