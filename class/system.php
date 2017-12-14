<?php

	if(!isset($_SESSION))
	{
		session_start();
	}	
		
	include_once $_SESSION['base_url'].'/connection/connection.php';

	Class System extends Conexion
	{

		 private $connPostgre = "";

		 public $campos;

		 public $values; 

		 public $table;

		 public $sql;

		 public $where = null;

		 public function __construct()
		 {
		 		
		 }

// ================== FUNCIONES ESTÁTICAS ============================================================

		 static function validar_logueo()
		 {
		 		if(!isset($_SESSION['user_id']))
		 		{
		 			header("location: $_SESSION[base_url]");
		 		}
		 }


/*============================================================================================
											FUNCIONES PÚBLICAS POSTGRES
	===========================================================================================*/

		 public function login($user, $pass)
		 {
		 		$this->connPostgre = $this->conectarPostgre();
		 		// Función que se encarga de validar el login
		 		$sql = "SELECT * from public.users as users where users.usuario = :usuario";
		 		
		 		$res = $this->connPostgre->prepare($sql);
		 		$res->bindParam(':usuario', $user, PDO::PARAM_STR);
		 		$res->execute();

		 		
		 		$total = $res->rowCount();

		 		if($total > 0)
		 		{
		 			$rs = $res->fetchObject(__CLASS__);

		 			if(password_verify($pass, $rs->password))
		 			{
	 					$_SESSION['user_id'] = $rs->id;
			 			$_SESSION['nivel'] = $rs->rol_id;
			 			$_SESSION['user'] = $rs->usuario;
			 			$_SESSION['menu'] = $this->make_menu($rs->id);
			 			$_SESSION['base_url'] = $_SESSION['base_url'];
			 			$res = null;
			 			$this->connPostgre = null;		
			 			header('location: ./app/escritorio.php');
		 			}
		 			else
		 			{
		 				exit();
		 				header('location: login.php?r=0');	
			 		}	
		 		}
		 		else
		 		{
		 			
		 			$res = null;
		 			$this->connPostgre = null;
		 			header('location: login.php?r=0');
		 		}
		 			
		 }

		 public function make_menu($id)
		 {
		 
		 		$this->sql = "SELECT * from acceso where user_id = $id";
		 		$res = $this->sql();
		 		$menu = "";
		 		
		 		foreach($res as $row_depar) 
		 		{
		 			$this->table = "public.departamentos";
		 			$depar = $this->find($row_depar->departamento_id);
		 			$areas = explode(',', $row_depar->area_id);
		 			$sub_areas = explode(',', $row_depar->sub_area_id);

		 			$menu .= '<li class="treeview">
										  <a href="#">
										    <i class="fa fa-'.$depar->fa_icon.'"></i>
										    <span>'.$depar->nombre.'</span>
										    <i class="fa fa-angle-left pull-right"></i>
										  </a>
										  <ul class="treeview-menu">';
									  //** AREAS =====================**/
									  foreach ($areas as $row_areas_explode) 
									  {
									  	
											$this->sql = "SELECT nombre, fa_icon from areas where id = $row_areas_explode and departamento_id = $row_depar->departamento_id";
											$res1 = $this->sql();
											foreach ($res1 as $row_areas) 
											{
												$menu .='<li class="treeview">
															      <a href="#">
															        <i class="fa fa-circle-o"></i>
															        <span>'.$row_areas->nombre.'</span>
															        <i class="fa fa-angle-left pull-right"></i>
															      </a>
															      <ul class="treeview-menu">';	
										//** SUB_AREAS =====================**/

												foreach ($sub_areas as $row_sub_areas_explode) 
												{
													$this->sql = "SELECT nombre,archivo from sub_areas 
																				where id = $row_sub_areas_explode and area_id = $row_areas_explode ORDER BY nombre desc";
													$res2 = $this->sql();
													foreach ($res2 as $row_sub_areas) 
													{
														$menu.='
														          <li>
														          	<a href="'.$_SESSION['base_url1'].'/app/'.strtolower($depar->nombre).'/'.strtolower($row_areas->nombre).'/'.strtolower($row_sub_areas->archivo).'">
														          		<i class="fa fa-circle-o"></i>'.ucwords($row_sub_areas->nombre).'
														          	</a>
														          </li>
														        ';
													}
												}
														$menu.= '</ul>
		    													</li>';			
											}
									  }	
							$menu.= '</ul>
		    						</li>';			
		 		}	
		 		return $menu;
		 }

		 public function sql()
		 {
		 		$this->connPostgre = $this->conectarPostgre();

		 		$res = $this->connPostgre->prepare($this->sql);

		 		$res->execute();

		 		$data = [];

 				while ($rs = $res->fetchObject(__CLASS__))
		 		{
		 			$data[] = $rs;
		 		}
		 		$res = null;

		 		$this->connPostgre = null;

		 		return $data;
		 }

		 public function guardar($arreglo)
		 {

			 	// Función global para realizar un insert
		 		$this->connPostgre = $this->conectarPostgre();	

		 		$keys = "";
		 		$values = '';

		 		foreach ($arreglo as $key => $value) 
		 		{
		 			
		 			if($value == "")
		 			{
		 				$value = NULL;
		 			}
		 			
		 			$value = str_replace("'", '"', $value);
					
					$keys .= $key.",";
	 				$values .= "'".trim($value)."'".",";		 				
		 		}
		 		
		 		$keys = substr($keys, 0,strlen($keys) -1);
		 		$values = substr($values, 0,strlen($values) -1);

			 	$sql = 'INSERT INTO '.$this->table.' ('.$keys.') VALUES ('.$values.')';

			 	$res = $this->connPostgre->prepare($sql);

			 	try
			 	{

			 		$res->execute();

			 		$this->connPostgre = null;

			 		$res = null;

			 		$this->table = null;

				 	$data = ['r' => true];
			 	}
			 	catch(PDOException $e)
			 	{
					//echo $e->getMessage();
					//echo $sql."<br>";			 		
					//exit();
			 		$this->connPostgre = null;

			 		$res = null;

				 	$this->table = null;

				 	$data = ['r' => false,'sql' => $sql];
			 	}

			 	return $data;
		 }

		 public function modificar($arreglo)
		 {
		 	
		 	$this->connPostgre = $this->conectarPostgre();	

		 	$campos = " SET ";

		 	foreach ($arreglo as $key => $value) {

		 		if($value == '')
	 			{
	 				$value = NULL;
	 			}

	 			$value = str_replace("'", '"', $value);

		 		$campos .= $key."="."'".trim($value)."', ";
		 	}
		 	
		 	$campos = substr($campos, 0, strlen($campos)- 2);

		 	$sql = "UPDATE ".$this->table.$campos."WHERE ".$this->where;

		 	$res = $this->connPostgre->prepare($sql);
			$res->execute();
			$this->connPostgre = null;

			if($res->execute())
			 	{
			 		$this->connPostgre = null;

			 		$res = null;

			 		$this->table = null;

				 	$data = ['r' => true];
			 	}
			 	else
			 	{
			 		$this->connPostgre = null;

			 		$res = null;

				 	$this->table = null;

				 	$data = ['r' => false,'sql' => $sql];
			 	}
			 	
			 	return $data;
		 }

		 public function eliminar()
		 {
		 		$this->connPostgre = $this->conectarPostgre();

				$sql = "DELETE from ".$this->table." WHERE ".$this->where;

				$res = $this->connPostgre->prepare($sql);
				try
				{
					$res->execute();
					$data = ['r' => true];	
				}
				catch(PDOException $e)
				{
					$data = ['r' => false,'sql' => $sql, 'exeption' => $e->getMessage()];	
				}

				$this->connPostgre = null;

				return $data;
		 }

		 public function find($id = null)
		 {
		 		$this->connPostgre = $this->conectarPostgre();

		 		if($id)
		 		{

		 			$sql = "SELECT * from ".$this->table." WHERE id = ".$id;
		 		}
		 		else
		 		{
		 			$sql = "SELECT * from ".$this->table." WHERE ".$this->where."LIMIT 1";	
		 		}

		 		$res = $this->connPostgre->prepare($sql);

		 		$res->execute();

 				$rs = $res->fetchObject(__CLASS__);
		 		
		 		$res = null;

		 		$this->connPostgre = null;
		 		$this->table = null;

		 		return $rs;
		 }

		 public function count()
		 {
		 		$this->connPostgre = $this->conectarPostgre();

		 		if($this->where)
		 		{

		 			$sql = "SELECT count(*) as total from ".$this->table." WHERE ".$this->where;
		 		}
		 		else
		 		{
		 			$sql = "SELECT count(*) as total from ".$this->table;	
		 		}
		 		
		 		$res = $this->connPostgre->prepare($sql);
		 		$res->execute();
		 		$rs = $res->fetchObject(__CLASS__);
		 		$this->table = null;
		 		$this->where = null;
		 		return $rs->total;
		 }

		 public function max($campo)
		 {
		 		$this->connPostgre = $this->conectarPostgre();

		 		if($this->where)
		 		{

		 			$sql = "SELECT max($campo) as $campo from ".$this->table." WHERE ".$this->where;
		 		}
		 		else
		 		{
		 			$sql = "SELECT max($campo) as $campo from ".$this->table;
		 		}

		 		$res = $this->connPostgre->prepare($sql);
		 		$res->execute();
		 		$rs = $res->fetchObject(__CLASS__);
		 		$this->table = null;
		 		$this->where = null;
		 		return $rs->$campo;
		 }

		 public function clean_table()
		 {
		 	
		 	$this->connPostgre = $this->conectarPostgre();

		 	$sql = "TRUNCATE TABLE $this->table";
		 	$res = $this->connPostgre->prepare($sql);
		 	$res->execute();

		 	$this->connPostgre = null;

		 }

		 public function cols_boostrap($cantidad)
		 {
		 		$col = "";

		 		if($cantidad >= 4)
		 		{
		 			$col = 3;
		 		}
		 		else
		 		{
		 			$col = 12 / $cantidad;
		 		}

		 		return $col;
		 }
	}
?>