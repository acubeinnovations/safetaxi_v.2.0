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
		<legend class="body-head">List Vehicles</legend>
		<div class="box-body table-responsive no-padding">
			<?php echo form_open(base_url().'front-desk/list-vehicle');?>
			<table class="table list-org-table">
				<tbody>
					<tr>
					    <td><?php echo form_input(array('name'=>'reg_num','class'=>'form-control','id'=>'reg_num','placeholder'=>'By Registration Number','size'=>30));?> </td>
						 <td><?php $class="form-control";
						 $id="vehicle-owner";
						echo $this->form_functions->populate_dropdown('owner',$vehicle_owners,$selected='',$class,$id,$msg='Select Vehicle Owner')?> </td>
						<!--<td><?php// $class="form-control";
						//echo $this->form_functions->populate_dropdown('v_type',$vehicle_types,$selected='',$class,$id='',$msg='Select Vehicle Type')?></td>-->
						<td><?php $class="form-control";
						 $id="vehicle-model";
						echo $this->form_functions->populate_dropdown('v_model',$vehicle_models,$selected='',$class,$id,$msg='Select Vehicle Model')?></td>
						 <td><?php $class="form-control";
						  $id="vehicle-ownership";
						echo $this->form_functions->populate_dropdown('ownership',$vehicle_ownership_types,$selected='',$class,$id,$msg='Select Vehicle Ownership')?> </td>
					    <td><?php echo form_submit("search","Search","class='btn btn-primary'");?></td>
					    <?php echo form_close();?>
						<td><?php echo nbs(55); ?></td>
						<td><?php echo nbs(35); echo form_close(); ?></td>
						
						<td><?php echo form_open( base_url().'front-desk/vehicle');
								  echo form_submit("add","Add","class='btn btn-primary'");
								  echo form_close(); 
						?></td>
						<td><?php echo form_button('print-vehicle','Print',"class='btn btn-primary print-vehicle'"); ?></td>
					</tr>
				</tbody>
			</table>
			<div class="msg"> <?php 
			if (isset($result)){ echo $result;} else {?></div>
		</div>
		<div class="box-body table-responsive no-padding ">
			<table class="table table-hover table-bordered table-with-20-percent-td">
				<tbody>
					<tr>
					    <th>Registration Number </th>
						<th>Contact Details</th>
						<th>Driver Details</th>
						<th>Current Status</th>
						<th>Account Statement</th>
					    
					</tr>
					<?php
					if(isset($values)){  //print_r($values);exit;
					foreach ($values as $det): 
				
					?>
					<tr> 
					    <td><?php  echo anchor(base_url().'front-desk/vehicle/'.$det['id'],$det['registration_number']).br();
						if($det['vehicle_model_id']<=0){ echo '';}else{echo $vehicle_models[$det['vehicle_model_id']].br();}
						if($det['vehicle_make_id']<=0){ echo '';}else{echo $vehicle_makes[$det['vehicle_make_id']];} ?></td>
						<td><?php if($det['vehicle_owner_id']<=0){ echo '';}else{echo $vehicle_owners[$det['vehicle_owner_id']].br();}?>
						<?php if($det['vehicle_owner_id']<=0){ echo '';}else{echo $owner_details[$det['vehicle_owner_id']]['mobile'].br();} ?>
						<?php if($det['vehicle_owner_id']<=0){ echo '';}else{echo $owner_details[$det['vehicle_owner_id']]['address'];} ?></td>
						<td><?php if(!isset($drivers[$det['id']]['driver_name']) || $drivers[$det['id']]['driver_name']==''){ echo '';}else{echo $drivers[$det['id']]['driver_name'].br();}
						if(!isset($drivers[$det['id']]['mobile']) || $drivers[$det['id']]['mobile']==''){ echo '';}else{echo $drivers[$det['id']]['mobile'].br();}
						if(!isset($drivers[$det['id']]['from_date']) || $drivers[$det['id']]['from_date']==''){ echo '';}else{echo $drivers[$det['id']]['from_date']; } ?></td>
						<td><?php if($vehicle_statuses[$det['id']]!='Available'){ echo '<span class="label label-info">'.$vehicle_statuses[$det['id']].'</span>'.br(); }else{ echo '<span class="label label-success">'.$vehicle_statuses[$det['id']].'</span>'.br(); } if($vehicle_trips[$det['id']]!=gINVALID){ echo anchor(base_url().'front-desk/trip-booking/'.$vehicle_trips[$det['id']],'Trip ID :'.$vehicle_trips[$det['id']]); } else{ echo ''; } ?></td>
						<td><?php ?></td>
					
					    	
						
					</tr>
					<?php endforeach;
					}
					?>
				</tbody>
			</table><?php echo $page_links;?>
		</div>
		<?php }?>
	</fieldset>
	<?php echo form_close(); ?>
</div>
