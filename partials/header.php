<?
  if(!isset($_SESSION))
  {
    session_start();

  }
  
  include_once $_SESSION['base_url'].'/class/system.php';

  System::validar_logueo();

  $system = new System; 


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PLANTILLA | MODIFICABLE</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?= $_SESSION['base_url1'].'/assets/css/bootstrap.min.css'; ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= $_SESSION['base_url1'].'/assets/css/font-awesome.css'; ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= $_SESSION['base_url1'].'/assets/css/AdminLTE.css'; ?>">
    <link rel="stylesheet" href="<?= $_SESSION['base_url1'].'/assets/css/jquery.dataTables.css'; ?>"></link>
    <link rel="stylesheet" href="<?= $_SESSION['base_url1'].'/assets/css/dataTables.bootstrap.css'; ?>"></link>
    <link rel="stylesheet" type="text/css" href="<?= $_SESSION['base_url1'].'/assets/css/select2.css'; ?>">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?= $_SESSION['base_url1'].'/assets/css/_all-skins.min.css'; ?>">
    <link rel="stylesheet" type="text/css" href="<?= $_SESSION['base_url1'].'/assets/css/style.css'; ?>">
    <?
      echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$_SESSION[base_url1]/assets/css/datepicker.min.css\">";
    ?>
    <!--<link rel="apple-touch-icon" href="{{ asset('img/apple-touch-icon.png') }}">-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      <header class="main-header">

        <!-- Logo -->
        <a href="index2.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>P</b>TILLA</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Sistema</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <small class="bg-red">Online</small>&nbsp;&nbsp;&nbsp;&nbsp;
                  <span class="hidden-xs"></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    
                    <p class="text-center">
                      <i class="fa fa-user fa-5x"></i>
                      <br>
                        Usuario: <?= $_SESSION['user']; ?>
                    </p>
                  </li>
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    
                    <div class="pull-right">
                        <a href="<?= $_SESSION['base_url1'].'?logout=1'; ?>" class="btn btn-warning btn-flat">Salir</a>
                    </div>
                  </li>
                </ul>
              </li>
              
            </ul>
          </div>

        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <? include_once $_SESSION['base_url'].'/partials/menu_lateral.php'; ?>
        <!-- /.sidebar -->
      </aside>
       <!--Contenido TODO LO DE EL MEDIO -->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title"></h3>
                  
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                      <div class="col-md-12 col-sm-12">
                              <!--Contenido-->
                              