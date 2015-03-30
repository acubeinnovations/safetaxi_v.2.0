<?php    if($this->session->userdata('dbSuccess') != '') { 
?>

        <div class="success-message">
            <div class="alert alert-success alert-dismissable">
                <i class="fa fa-check"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php 
                echo $this->session->userdata('dbSuccess');
                $this->session->set_userdata(array('dbSuccess'=>''));
                ?>
           </div>
       </div>
       <?php    } ?>
	  <?php 
	  //search?>

<div class="page-outer">    
	<fieldset class="body-border">
		<legend class="body-head">List Drivers</legend>
		<div class="box-body table-responsive no-padding">
			<form action="<?php echo base_url(); ?>front-desk/list-driver" method="get">
			<table class="table list-org-table">
				<tbody>
					<tr>
					    <td><?php echo form_input(array('name'=>'driver_name','class'=>'form-control','id'=>'driver_name','placeholder'=>'By Name','size'=>30,'value'=>$driver_name));?> </td>
						<td><?php echo form_input(array('name'=>'driver_city','class'=>'form-control','id'=>'driver_city','placeholder'=>'By City','size'=>30,'value'=>$driver_city));?> </td>
						<td><?php $class="form-control";
							  $id='status';
							  $status[1]='Available';
							  $status[2]='On-Trip';
							  if(isset($status_id)){
							  $status_id=$status_id;
							  }
							  else{
							   $status_id='';
							  }
						echo $this->form_functions->populate_dropdown('status',$status,$status_id,$class,$id,$msg="Select Status");?> </td>
						 <td><?php $class="form-control";
							  $id='drivers';
						echo $this->form_functions->populate_dropdown('drivers',$drivers,$driver_id,$class,$id,$msg="Select Driver");?></td>


					    
						<td><?php echo form_submit("search","Search","class='btn btn-primary'");?></td>
						
					    <?php echo form_close();?>
						<td><?php echo nbs(55); ?></td>
						<td><?php echo nbs(35); ?></td>
						
						<td><?php echo form_open( base_url().'front-desk/driver-profile');
								  echo form_submit("add","Add","class='btn btn-primary'");
								  echo form_close(); ?></td>
						<td><?php echo form_button('print-driver','Print',"class='btn btn-primary print-driver'"); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="msg"> </div>
	
		
		<div class="box-body table-responsive no-padding">
			<?php if($results!='true'){  ?><div class="msg"> <?php echo $results; ?> </div><?php }else{ ?>
			<table class="table table-hover table-bordered">
				<tbody>
					<tr>
						 <th style="width:10%;">Sl No</th>
					    <th style="width:10%;">Driver</th>
					    <th style="width:10%;">Contact Details</th>
					    <th style="width:10%;">Registration Number</th>
					    <th style="width:10%;">App Key</th>
						<th style="width:10%;">Current Status</th>
						<th style="width:10%;">Notifications</th>
						
					</tr>
					<?php 
					
					foreach ($values as $det):
					$phone_numbers='';
					?>
					<tr>
						<td width="10%"><?php echo $driver_sl_no; ?> </td>
					    <td><?php echo anchor(base_url().'front-desk/driver-profile/'.$det['id'],$det['name']).nbs(3);?></td>
					    <td><?php echo $det['mobile'];?></td>	
						<td><?php echo $det['vehicle_registration_number'];?></td>
						<td><?php echo $det['app_key'];?></td>
						<td><?php if($det['driver_status_id']==DRIVER_STATUS_ACTIVE){ $class="label-success"; }else if($det['driver_status_id']==DRIVER_STATUS_ENGAGED){ $class="label-danger"; } echo '<span class="label '.$class.'">'.$det['driver_status'].'</span>'; ?></td>
						<td><?php echo anchor(base_url().'front-desk/driver-notifications?id='.$det['id'],'Notifications'); ?></td>
					</tr>
					<?php 
					$driver_sl_no++;
					endforeach;
					
					?>
				</tbody>
			</table><?php echo $page_links; 

			}
			?>
		</div>
		
	</fieldset>
</div>

