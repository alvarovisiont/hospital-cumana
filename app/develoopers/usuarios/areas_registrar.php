	<?
	//**========================= AREAS =======================
	$z = 0;

	$system->sql = "SELECT id, nombre from public.areas where departamento_id = $row->id";
	$res1 = $system->sql();
	foreach ($res1 as $row1) 
	{
		if($z == 0)
		{
			echo '<div class="row">';
		}
	?>
			<div class="col-md-3">
				<label for="<?= $row1->nombre.''.$row->id;; ?>" class="radio-inline">
					<?= '<strong>'.$row1->nombre.'</strong>'; ?>
					<input type="checkbox" id="<?= $row1->nombre.''.$row->id;; ?>" name="area_<?=$row->id;?>[]" multiple="" value="<?= $row1->id; ?>" class="area_checkbox" data-departamento="<?= $row->id; ?>">
				</label>

				<? //**========================= SUB AREAS ======================= ?>
				<div class="col-md-12 div_sub_<?=$row1->id;?>" style="display: none;">
					<?
						$system->sql = "SELECT id, nombre from public.sub_areas where departamento_id = $row->id and area_id = $row1->id ORDER BY nombre asc";
						$res2 = $system->sql();
						foreach ($res2 as $row2) 
						{
					?>
							<div class="col-md-12">
								<label for="<?= $row2->nombre.'_'.$row1->id; ?>" class="radio-inline">
									<?= $row2->nombre; ?>
									<input type="checkbox" id="<?= $row2->nombre.'_'.$row1->id; ?>" name="sub_area_<?=$row1->id;?>[]" multiple="" value="<?= $row2->id; ?>">
								</label>
							</div>	
							<hr style="border: 1px #3c8dbc solid;">
					<?
						}
					?>
				</div>
			</div>
	<?
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
	?>