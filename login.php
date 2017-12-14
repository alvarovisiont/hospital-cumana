<?
	if(!isset($_SESSION))
	{
		session_start();
	}	

	$mensaje = "";

	if(isset($_POST['usuario']))
	{
			require_once $_SESSION['base_url'].'/class/system.php';
			
			$system = new System;

			$system->login($_POST['usuario'],$_POST['password']);
	}

	if(isset($_GET['r']))
	{
		$mensaje = 'Error en sus credenciales por favor intentelo de nuevo.';
	}
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
	    <div class="login-logo">
	    	<?
	    		if($mensaje != "")
	    		{
	    			echo '<p class="text-center alert alert-danger" id="aviso">'.$mensaje.'</p>';
	    		}
	    	?>
	      </div><!-- /.login-logo -->
	        <div class="col-md-8 col-md-offset-2"> 
	            <div class="panel panel-default">
	                <div class="panel-heading"><strong>Login</strong></div>
	                <div class="panel-body">
	                    <form class="form-horizontal" role="form" method="POST" action="<? echo $_SERVER['PHP_SELF']; ?>">

	                        <div class="form-group">
	                            <label for="usuario" class="col-md-4 control-label">Correo</label>

	                            <div class="col-md-6">
	                                <input id="usuario" type="email" class="form-control" name="usuario">
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <label for="password" class="col-md-4 control-label">Password</label>
	                            <div class="col-md-6">
	                                <input id="password" type="password" class="form-control" name="password">
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="col-md-6 col-md-offset-4">
	                                <button type="submit" class="btn btn-primary">
	                                    <i class="fa fa-btn fa-sign-in"></i> Entrar
	                                </button>
	                            </div>
	                        </div>
	                    </form>
	                  </div><!-- /.login-box -->
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<script src="./assets/js/jQuery-2.1.4.min.js"></script>
	        <!-- Bootstrap 3.3.5 -->
	<script src="./assets/js/bootstrap.min.js"></script>
	</body>
</html>

<script>
    $(function(){
        let mensaje = '<?php echo $mensaje; ?>'
        
        if(mensaje != "")
        {

        	let aviso = $('#aviso')

        	setTimeout(function(){
        		aviso.hide('slow')
        	}, 2000)
        }
    });
</script>