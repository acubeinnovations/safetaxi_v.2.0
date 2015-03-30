<?php
set_time_limit(0);
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=customers.xls");
header("Cache-Control: cache, must-revalidate");
header("Pragma: public");
?>
			<table class="table table-hover table-bordered">
				<tbody>
					<tbody>
					<tr>	
						 
					     <th>Customer </th>
						 <th>Customer Group </th>
						 <th>Customer Type </th>
					    <th>Contact Info</th>
					    <th>Mail ID</th>
					    <th>Address</th>
					    <th>Trip Details</th>	
						<th>Current Status</th>	
						<th>Account Statement</th>
						
					</tr>
					<?php
					
					for($customer_index=0;$customer_index<count($customers);$customer_index++){
					?>
					<tr>
						
						<td><?php echo $customers[$customer_index]['name'].br();?></td>
<td><?php if($customers[$customer_index]['customer_group_id']==gINVALID || $customers[$customer_index]['customer_group_id']==0){ echo " ";}else{echo $customer_groups[$customers[$customer_index]['customer_group_id']].br();}?></td>
					    
						<td><?php if($customers[$customer_index]['customer_type_id']==gINVALID || $customers[$customer_index]['customer_type_id']==0){ echo " ";}else{echo $customer_types[$customers[$customer_index]['customer_type_id']];} ?></td>
						<td><?php echo $customers[$customer_index]['mobile'].br();?>
						<td><?php echo $customers[$customer_index]['email'].br(); ?></td>
						<td><?php echo $customers[$customer_index]['address']; ?></td>
						</td>
					    <td><?php if($customer_trips[$customers[$customer_index]['id']]!=gINVALID){ echo 'Trip ID :'.$customer_trips[$customers[$customer_index]['id']]; } else{ echo ''; }  ?></td>
						 <td><?php if($customer_statuses[$customers[$customer_index]['id']]!='NoBookings'){ echo '<span class="label label-info">'.$customer_statuses[$customers[$customer_index]['id']].'</span>'.br(); }else{ echo '<span class="label label-danger">'.$customer_statuses[$customers[$customer_index]['id']].'</span>'.br(); }  ?></td>	
						 <td></td>
						
					</tr>
					<?php 
						}
					?>
				</tbody>
				
				</tbody>
			</table>
