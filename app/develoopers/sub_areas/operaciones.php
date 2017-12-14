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

			$system->table = "public.sub_areas";
			$system->where = "archivo = '$_POST[archivo]' and departamento_id = $_POST[departamento_id] and area_id = $_POST[area_id]";
			if($system->count() > 0)
			{
				$data = ['r' => false, 'mensaje' => 'Ya existe un registro para la misma area con el mismo nombre de archivo&nbsp;<i class="fa fa-exclamation-circle"></i>'];
				echo json_encode($data);
				exit();
			}
			else
			{
				$system->table = "public.sub_areas";
				echo json_encode($system->guardar($_POST));	
			}
			

				
		break;

		case 'modificar':
		
			$system->table = "public.sub_areas";
			$system->where = "id = $_POST[id_modificar]";
			unset($_POST['action']);
			unset($_POST['id_modificar']);

			echo json_encode($system->modificar($_POST));	
		break;
		
		case 'eliminar':
			$system->table = 'public.sub_areas';
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