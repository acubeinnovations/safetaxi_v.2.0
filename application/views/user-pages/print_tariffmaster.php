<?php
set_time_limit(0);
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=tariff_masters.xls");
header("Cache-Control: cache, must-revalidate");
header("Pragma: public");
?>
			<table class="table table-hover table-bordered">
				<tbody>
					<tr>
						<th>Type</th>
						<?php for ($i=0;$i<count($vehicle_models);$i++){?>
						<th><?php echo $vehicle_models[$i]['name'] ; ?></th>
						<?php } ?>
					</tr>
					<tr>
						<td></td>
						<?php for ($i=0;$i<count($vehicle_models);$i++){?>
						<td> AC/Non-AC</td>
						
						<?php } ?>
				</tr>
				<?php  foreach($tariffs as $key_tariff):?> 
					<tr>
					
					<td><?php echo $key_tariff['title'] ; ?></td>
					<?php 
					for ($i=0;$i<count($vehicle_models);$i++){ 
					$model=$vehicle_models[$i]['id'];
					
					?>
					
					<td><?php  if($model){
					if(isset($key_tariff[1][$model]['rate'])){
					$r=$key_tariff[1][$model]['rate'];
					$min=$key_tariff[1][$model]['minimum_kilometers'];
					$actual_rate=$r*$min;
					echo '<p style="color:red;">'.$actual_rate.'</p>';
					
					
					}else if(isset($key_tariff[2][$model]['rate'])){
					$r=$key_tariff[2][$model]['rate'];
					$min=$key_tariff[2][$model]['minimum_kilometers'];
					$actual_rate=$r*$min;
					echo '<p style="color:red;">'.$actual_rate.'</p>';
					
					}else{
					echo "N/A";
					}
					}
					else{
					echo "N/A";
					}
					}
					 ?></td>
										
					</tr><?php endforeach;?>
				</tbody>
			</table>