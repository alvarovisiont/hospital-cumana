<?
	if(!isset($_SESSION))
	{
	  session_start();
	}

	include_once $_SESSION['base_url'].'/class/system.php';
	$system = new System;

	switch ($_REQUEST['action']) {
		case 'registrar':
			
			unset($_POST['action']);
			unset($_POST['id_modificar']);	

			$_POST['logo'] = '';

			if(!empty($_FILES['logo']['name']))
			{
				
				$file = $_FILES['logo'];

				if($file['type'] == 'image/jpeg' || $file['type'] == 'image/png')
				{
					$ruta_temp = $file['tmp_name'];
					$nombre    = $file['name'];
					$ruta_guardado = $_SESSION['base_url']."/assets/images/images_hospital/".$nombre;
					move_uploaded_file($ruta_temp, $ruta_guardado);

					$_POST['logo'] = $nombre;
				}
					
			}

			$system->table = "hospital.configuracion";
			echo json_encode($system->guardar($_POST));
		break;

		case 'modificar':

			$system->table = "hospital.configuracion";
			$system->where = "id = $_POST[id_modificar]";

			unset($_POST['action']);
			unset($_POST['id_modificar']);	

			if(!empty($_FILES['logo']['name']))
			{
				
				$file = $_FILES['logo'];

				if($file['type'] == 'image/jpeg' || $file['type'] == 'image/png')
				{
					$ruta_temp = $file['tmp_name'];
					$nombre    = $file['name'];
					$ruta_guardado = $_SESSION['base_url']."/assets/images/images_hospital/".$nombre;
					move_uploaded_file($ruta_temp, $ruta_guardado);

					$_POST['logo'] = $nombre;
				}
					
			}

			echo json_encode($system->modificar($_POST));
		break;

		case 'eliminar':
			
			$system->table = "hospital.configuracion";

			$confi = $system->find($_GET['id']);

			$ruta = $_SESSION['base_url']."/assets/images/images_hospital/".$confi->logo;

			if(file_exists($ruta))
			{
				unlink($ruta);
			}


			$system->table = "hospital.configuracion";
			$system->where = "id = $_GET[id]";


			echo json_encode($system->eliminar());
		break;
		
		default:
			# code...
			break;
	}
?>