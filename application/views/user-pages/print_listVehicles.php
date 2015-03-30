<?php
set_time_limit(0);
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=vehicles.xls");
header("Cache-Control: cache, must-revalidate");
header("Pragma: public");
?>
<table class="table table-hover table-bordered table-with-20-percent-td">
				<tbody>
					<tr>
					    <th>Registration Number </th>
					    <th>Model</th>
					    <th>Make</th>
					    <th>Owner Name</th>
					    <th>Contact Info</th>
					    <th>Address</th>
						<!--<th>Driver Details</th>
						<th>Current Status</th>-->
						
					    
					</tr>
					<?php
					if(isset($values)){  
					foreach ($values as $det): 
				
					?>
					<tr> 
					    <td><?php  echo $det['registration_number'].br();?></td>
						<td><?php if($det['vehicle_model_id']<=0){ echo '';}else{echo $vehicle_models[$det['vehicle_model_id']].br();} ?></td>
						<td><?php if($det['vehicle_make_id']<=0){ echo '';}else{echo $vehicle_makes[$det['vehicle_make_id']];} ?></td>
						<td><?php if($det['vehicle_owner_id']<=0){ echo '';}else{echo $vehicle_owners[$det['vehicle_owner_id']].br();}?></td>
						<td><?php if($det['vehicle_owner_id']<=0){ echo '';}else{echo $owner_details[$det['vehicle_owner_id']]['mobile'].br();} ?></td>
						<td><?php if($det['vehicle_owner_id']<=0){ echo '';}else{echo $owner_details[$det['vehicle_owner_id']]['address'];} ?></td>
						<!--<td><?php if(!isset($drivers[$det['id']]['driver_name']) || $drivers[$det['id']]['driver_name']==''){ echo '';}else{echo $drivers[$det['id']]['driver_name'].br();}
						if(!isset($drivers[$det['id']]['mobile']) || $drivers[$det['id']]['mobile']==''){ echo '';}else{echo $drivers[$det['id']]['mobile'].br();}
						if(!isset($drivers[$det['id']]['from_date']) || $drivers[$det['id']]['from_date']==''){ echo '';}else{echo $drivers[$det['id']]['from_date']; } ?></td>
						<td><?php if($vehicle_statuses[$det['id']]!='Available'){ echo '<span class="label label-info">'.$vehicle_statuses[$det['id']].'</span>'.br(); }else{ echo '<span class="label label-success">'.$vehicle_statuses[$det['id']].'</span>'.br(); } if($vehicle_trips[$det['id']]!=gINVALID){ echo anchor(base_url().'organization/front-desk/trip-booking/'.$vehicle_trips[$det['id']],'Trip ID :'.$vehicle_trips[$det['id']]); } else{ echo ''; } ?></td>-->	
					</tr>
					<?php endforeach;
					}
					?>
				</tbody>
			</table>