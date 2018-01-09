<?php

	if(!isset($_SESSION))
	{
		session_start();
	}	

	// Location to file


	if(isset($_GET['logout']))
	{
		$_SESSION = [];
	}


	$_SESSION['base_url'] = $_SERVER['DOCUMENT_ROOT'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];
	
	$_SESSION['base_url1'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.explode('/',$_SERVER['REQUEST_URI'])[1];

?>
<html>
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <title>Hospital para el Pueblo</title>
	    <!-- Tell the browser to be responsive to screen width -->
	    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	    <!-- Bootstrap 3.3.5 -->
	    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
	    <!-- Font Awesome -->
	    <link rel="stylesheet" href="./assets/css/font-awesome.css">
	  </head>


	<body class="hold-transition">

	    <nav class="navbar navbar-default">
	        <div class="container-fluid">
	            <div class="navbar-header">
	                 <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	                     <span class="sr-only">Toggle Navigation</span>
	                     <span class="icon-bar"></span>
	                     <span class="icon-bar"></span>
	                     <span class="icon-bar"></span>
	                </button>
	                <a class="navbar-brand" href="./index.php">Sistema de Gestión de Hospitales</a>
	             </div>
	            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	                <ul class="nav navbar-nav navbar-right">
	                	<li><a href="./login.php">Login</a></li>
	                    <li><a href="./recuperar_contra.php">Recuperar Contraseña</a></li>
	                </ul>
	            </div>
	        </div>
	    </nav>

	<div class="container">
	    <div class="row">
	    	<h1>Bienvenido al Sistema</h1>
	    </div>
	</div>
	<script src="./assets/js/jQuery-2.1.4.min.js"></script>
	        <!-- Bootstrap 3.3.5 -->
	<script src="./assets/js/bootstrap.min.js"></script>
	</body>
</html>

<script>
    
</script>