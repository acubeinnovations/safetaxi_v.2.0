<?php    if($this->session->userdata('dbSuccess') != '') { ?>
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
       <?php    } 
if(!isset($trip_pick_date)){
$trip_pick_date='';
}

if(!isset($customer)){
$customer='';
}
if(!isset($driver_id)){
$driver_id='';
}
if(!isset($vehicle_id)){
$vehicle_id='';
}
if(!isset($trip_status_id)){
$trip_status_id='';
}
$page=$this->uri->segment(4);
if($page==''){
$trip_sl_no=1;
}else{
$trip_sl_no=$page;
}
?>

<div class="trips">

<div class="box">
    <div class="box-body1">
<div class="page-outer">    
	<fieldset class="body-border">
		<legend class="body-head">Drivers Payments</legend>
		<div class="box-body table-responsive no-padding">
			
			<form action="<?php echo base_url(); ?>front-desk/drivers-payments" methjo="get">
			<table class="table list-trip-table no-border">
				<tbody>
					<tr>

						<td><?php echo form_input(array('name'=>'vehicle_number','class'=>'customer form-control' ,'placeholder'=>'KL-7-AB-1234','value'=>$vehiclenumber,'id'=>'c_name')); ?></td>
					    <td><?php echo form_input(array('name'=>'trip_pick_date','class'=>'pickupdatepicker initialize-date-picker form-control' ,'placeholder'=>'From Date','value'=>$trip_pick_date)); ?></td>
					    <!--<td><?php  echo form_input(array('name'=>'trip_drop_date','class'=>'dropdatepicker initialize-date-picker form-control' ,'placeholder'=>'To Date','value'=>$trip_drop_date)); ?></td>-->
						 
						 <td><?php $class="form-control";
							  $id='drivers';
						echo $this->form_functions->populate_dropdown('drivers',$drivers,$driver_id,$class,$id,$msg="Select Driver");?></td>
					 <!--	<td><?php $class="form-control";
							  $id='trip-status';
						echo $this->form_functions->populate_dropdown('trip_status_id',$trip_statuses,$trip_status_id,$class,$id,$msg="Select Trip Status");?></td>
					-->    <td><?php echo form_submit("trip_search","Search","class='btn btn-primary'");
?></form></td>
					
					
						
					</tr>
				</tbody>
			</table>
		</div>
	
	<div class="msg"> <?php 
			if (isset($result)){ echo $result;} else {?></div>
		
		<div class="box-body table-responsive no-padding trips-table">
			<table class="table table-hover table-bordered">
				<tbody>
					<tr>	
						
					    <th style="width:2%">Sl no: </th>
					    <th style="width:19%">Driver</th>
						<!--<th style="width:15%">Customer</th>-->
					   
					    <th style="width:15%">Status</th>
					    <th style="width:15%">Trips</th>
					    <th  style="width:12%">Outstanding Balance</th>
					    <th  style="width:12%">Current Invoice</th>
					    <th style="width:11%">Current Payment</th>	
						<th style="width:11%">Closing Balance</th>	
						
						<th style="width:11%">Action</th>						
						
					</tr>
					<?php
					
					$trip_sl_no=1;
					for($trip_index=0;$trip_index<count($trips);$trip_index++){
						
						//$pickdate=$trips[$trip_index]['Period'];
						//$dropdate=$trips[$trip_index]['drop_date'];

						//$date1 = date_create($pickdate);
						//$date2 = date_create($dropdate);
						
						
					?>
					<tr>
						<td><?php echo $trip_sl_no;?></td>
						<td><a href="<?php echo base_url()."front-desk/driver-payments/".$trips[$trip_index]['driverid'];?>"><?php echo $trips[$trip_index]['Drivername'];?></a></td>
					   	<td><?php echo $trips[$trip_index]['driverstatus'];?></td>
					   	<td><?php echo $trips[$trip_index]['no_of_trips'];?></td>
					   	
					   	<td><?php echo $Outstanding = $trips[$trip_index]['Old_Invoice']-$trips[$trip_index]['Old_Payment']?></td>
					   	<td><?php echo $Current_Invoice=$trips[$trip_index]['Current_Invoice'];?></td>
					   	<td><?php echo $Current_Payment=$trips[$trip_index]['Current_Payment'];?></td>
					   	<td><?php echo $Closing_Balance=$Outstanding+$Current_Invoice-$Current_Payment;?></td>
					   	
					    <td><?php echo "<a href=".base_url().'driver_invoice/'.$trips[$trip_index]['driverid']." class='fa fa-print for print' target='_blank' title='Print'></a>".nbs(5); ?></td>
					</tr>

					<?php 
						$trip_sl_no++;
						}
					?>

				</tbody>
			</table><?php echo $page_links;?>
		</div>
		<?php } ?>
	</fieldset>
</div>

