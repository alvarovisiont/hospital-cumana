<?
	if(!isset($_SESSION))
	{
	  session_start();
	}

	include_once $_SESSION['base_url'].'/class/system.php';
	$system = new System;

	switch ($_REQUEST['action']) 
	{
		case 'registrar':
			unset($_POST['action']);
			unset($_POST['id_modificar']);
			$res = "";

			$data = [
				'nombre_completo' => $_POST['nombre_completo'],
				'cedula' => $_POST['cedula'],
				'usuario' => $_POST['usuario'],
				'password' => password_hash($_POST['password'],PASSWORD_DEFAULT),
				'telefono' => $_POST['telefono'],
				'rol_id' => $_POST['rol_id'],
				'created_at' => $_POST['created_at'],
				'updated_at' => $_POST['updated_at']
			];

			$system->table = "public.users";
			$system->guardar($data);

			$system->table = "public.users";
			$id = $system->max('id');

			$departamentos = substr($_POST['departamentos_grabar'],0,strlen($_POST['departamentos_grabar']) -1);
			$departamentos = explode(',',$departamentos);
			$areas = "";
			$sus_areas = "";

			foreach ($departamentos as $row) 
			{
				$areas = "";
				$sub_areas = "";
				
				if(array_key_exists('area_'.$row, $_POST))
				{
					foreach ($_POST['area_'.$row] as $row1) 
					{
						$areas.= $row1.',';

						if(array_key_exists('sub_area_'.$row1, $_POST))
						{
							foreach ($_POST['sub_area_'.$row1] as $row2) 
							{
								$sub_areas .= $row2.','; 	
							}
						}
					}
				}

				$areas = substr($areas,0,strlen($areas) -1);
				$sub_areas = substr($sub_areas,0,strlen($sub_areas) -1);

				$data  = [
					'user_id' => $id,
					'departamento_id' => $row,
					'area_id' => $areas,
					'sub_area_id' => $sub_areas,
					'created_at' => $_POST['created_at'],
					'updated_at' => $_POST['updated_at']
				];

				$system->table = "acceso";
				$res = $system->guardar($data);
				if(!$res['r'])
				{
					echo json_encode($res);
					exit();		
				}
			}

			echo json_encode($res);
		break;

		case 'modificar':
		
			$res = "";
			$id_modificar = $_POST['id_modificar'];
			$data = "";

			unset($_POST['action']);
			unset($_POST['id_modificar']);

			$system->table = "public.users";
			$system->where = "id = $id_modificar";


			if($_POST['password'] !== '')
			{
				$_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
				
				$data = [
					'nombre_completo' => $_POST['nombre_completo'],
					'cedula' => $_POST['cedula'],
					'usuario' => $_POST['usuario'],
					'password' => $_POST['password'],
					'telefono' => $_POST['telefono'],
					'rol_id' => $_POST['rol_id'],
					'created_at' => $_POST['created_at'],
					'updated_at' => $_POST['updated_at']
				];	
			}
			else
			{
				$data = [
					'nombre_completo' => $_POST['nombre_completo'],
					'cedula' => $_POST['cedula'],
					'usuario' => $_POST['usuario'],
					'telefono' => $_POST['telefono'],
					'rol_id' => $_POST['rol_id'],
					'created_at' => $_POST['created_at'],
					'updated_at' => $_POST['updated_at']
				];		
			}

			

			$system->modificar($data);

			$system->table = "public.acceso";
			$system->where = "user_id = $id_modificar";
			$system->eliminar();

			$departamentos = substr($_POST['departamentos_grabar'],0,strlen($_POST['departamentos_grabar']) -1);
			$departamentos = explode(',',$departamentos);
			$areas = "";
			$sus_areas = "";

			foreach ($departamentos as $row) 
			{
				$areas = "";
				$sub_areas = "";
				
				if(array_key_exists('area_'.$row, $_POST))
				{
					foreach ($_POST['area_'.$row] as $row1) 
					{
						$areas.= $row1.',';

						if(array_key_exists('sub_area_'.$row1, $_POST))
						{
							foreach ($_POST['sub_area_'.$row1] as $row2) 
							{
								$sub_areas .= $row2.','; 	
							}
						}
					}
				}

				$areas = substr($areas,0,strlen($areas) -1);
				$sub_areas = substr($sub_areas,0,strlen($sub_areas) -1);	

				$data  = [
					'user_id' => $id_modificar,
					'departamento_id' => $row,
					'area_id' => $areas,
					'sub_area_id' => $sub_areas,
					'created_at' => $_POST['created_at'],
					'updated_at' => $_POST['updated_at']
				];

				$system->table = "acceso";
				$res = $system->guardar($data);
				if(!$res['r'])
				{
					echo 'aqui';
					//echo json_encode($res);
					
				}
			}

			$_SESSION['menu'] = $system->make_menu($id_modificar);

			echo json_encode($res);

		break;
		
		case 'eliminar':
			$system->table = 'public.users';
			$system->where = 'id = '.$_GET['id'];
			echo json_encode($system->eliminar());
		break;

		case 'buscar_area':
			$system->sql = "SELECT id, nombre from public.areas where departamento_id = $_GET[depar]";
			echo json_encode($system->sql());
		break;

		default:
			# code...
		break;
	}
?>