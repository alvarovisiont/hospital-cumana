<section class="sidebar">
          <!-- Sidebar user panel -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"></li>
            <li>
              <a href="#">
                 <small class=""><i class="fa fa-window-restore" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;</small><span>Inicio</span>
              </a>
            </li>
            <? 
              echo $_SESSION['menu'];
            
              if($_SESSION['nivel'] < 3)
              {
            ?>
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-users"></i>
                  <span>Usuarios</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="<?= $_SESSION['base_url1'].'/app/develoopers/usuarios/registrar.php'; ?>"><i class="fa fa-circle-o"></i> Registrar Usuario</a></li>
                  <li><a href="<?= $_SESSION['base_url1'].'/app/develoopers/usuarios/index.php'; ?>"><i class="fa fa-circle-o"></i> Ver Usuario</a></li>
                </ul>
              </li>
            <?
                if($_SESSION['nivel'] < 2)
                {
                  include_once $_SESSION['base_url'].'/partials/menu_programador.php';
                }
              }
            ?>
             
          </ul>
        </section>