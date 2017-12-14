<li class="treeview">
  <a href="#">
    <i class="fa fa-user"></i>
    <span>Develoopers</span>
    <i class="fa fa-angle-left pull-right"></i>
  </a>
  <ul class="treeview-menu">
    <li class="treeview">
      <a href="#">
        <i class="fa fa-bank"></i>
        <span>Departamentos</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
        <ul class="treeview-menu">
          <li><a href="<?= $_SESSION['base_url1'].'/app/develoopers/departamentos/registrar.php'; ?>"><i class="fa fa-circle-o"></i> Registrar Departamento</a></li>
          <li><a href="<?= $_SESSION['base_url1'].'/app/develoopers/departamentos/index.php'; ?>"><i class="fa fa-circle-o"></i> Ver Departamentos</a></li>
        </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-bank"></i>
        <span>Areas</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
        <ul class="treeview-menu">
          <li><a href="<?= $_SESSION['base_url1'].'/app/develoopers/areas/registrar.php'; ?>"><i class="fa fa-circle-o"></i> Registrar Area</a></li>
          <li><a href="<?= $_SESSION['base_url1'].'/app/develoopers/areas/index.php'; ?>"><i class="fa fa-circle-o"></i> Ver Areas</a></li>
        </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-bank"></i>
        <span>Sub-Areas</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
        <ul class="treeview-menu">
          <li><a href="<?= $_SESSION['base_url1'].'/app/develoopers/sub_areas/registrar.php'; ?>"><i class="fa fa-circle-o"></i> Registrar Sub Area</a></li>
          <li><a href="<?= $_SESSION['base_url1'].'/app/develoopers/sub_areas/index.php'; ?>"><i class="fa fa-circle-o"></i> Ver Sub Areas</a></li>
        </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-user"></i>
        <span>Roles</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
        <ul class="treeview-menu">
          <li><a href="<?= $_SESSION['base_url1'].'/app/develoopers/roles/registrar.php'; ?>"><i class="fa fa-circle-o"></i> Registrar Rol</a></li>
          <li><a href="<?= $_SESSION['base_url1'].'/app/develoopers/roles/index.php'; ?>"><i class="fa fa-circle-o"></i> Ver Roles</a></li>
        </ul>
    </li>
  </ul>
</li>       