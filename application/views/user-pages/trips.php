
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
if(!isset($trip_drop_date)){
$trip_drop_date='';
}
if(!isset($customer_id)){
$customer_id='';
}

if(!isset($driver_id)){
$driver_id='';
}
if(!isset($vehiclenumber)){
$vehiclenumber='';
}
if(!isset($trip_status_id)){
$trip_status_id='';
}

if($trip_sl_no==''){
$trip_sl_no=1;
}
?>

<div class="trips">

<div class="page-outer">    
	<fieldset class="body-border">
		<legend class="body-head">Trips</legend>
		<div class="box-body table-responsive no-padding">
			<form action="<?php echo base_url(); ?>front-desk/trips" method="get">
			<table class="table list-trip-table no-border">
				<tbody>
					<tr>

						<td><?php echo form_input(array('name'=>'vehicle_number','class'=>'customer form-control' ,'placeholder'=>'KL-7-AB-1234','value'=>$vehiclenumber)); ?></td>
					    <td><?php echo form_input(array('name'=>'trip_pick_date','class'=>'pickupdatepicker initialize-date-picker form-control' ,'placeholder'=>'From Date','value'=>$trip_pick_date)); ?></td>
					    <td><?php  echo form_input(array('name'=>'trip_drop_date','class'=>'dropdatepicker initialize-date-picker form-control' ,'placeholder'=>'To Date','value'=>$trip_drop_date)); ?></td>
						 
						 <td><?php $class="form-control";
							  $id='drivers';
						echo $this->form_functions->populate_dropdown('drivers',$drivers,$driver_id,$class,$id,$msg="Select Driver");?>
						</td>

						<td><?php $class="form-control";
							  $id='customers';
						echo $this->form_functions->populate_dropdown('customers',$customers,$customer_id,$class,$id,$msg="Select Customer");?>
						</td>

						<td><?php $class="form-control";
							  $id='trip-status';
						echo $this->form_functions->populate_dropdown('trip_status_id',$trip_statuses,$trip_status_id,$class,$id,$msg="Select Trip Status");?></td>
					    <td><?php echo form_submit("trip_search","Search","class='btn btn-primary'");
echo form_close();?></td>
					<td><?php echo form_button('print-trip','Print',"class='btn btn-primary print-trip'"); ?></td>
						
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
					    <th style="width:9%">Trip id</th>
						<!--<th style="width:15%">Customer</th>-->
					   
					    <th style="width:25%">Pickup</th>
					    
					    <th  style="width:20%">Source</th>
					    <th  style="width:20%">Destination</th>
					    <th  style="width:33%">Driver</th>
						<th style="width:19%">Customer Name</th>
						<th style="width:11%">Phone Number</th>						
						 <th style="width:11%">Status</th>
					</tr>
					<?php
					
					
					for($trip_index=0;$trip_index<count($trips);$trip_index++){
						
						$pickdate=$trips[$trip_index]['pickup_date'];
						//$dropdate=$trips[$trip_index]['drop_date'];

						$date1 = date_create($pickdate);
						//$date2 = date_create($dropdate);
						
						
					?>
					<tr>
						<td><?php echo ++$trip_sl_no;?></td>
						<td><?php echo $trips[$trip_index]['trip_id'];?></td>
					   	<td><?php echo $trips[$trip_index]['pickup_date'].' - '.$trips[$trip_index]['pickuptime'];?></td>
					    <td><?php echo $trips[$trip_index]['trip_from'];?></td>
					   	<td><?php echo $trips[$trip_index]['trip_to'];?></td>
					   	<td><?php echo $trips[$trip_index]['drivername'].' - '.$trips[$trip_index]['vehiclenumber'];?></td>
					   	<td><?php echo $trips[$trip_index]['customer_name'];?></td>
					   	<td><?php echo $trips[$trip_index]['mob'];?></td>
					   	<td><?php echo $trips[$trip_index]['tripstatus'];?></td>
					</tr>
					<?php 
						
						}
					?>
				</tbody>
			</table><?php echo $page_links;?>
		</div>
		<?php } ?>
	</fieldset>

</div>	
</div>

