<?php  ?> 

<div class="driver-notifications">
 
	<fieldset class="body-border">
		<legend class="body-head">Driver Notifications</legend>
		<div class="box-body table-responsive no-padding">
			
			
			<form action="<?php echo base_url(); ?>front-desk/driver-notifications" method="get">
			<table class="table list-trip-table no-border">
				<tbody>
					<tr>

					    <td>
							<?php $class="form-control";
							 
							echo $this->form_functions->populate_dropdown('period',$periods,$period,$class,'periods',"Select period"); ?>
							<div class="hide-me"><input name="id" type="text" value="<?php echo $id; ?>"></div>
						</td>
						<td>
							<?php $class="form-control";
							 
							echo $this->form_functions->populate_dropdown('notification_view_status',$notification_view_statuses,$notification_view_status,$class,'notification_view_statuses',"Select view statuses"); ?>
							
						</td>
						<td>
							<?php $class="form-control";
							 
							echo $this->form_functions->populate_dropdown('notification_type',$notification_types,$notification_type,$class,'notification_types',"Select notification types"); ?>
							
						</td>
					   
					    <td><?php echo form_submit("notification_search","Search","class='btn btn-primary'");
echo form_close();?></td>
					
					</tr>
				</tbody>
			</table>
		</div>
	
	 <?php 
			if ($msg!=''){?> <div class="msg"> <?php echo $msg; ?> </div> <?php } else {?>
		
		<div class="box-body table-responsive no-padding trips-table">
			<table class="table table-hover table-bordered">
				<tbody>
					<tr>	
						
					    <th style="width:2%">Sl no: </th>
						 <th style="width:10%">Notification Id</th>
					    <th style="width:19%">Notification Type</th>
						  <th style="width:15%">Trip Details</th>
						<th style="width:15%">Customer Details</th>
					    <th style="width:15%">Status</th>
					   
					</tr>
					<?php
					
					
					for($notification_index=0;$notification_index<count($values);$notification_index++){
						
					?>
					<tr>
						<td><?php echo $notification_sl_no;?></td>
						<td><?php echo $values[$notification_index]['notification_id'];?></td>
						<td><?php echo $values[$notification_index]['notification_type'];?></td>
					   	<td><?php echo 'Trip Id :'.$values[$notification_index]['trip_id'].br().'Trip From :'.$values[$notification_index]['trip_from'];?></td>

						<td><?php echo 'Customer :'.$values[$notification_index]['customer'].br().'Mobile :'.$values[$notification_index]['mobile'];?></td>
					   	<td><?php if($values[$notification_index]['notification_view_status_id']==NOTIFICATION_VIEWED_STATUS){ $class="label-success"; }else if($values[$notification_index]['notification_view_status_id']==NOTIFICATION_NOT_VIEWED_STATUS){ $class="label-danger"; } echo '<span class="label '.$class.'">'.$values[$notification_index]['notification_view_status'].'</span>';?></td>
					   
					</tr>

					<?php 
						$notification_sl_no++;
						}
					?>
					
					<!-- -->
				</tbody>
			</table><?php echo $page_links;?>
		</div>
		<?php } ?>
	</fieldset>

</div>

