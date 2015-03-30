<?php    

 if($this->mysession->get('post')!=null){
$amount=$data['amount'];
$payment_date=$data['payment_date'];
$payment_type=$data['periods'];
}

if($this->session->userdata('dbSuccess') != '') { ?>
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

<div class="page-outer">    
	<fieldset class="body-border">
		<legend class="body-head">Driver Payments</legend>
		<div class="box-body table-responsive no-padding">
			
			<form action="<?php echo base_url(); ?>front-desk/driver-payments/<?php echo $driver_id;  ?>" method="get">
			<table class="table list-trip-table no-border">
				<tbody>
					<tr>

						<!--<td><?php echo form_input(array('name'=>'vehicle_number','class'=>'customer form-control' ,'placeholder'=>'KL-7-AB-1234','value'=>"",'id'=>'c_name')); ?></td>-->
					    <td width=200px>
							<select name="periods" class="customer form-control" width="300px">
							<option value="-1" disabled="disabled" selected="selected"  >--Select--</option>
							<option value="1">January</option>
							<option value="2">February</option>
							<option value="3">March</option>
							<option value="4">April</option>
							<option value="5">May</option>
							<option value="6">June</option>
							<option value="7">July</option>
							<option value="8">August</option>
							<option value="9">September</option>
							<option value="10">October</option>
							<option value="11">November</option>
							<option value="12">December</option>
							</select>
						</td>
					  <!--  <td><?php  echo form_input(array('name'=>'trip_drop_date','class'=>'dropdatepicker initialize-date-picker form-control' ,'placeholder'=>'To Date','value'=>$trip_drop_date)); ?></td>
						 
						 <td><?php $class="form-control";
							  $id='drivers';
						echo $this->form_functions->populate_dropdown('drivers',$drivers,$driver_id,$class,$id,$msg="Select Driver");?></td>
						<td><?php $class="form-control";
							  $id='trip-status';
						echo $this->form_functions->populate_dropdown('trip_status_id',$trip_statuses,$trip_status_id,$class,$id,$msg="Select Trip Status");?></td>-->
					    <td><?php echo form_submit("trip_search","Search","class='btn btn-primary'");
echo form_close();?></td>
					
					
						
					</tr>
				</tbody>
			</table>
		</div>
	
	<div class="msg"> <?php 
			if (isset($result)){ echo $result;} else { $tot_dr=0;$tot_cr=0;?></div>
		
		<div class="box-body table-responsive no-padding trips-table">
			<table class="table table-hover table-bordered">
				<tbody>
					<tr>	
						
					    <th style="width:2%">Sl no: </th>
					    <th style="width:19%">Type</th>
						<!--<th style="width:15%">Customer</th>-->
					   
					    <th style="width:15%">Period</th>
					    <th style="width:15%">Date</th>
						<th  style="width:12%">Amount (Dr)</th>
						<th  style="width:12%">Tax</th>
					    <th  style="width:12%">Amount (Cr)</th>
					   	<th  style="width:12%">Action</th>
										
						
					</tr>
					<?php
					
					$trip_sl_no=1;
					for($trip_index=0;$trip_index<count($trips);$trip_index++){
						
						$pickdate=$trips[$trip_index]['Period'];
						//$dropdate=$trips[$trip_index]['drop_date'];

						$date1 = date_create($pickdate);
						//$date2 = date_create($dropdate);
						
						
					?>
					<tr>
						<td><?php echo $trip_sl_no;?></td>
						<td><?php echo $trips[$trip_index]['voucher_number'];?></td>
						<?php $int=$trips[$trip_index]['Period'];?>
					   	
					   	<td><?php echo date('F', strtotime("2012-$int-01"));?></td>
					   	<td><?php echo $trips[$trip_index]['date'];?></td>
						<?php $amount_payable=$trips[$trip_index]['Debitamount']*COMMISION_PERCENTAGE/100; ?>
						<?php $amount_dr= $amount_payable/1.1236;?>
					   	<td><?php $tot_dr=$tot_dr+$amount_payable; echo floor(($amount_payable)*100)/100; ?></td>
						<td><?php echo  $tax=floor(($amount_payable-$amount_dr)*100) / 100; ?></td>
					   	<td><?php echo $tot_cr = $tot_cr+$trips[$trip_index]['Creditamount'];?></td>
					   	<td><?php echo "<a href=".base_url().'driver_invoice/'.$trips[$trip_index]['Driver_id']."/".$trips[$trip_index]['Period']."/".$trips[$trip_index]['Voucher_type_id']." class='fa fa-print for print' target='_blank' title='Print'></a>".nbs(5); ?><?php echo "<a href=".base_url().'front-desk/driver-payments/'.$trips[$trip_index]['Driver_id']."/".$trips[$trip_index]['payment_id']." class='fa fa-edit'  title='Edit'></a>".nbs(5); ?></td>
					   
					  
					</tr>

					<?php 
						$trip_sl_no++;
						}
					?>
					<tr>
						<td></td>
						<td><b>Closing</b></td>
						<td></td>
						<td></td>
						
						<td>
						<?php $value=0;
						
						echo "<b>".$tot_dr."</b>";
						?>
						</td>
						<td>
						</td>
						
						<td>
						<?php 
						
						echo  "<b>".$tot_cr."</b>";
						?>	
						</td>
						
						
						
					</tr>
					<!-- -->
					<tr>
						<td>
							
						</td>
						<td>
							<b>Balance Outstanding</b>
						</td>
						<td>
							
						</td>
						
						<td>
						</td>
							
						<td>
						<?php 
							$total=$tot_dr-$tot_cr;
							if($total > 0){
								echo  "<b>".$total."</b>";
							}else{
								echo "<b>"."0"."</b>";
							}
							
						?>
						</td>
						<td>
						</td>
						
						<td>
							<?php
							if($total < 0){
								echo "<b>".$total."</b>";
								
							}else{
								
								echo "<b>"."0"."</b>";
							}
							?>
						</td>
						<td>
						</td>
						
						
					</tr>
					<!-- -->
				</tbody>
			</table><?php //echo $page_links;?>
		</div>
		<?php } ?>
	</fieldset>

	<!-- Receipt Entry -->

	<fieldset class="body-border">
		<legend class="body-head">Driver Receipt</legend>
		
	
	<div class="msg"> <?php 
			if (isset($result)){ echo $result;} else {?></div>


		
		<div class="box-body table-responsive no-padding trips-table">
			<table class="table table-hover table-bordered">
				<tbody>
					<tr>	
						
					    <th style="width:2%">Sl no: </th>
					    <th style="width:19%">Type</th>
						<!--<th style="width:15%">Customer</th>-->
					   
					   
					    <th style="width:15%">Date</th>
					    <th  style="width:12%">Amount</th>
				
					   
										
						
					</tr>
					<?php
					
					$trip_sl_no=1;
					for($trip_index=0;$trip_index<count($val);$trip_index++){
						
					
						
					
					?>
					<tr>
						<td><?php echo $trip_sl_no;?></td>
						<td><?php echo "RECEIPT";?></td>

					   	<td><?php echo $val[$trip_index]['Created_date'];?></td>
					   	<td><?php echo "<b>".$val[$trip_index]['Receipt']."</b>";?></td>
					
					   	
					   
					   
					  
					</tr>

					<?php 
						$trip_sl_no++;
						}
					?>
			
					<!-- -->
			
					<!-- -->
				</tbody>
			</table><?php //echo $page_links;?>
		</div>
		<?php } ?>
	</fieldset>

	<!-- Receipt Entry Ends-->


	<div class="width-30-percent-with-margin-left-20-Driver-View"><!-- Add Driver Payment-->
		<fieldset class="body-border">
			<legend class="body-head">Add Vouchers</legend>
				<div class="box-body table-responsive no-padding trips-table"><!-- Responsive Table-->
					
					<?php// echo $value; exit;?>
					<?php  echo form_open(base_url()."driver/DriverPayments/".$driver_id);?>
					<div class='hide-me'><?php echo form_input(array('name'=>'driver_id','class'=>'form-control','value'=>$driver_id)).form_input(array('name'=>'payment_id','class'=>'form-control','value'=>$payment_id));?></div>
				        <div class="form-group">
						<?php echo form_label('Enter Amount','usernamelabel'); ?>
				           <?php echo form_input(array('name'=>'amount','class'=>'form-control','placeholder'=>'Enter Amount','value'=>$amount)); ?>
					   
				        </div>
				        <!-- -->
				        <div class="form-group">
				        	<?php echo form_label('Payment Type','usernamelabel'); ?>

						<?php $class="form-control customer";
						if($payment_id!=gINVALID) { 
							$payment_types=array('1'=>'Invoice','2'=>'Payment','3'=>'Receipt');
						}else{
							$payment_types=array('2'=>'Payment','3'=>'Receipt');
						}
						echo $this->form_functions->populate_dropdown('payment_type',$payment_types,$payment_type,$class,'',$msg="Select payment type");?>
				        </div>
				        <!-- -->
				        <div class="form-group">
				        	<?php echo form_label('Select Date','usernamelabel'); ?>
				        	<?php  echo form_input(array('name'=>'payment_date','class'=>'dropdatepicker initialize-date-picker form-control' ,'placeholder'=>'Date','value'=>$payment_date)); ?>
				        </div>
				
				        <?php if($payment_id==gINVALID){ $class="Add Payment"; }else{ $class="UPDATE"; } echo form_submit("payment-submit",$class,"class='btn btn-primary'"); ?>  
				</div><!-- Responsive Table-->
			</legend>
		</fieldset>	
	</div>	<!-- Add Driver Payment-->	
</div>


</div>	
</div>

