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
			$patologias = "";

			if($_POST['fecha_nacimiento'] == "")
			{
			  	$_POST['fecha_nacimiento'] =  '1830-02-10';
			}
			else
			{
				$_POST['fecha_nacimiento'] = date('Y-m-d', strtotime($_POST['fecha_nacimiento']));
			}

			if($_POST['fecha_admin_ant'] == "")
			{
			  	$_POST['fecha_admin_ant'] =  '1830-02-10';
			}
			else
			{
				$_POST['fecha_admin_ant'] = date('Y-m-d', strtotime($_POST['fecha_admin_ant']));	
			}

			if(isset($_POST['patologias']) && count($_POST['patologias']) > 0)
			{
				foreach ($_POST['patologias'] as $row) 
				{
					$patologias.= $row.',';
				}

				$patologias = substr($patologias, 0,strlen($patologias) - 1);
			}


			$_POST['patologias'] = $patologias;

			$system->table = "emergencia.ingreso_emergencia";
			$res = $system->guardar($_POST);

			unset($_POST['motivo_admision']);
			unset($_POST['enfermedad_actual']);
			unset($_POST['diagnostico_admision']);
			unset($_POST['medico_admision']);
			unset($_POST['medico_departamento']);
			unset($_POST['created_at']);
			unset($_POST['update_at']);

			if($res['r'] === true && $_POST['cedula'] !== "")
			{
				$system->table = "emergencia.historial_emergencias";
				$system->where = "cedula = $_POST[cedula]";
				$total = $system->count();
				if($total < 1)
				{
					$system->table = "emergencia.historial_emergencias";
					echo json_encode($system->guardar($_POST));
				}
			}
			else
			{
				echo json_encode($res);
			}

		break;

		case 'modificar':

			$system->table = "emergencia.ingreso_emergencia";
			$system->where = "id = $_POST[id_modificar]";

			unset($_POST['action']);
			unset($_POST['id_modificar']);	

			$patologias = "";

			if($_POST['fecha_nacimiento'] == "")
			{
			  	$_POST['fecha_nacimiento'] =  '1830-02-10 00:00:00';
			}
			else
			{
				$_POST['fecha_nacimiento'] = date('Y-m-d', strtotime($_POST['fecha_nacimiento']));
			}

			if($_POST['fecha_admin_ant'] == "")
			{
			  	$_POST['fecha_admin_ant'] =  '1830-02-10 00:00:00';
			}
			else
			{
				$_POST['fecha_admin_ant'] = date('Y-m-d', strtotime($_POST['fecha_admin_ant']));	
			}

			if(count($_POST['patologias']) > 0)
			{
				foreach ($_POST['patologias'] as $row) 
				{
					$patologias.= $row.',';
				}

				$patologias = substr($patologias, 0,strlen($patologias) - 1);
			}


			$_POST['patologias'] = $patologias;

			echo json_encode($system->modificar($_POST));
		break;

		case 'eliminar':
			$system->table = "emergencia.ingreso_emergencia";
			$system->where = "id = $_GET[id]";

			echo json_encode($system->eliminar());
		break;
		
		case 'salida_emergencia':
			unset($_POST['action']);

			$arreglo = ['alta' => 1];
			$system->table = "hospital.pacientes";
			$system->where = "emergencia_id = $_POST[emergencia_id]";
			$res = $system->modificar($arreglo);

			if($res['r'])
			{
				$system->table = "emergencia.salida_emergencia";
				echo json_encode($system->guardar($_POST));
			}
			
		break;

		case 'guardar_tratamiento':
			unset($_POST['action']);
			unset($_POST['suministrado_por']);

			$fecha = new DateTime($_POST['fecha_aplicado']);
			$_POST['fecha_aplicado'] = $fecha->format('Y-m-d');


			$system->table = "emergencia.tratamientos";
			$respuesta     = $system->guardar($_POST);
			
			if($respuesta['r'])
			{
				$system->sql  = "UPDATE hospital.almacen SET cantidad = cantidad - $_POST[cantidad] where id = $_POST[almacen_id]";
				
				$system->sql();
				echo json_encode($respuesta);		
				
			}
			else
			{
				echo json_encode($respuesta);
			}

		break;

		case 'eliminar_tratamiento':

			$system->sql  = "UPDATE hospital.almacen SET cantidad = cantidad + $_POST[cantidad] where id = $_POST[almacen]";
			$system->sql();

			$system->table = "emergencia.tratamientos";
			$system->where = "id = $_POST[id]";
			echo json_encode($system->eliminar());
		break;

		case 'buscar_habitacion':
			$val = $_GET['value'];

			$system->sql = "SELECT id, numero_habitacion, piso,cantidad_camillas
							from hospital.habitaciones
							WHERE departamento_id = $val";
			$res = $system->sql();
			$data = [];
			foreach ($res as $row) 
			{
				$system->table = "hospital.pacientes";
				$system->where = "habitacion_id = $row->id and alta = 0";
				$total = $system->count();

				if($total !== $row->cantidad_camillas)
				{
					$data[] = $row;
				}
			}

			echo json_encode($data);

		break;

		case 'guardar_subida_piso':
			
			$arreglo = ['alta' => 1];
			$system->table = "hospital.pacientes";
			$system->where = "emergencia_id = $_POST[emergencia_id]";
			$res = $system->modificar($arreglo);

			if($res['r'])
			{
				unset($_POST['action']);
				$system->table = "hospital.pacientes";
				echo json_encode($system->guardar($_POST)); 
			}	
		break;

		case 'eliminar_emergencia':

			$system->table = "emergencia.ingreso_emergencia";
			$system->where = "id = $_GET[id]";

			echo json_encode($system->eliminar());
		break;

		default:
			# code...
			break;
	}
?>