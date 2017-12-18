<?

	$z = 0;

	$system->table = "acceso";
	$system->where = "departamento_id = $row->id and user_id = $usuario->id";
	$acceso = $system->find();


	//**========================= AREAS =======================
	$system->sql = "SELECT id, nombre from public.areas where departamento_id = $row->id";
	$res1 = $system->sql();
	foreach ($res1 as $row1) 
	{
		$check = null;
		
		if(!empty($acceso))
		{
			$acceso_areas = explode(',',$acceso->area_id);

			foreach ($acceso_areas as $areas_explode) 
			{
				if($row1->id == $areas_explode)
				{
					$check = 'checked=""';
				}
			}

			$valida = true;
		}
		
		if($z == 0)
		{
			echo '<div class="row">';
		}
	?>
		<div class="col-md-3">
			<label for="<?= $row1->nombre.''.$row->id; ?>" class="radio-inline">
				<?= '<strong>'.$row1->nombre.'</strong>'; ?>
				<input type="checkbox" id="<?= $row1->nombre.''.$row->id; ?>" name="area_<?=$row->id;?>[]" multiple="" value="<?= $row1->id; ?>" class="area_checkbox" data-departamento="<?= $row->id; ?>" <?= $check; ?> >
			</label>

			<? //**========================= SUB AREAS ======================= ?>
			<div class="col-md-12 div_sub_<?=$row1->id;?>" style="<?= $check ? '' : 'display: none'; ?> ">
				<?
					$system->sql = "SELECT id, nombre from public.sub_areas where departamento_id = $row->id and area_id = $row1->id ORDER BY nombre asc";
					$res2 = $system->sql();
					foreach ($res2 as $row2) 
					{
						$checked_sub = null;
						if(!empty($acceso))
						{
							$acceso_sub_areas = explode(',',$acceso->sub_area_id);
							foreach ($acceso_sub_areas as $sub_areas_explode) 
							{
								if($row2->id == $sub_areas_explode)
								{
									$checked_sub = 'checked=""';
								}
							}
						}
				?>
						<div class="col-md-12">
							<label for="<?= $row2->nombre.'_'.$row1->id; ?>" class="radio-inline">
								<?= $row2->nombre; ?>
								<input type="checkbox" id="<?= $row2->nombre.'_'.$row1->id; ?>" name="sub_area_<?=$row1->id;?>[]" multiple="" value="<?= $row2->id; ?>" <?= $checked_sub; ?> >
							</label>
						</div>	
						<hr style="border: 1px #3c8dbc solid;">
				<?
						$checked_sub = null;
					}
				?>
			</div>
		</div>
<?	
		$check = null;
		
		$z++;
		
		if($z == 4)
		{
			echo '</div>';
			$z = 0;
		}		
	}
	
	if($z != '0')
	{
		echo '</div>';
	}

	if($valida)
	{
		$depars.= $row->id.',';
	}

	$valida = false;
?>