</div><!-- /.box-body -->
   
	<div class='overlay-container'>
   		<div class="overlay modal"></div>
		<div class="loading-img"></div>
		<div class="modal-body border-2-px box-shadow">
			<div class="profile-body width-80-percent-and-margin-auto ">
			<fieldset class="body-border">
   			 <legend class="body-head">Trip Voucher</legend>
				<div class="div-with-50-percent-width-with-margin-10">
					<div class="form-group">
					   <?php echo form_label('Start KM Reading','startkm'); ?>
					   <?php echo form_input(array('name'=>'startkm','class'=>'form-control startkm','id'=>'startkm','placeholder'=>'Enter Start K M')); ?>			
						<span class="start-km-error text-red"></span>
					</div>
					<div class="form-group">
						<?php echo form_label('End Km Reading','endkm'); ?>
						<?php echo form_input(array('name'=>'endkm','class'=>'form-control endkm','placeholder'=>'Enter End KM')); ?>
						<span class="end-km-error text-red"></span>
					</div>
					<div class="form-group">
						<?php echo form_label('Gariage Clossing KM Reading','gariageclosingkm'); ?>
						<?php echo form_input(array('name'=>'garageclosingkm','class'=>'form-control garageclosingkm','placeholder'=>'Enter Gariage closing km')); ?>
						<span class="garage-km-error text-red"></span>
					</div>
					<div class="form-group hide-me">
						<?php echo form_label('Gariage Closing Time','gariageclosingtime'); ?>
						<?php echo form_input(array('name'=>'garageclosingtime','class'=>'form-control garageclosingtime initialize-time-picker','placeholder'=>'Enter Gariage Closing Time')); 
						?>
						<span class="garage-time-error text-red"></span>
					</div>
					<div class="form-group">
						<?php echo form_label('Trip Starting Time','tripstartingtime'); ?>
						<?php echo form_input(array('name'=>'tripstartingtime','class'=>'form-control tripstartingtime format-time','placeholder'=>'Enter Trip Starting Time')); 
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Trip Ending Time','tripendingtimelabel'); ?>
						<?php echo form_input(array('name'=>'tripendingtime','class'=>'form-control tripendingtime format-time','placeholder'=>'Enter Trip Ending Time')); 
						?>
					</div>
					<div class="form-group">
						<?php $class="form-control";
						$id="tarrif";
						echo form_label('Tariff','triptariflabel'); 
						echo $this->form_functions->populate_dropdown('tariff',$tariffs='',$tariff='',$class,$id,$msg="Tariffs");?>
						<span class="tariff-error text-red"></span>
					</div>
				</div>
				<div class="div-with-50-percent-width-with-margin-10">
					<div class="form-group hide-me">
						<?php echo form_label('Releasing Place','releasingplace'); ?>
						<?php echo form_input(array('name'=>'releasingplace','class'=>'form-control releasingplace','placeholder'=>'Enter Releasing Place')); 
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Parking Fee','parking'); ?>
						<?php echo form_input(array('name'=>'parkingfee','class'=>'form-control parkingfee','placeholder'=>'Enter Parking Fee')); ?>
					
					</div>
					<div class="form-group">
						<?php echo form_label('Toll Fee','tollfee'); ?>
						<?php echo form_input(array('name'=>'tollfee','class'=>'form-control tollfee','placeholder'=>'Enter Toll Fee')); ?>
					
					</div>
					<div class="form-group">
						<?php echo form_label('State Tax','statetax'); ?>
						<?php echo form_input(array('name'=>'statetax','class'=>'form-control statetax','placeholder'=>'Enter State Tax')); 
						?>
					</div>
			
			
					<div class="form-group">
						<?php echo form_label('Night Halt','nighthalt'); ?>
						<?php echo form_input(array('name'=>'nighthalt','class'=>'form-control nighthalt','placeholder'=>'Enter Night Halt')); 
						?>
					</div>
					<div class="form-group">
						<?php echo form_label('Extra Fuel Charge','extrafuel'); ?>
						<?php echo form_input(array('name'=>'extrafuel','class'=>'form-control extrafuel','placeholder'=>'Enter Extra Fuel Charge')); ?>
					
					</div>
					<div class="form-group">
						<?php echo form_label('Driver Bata','driverbatalabel'); ?>
						<?php echo form_input(array('name'=>'driverbata','class'=>'form-control driverbata','placeholder'=>'Enter Driver Bata')); ?>
					
					</div>
			   		<div class="box-footer">
					<?php echo form_submit("trip-voucher-save","SAVE","class='btn btn-success trip-voucher-save'").nbs(5);  ?><button class='btn btn-danger modal-close' type='button'>CLOSE</button>  
					</div>
				</div>
			</div>
			</fieldset>
		</div><!-- body -->

		</div>
	</div>
    <!-- end loading -->
</div>	
</div>

