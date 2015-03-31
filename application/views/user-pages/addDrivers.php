 <?php
 $driver_id=gINVALID;
	$name='';
	$place_of_birth='';
	$dob='';
	$blood_group='';
	$marital_status_id='';
	$children='';
	$present_address='';
	$address='';
	$district='';
	$state='';
	$pin_code='';
	$phone='';
	$mobile='';
	$email='';
	$date_of_joining='';
	$badge='';
	$license_number='';
	$license_renewal_date='';
	$badge_renewal_date='';
	$mother_tongue='';
	$pan_number='';
	$bank_account_number='';
	$name_on_bank_pass_book='';
	$bank_name='';
	$branch='';
	$bank_account_type_id='';
	$ifsc_code='';
	$id_proof_type_id='';
	$id_proof_document_number='';
	$name_on_id_proof='';
	$vehicle_registration_number='';
	$device_imei='';
	$device_sim_number='';
	//$app_key='';
	$base_location='';
	//$status_description='';
	

 if($this->mysession->get('post')!=null){
 //echo $result[''];
 $data=$this->mysession->get('post');
	$driver_id=$this->mysession->get('driver_id');
	$name=$data['name'];
	$dob=$data['dob'];
	$blood_group=$data['blood_group'];
	$permanent_address=$data['address'];
	$district=$data['district'];
	$state=$data['state'];
	$pin_code=$data['pin_code'];
	$mobile=$data['mobile'];
	$email=$data['email'];
	$vehicle_registration_number=$data['vehicle_registration_number'];
	$device_imei=$data['device_imei'];
	$device_sim_number=$data['device_sim_number'];
	$app_key=$data['app_key'];
	$base_location=$data['base_location'];
	//$status_description=$data['status_description'];

$this->mysession->delete('post');
}
 else if(isset($result)&&$result!=null){ 
    $driver_id=$result['id'];
	$name=$result['name'];
	$dob=$result['dob'];
	$blood_group=$result['blood_group'];
	$address=$result['address'];
	$district=$result['district'];
	$state=$result['state'];
	$pin_code=$result['pin_code'];
	$mobile=$result['mobile'];
	$email=$result['email'];
	$vehicle_registration_number=$result['vehicle_registration_number'];
	$device_imei=$result['device_imei'];
	$device_sim_number=$result['device_sim_number'];
	$app_key=$result['app_key'];
	$base_location=$result['base_location'];
	//$status_description=$result['status_description'];

} 
?>
<?php if($this->session->userdata('dbSuccess') != '') { ?>
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
		<div class="page-outer">
	   <fieldset class="body-border">
		<legend class="body-head">Manage Drivers</legend>
	<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li><a href="#tab_1" data-toggle="tab">Profile</a></li>

    </ul>
    <div class="tab-content">
        
        <div class="tab-pane active" id="tab_1">

       
			 <div class="width-30-percent-with-margin-left-20-Driver-View">

<fieldset class="body-border-Driver-View border-style-Driver-view" >
<legend class="body-head">Personal Details</legend>

		<?php  echo form_open(base_url()."driver/driver_manage");?>
        <div class="form-group">
		<?php echo form_label('Enter Name','usernamelabel'); ?>
           <?php echo form_input(array('name'=>'driver_name','class'=>'form-control','id'=>'name','placeholder'=>'Enter Name','value'=>$name)); ?>
	   <?php echo $this->form_functions->form_error_session('name', '<p class="text-red">', '</p>'); ?>
        </div>

	<div class="form-group">
	<?php echo form_label('Date of Birth','usernamelabel'); ?>
           <?php echo form_input(array('name'=>'dob','class'=>'fromdatepicker form-control' ,'placeholder'=>'Date of Birth','value'=>$dob));?>
	   <?php echo $this->form_functions->form_error_session('dob', '<p class="text-red">', '</p>'); ?>
        </div>
        <div class="form-group">
		<?php echo form_label('Blood Group','usernamelabel'); ?>
           <?php 
		$class="form-control";
		$msg="Blood Group ";
		$name="blood_group";
		$id='blood_group';
		$group=array('A+','A-','B+','B-','O+','O-','AB+','AB-');
	echo $this->form_functions->populate_dropdown($name,$group,$blood_group,$class,$id,$msg);
		   ?>
	   <?php echo $this->form_functions->form_error_session('blood_group', '<p class="text-red">', '</p>'); ?>
	   <p class="text-red"><?php
 if($this->session->userdata('blood group') != ''){
	echo $this->session->userdata('blood group');
	$this->session->set_userdata(array('blood group'=>''));
 }
	?></p>
        </div>


	
	<div class="form-group">
	<?php echo form_label('Permanent Address','usernamelabel'); ?>
           <?php echo form_textarea(array('name'=>'address','class'=>'form-control','id'=>'address','placeholder'=>'Permanent Address','value'=>$address,'rows'=>5)); ?>
	   <?php echo $this->form_functions->form_error_session('address', '<p class="text-red">', '</p>'); ?>
        </div>
	<div class="form-group">
	<?php echo form_label('District','usernamelabel'); ?>
           <?php echo form_input(array('name'=>'district','class'=>'form-control','id'=>'district','placeholder'=>'District','value'=>$district)); ?>
	   <?php echo $this->form_functions->form_error_session('district', '<p class="text-red">', '</p>'); ?>
        </div>
	<div class="form-group">
	<?php echo form_label('State','usernamelabel'); ?>
           <?php echo form_input(array('name'=>'state','class'=>'form-control','id'=>'state','placeholder'=>'State','value'=>$state)); ?>
	   <?php echo $this->form_functions->form_error_session('state', '<p class="text-red">', '</p>'); ?>
        </div>
	<div class="form-group">
	<?php echo form_label('Pin Code','usernamelabel'); ?>
           <?php echo form_input(array('name'=>'pin_code','class'=>'form-control','id'=>'pin_code','placeholder'=>'Pin Code','value'=>$pin_code)); ?>
	   <?php echo $this->form_functions->form_error_session('pin_code', '<p class="text-red">', '</p>'); ?>
        </div>	

	<div class="form-group">
	<?php echo form_label('Mobile','usernamelabel'); ?>
           <?php echo form_input(array('name'=>'mobile','class'=>'form-control','id'=>'drivermobile','placeholder'=>'Mobile','value'=>$mobile)); ?>
	   <?php echo $this->form_functions->form_error_session('mobile', '<p class="text-red">', '</p>'); ?>
       <div class="hide-me" > <?php echo form_input(array('name'=>"hmob",'value'=>$mobile));?></div>
		</div>
	<div class="form-group">
	<?php echo form_label('E-mail ID','usernamelabel'); ?>
           <?php echo form_input(array('name'=>'email','class'=>'form-control','id'=>'driveremail','placeholder'=>'E-mail ID','value'=>$email)); ?>
	   <?php echo $this->form_functions->form_error_session('email', '<p class="text-red">', '</p>'); ?>
	 <div class="hide-me" >  <?php echo form_input(array('name'=>"hmail",'value'=>$email));?></div>
        </div>

		</fieldset> </div>
		
	<div class="width-30-percent-with-margin-left-20-Driver-View">
<fieldset class="body-border-Driver-View border-style-Driver-view" >
<legend class="body-head">Other Details</legend>

	<div class="form-group">
	<?php echo form_label('Vehicle Registration Number','usernamelabel'); ?>
           <?php echo form_input(array('name'=>'vehicle_registration_number','class'=>'form-control','id'=>'vehicle_registration_number','placeholder'=>'Vehicle Registration Number','value'=>$vehicle_registration_number)); ?>
	<?php echo $this->form_functions->form_error_session('vehicle_registration_number', '<p class="text-red">', '</p>'); ?>
    </div>

    <div class="form-group">
	<?php echo form_label('Device IMEI','usernamelabel'); ?>
           <?php echo form_input(array('name'=>'device_imei','class'=>'form-control','id'=>'device_imei','placeholder'=>'Device IMEI','value'=>$device_imei)); ?>
	<?php echo $this->form_functions->form_error_session('device_imei', '<p class="text-red">', '</p>'); ?>
    </div>

    <div class="form-group">
	<?php echo form_label('Device Sim Number','usernamelabel'); ?>
           <?php echo form_input(array('name'=>'device_sim_number','class'=>'form-control','id'=>'device_sim_number','placeholder'=>'Device Sim Number','value'=>$device_sim_number)); ?>
	<?php echo $this->form_functions->form_error_session('device_sim_number', '<p class="text-red">', '</p>'); ?>
    </div>

    <div class="form-group">
	<?php echo form_label('App Key','usernamelabel'); ?>
           <?php echo form_input(array('name'=>'app_key','class'=>'form-control','id'=>'app_key','placeholder'=>'App Key','value'=>$app_key,'readonly'=>true)); ?>
	
    </div>

    <div class="form-group">
	<?php echo form_label('Base Location','usernamelabel'); ?>
           <?php echo form_input(array('name'=>'base_location','class'=>'form-control','id'=>'base_location','placeholder'=>'Base Location','value'=>$base_location)); ?>
	<?php echo $this->form_functions->form_error_session('base_location', '<p class="text-red">', '</p>'); ?>
    </div>

    <!--<div class="form-group">
	<?php //echo form_label('Status Description','usernamelabel'); ?>
           <?php //echo form_input(array('name'=>'status_description','class'=>'form-control','id'=>'status_description','placeholder'=>'Status Description','value'=>$status_description)); ?>
	<?php //echo $this->form_functions->form_error_session('status_description', '<p class="text-red">', '</p>'); ?>
    </div>-->


	





	
		<div class='hide-me'><?php  
		echo form_input(array('name'=>'hidden_id','class'=>'form-control','value'=>$driver_id));?></div>
   		<div class="box-footer">
		
		<?php echo br();
		 if($driver_id==gINVALID||$driver_id==''){
			$btn_name='Save';
		 }else {
			$btn_name='Update';
			}
		echo form_submit("driver-submit",$btn_name,"class='btn btn-primary'"); ?>  
        </div>
	 <?php echo form_close(); ?>
	</fieldset>


</div>	
        </div>
		<div class="tab-pane" id="tab_2">
           <div class="page-outer">
	   <fieldset class="body-border">
		<legend class="body-head">Trip</legend><div class="form-group">
	<div class="box-body table-responsive no-padding">
			<table class="table table-hover table-bordered">
				<tbody>
					<tr>
						<th>SlNo</th>
					    <th>Date</th>
					    <th>Route</th>
						<th>Kilometers</th>
						<th>No Of Days</th>
						<!--<th>Releasing Place</th>-->
						<th>Parking</th>
						<th>Toll</th>
						<th>State Tax</th>
						<th>Night Halt</th>
						<th>Fuel extra</th>
						<th>Trip Amount</th>
					    
					</tr>
					<?php	
						$full_tot_km=$tot_parking=$tot_toll=$tot_state_tax=$tot_night_halt=$tot_fuel_extra=$tot_trip_amount=0;
					if(isset($trips) && $trips!=false){
						for($trip_index=0;$trip_index<count($trips);$trip_index++){
						$tot_km=$trips[$trip_index]['end_km_reading']-$trips[$trip_index]['start_km_reading'];
						$full_tot_km=$full_tot_km+$tot_km;
						$tot_parking=$tot_parking+$trips[$trip_index]['parking_fees'];
						$tot_toll=$tot_toll+$trips[$trip_index]['toll_fees'];
						$tot_state_tax=$tot_state_tax+$trips[$trip_index]['state_tax'];
						$tot_night_halt=$tot_night_halt+$trips[$trip_index]['night_halt_charges'];
						$tot_fuel_extra=$tot_fuel_extra+$trips[$trip_index]['fuel_extra_charges'];
						$tot_trip_amount=$tot_trip_amount+$trips[$trip_index]['total_trip_amount'];
						
						
						$date1 = date_create($trips[$trip_index]['pick_up_date'].' '.$trips[$trip_index]['pick_up_time']);
						$date2 = date_create($trips[$trip_index]['drop_date'].' '.$trips[$trip_index]['drop_time']);
						
						$diff= date_diff($date1, $date2);
						$no_of_days=$diff->d;
						if($no_of_days==0){
							$no_of_days='1 Day';
							$day=1;
						}else{
							$no_of_days.=' Days';
							$day=$diff->d;
						}

						?>
						<tr>
							<td><?php echo $trip_index+1; ?></td>
							<td><?php echo $trips[$trip_index]['pick_up_date']; ?></td>
							<td><?php echo $trips[$trip_index]['pick_up_city'].' to '.$trips[$trip_index]['drop_city']; ?></td>
							<td><?php echo $tot_km; ?></td>
							<td><?php echo $no_of_days; ?></td>
							<!--<td><?php //echo $trips[$trip_index]['releasing_place'];?></td>-->
							<td><?php echo number_format($trips[$trip_index]['parking_fees'],2);?></td>
							<td><?php echo number_format($trips[$trip_index]['toll_fees'],2); ?></td>
							<td><?php echo number_format($trips[$trip_index]['state_tax'],2); ?></td>
							<td><?php echo number_format($trips[$trip_index]['night_halt_charges'],2); ?></td>
							<td><?php echo number_format($trips[$trip_index]['fuel_extra_charges'],2); ?></td>
							<td><?php echo number_format($trips[$trip_index]['total_trip_amount'],2); ?></td>
						
						</tr>
						<?php } 
						}					
					?>
					<tr>
					<td>Total</td>
					<td></td>
					<td></td>
					<td><?php echo $full_tot_km; ?></td>
					<td></td>
					<td><?php echo number_format($tot_parking,2); ?></td>
					<td><?php echo number_format($tot_toll,2); ?></td>
					<td><?php echo number_format($tot_state_tax,2); ?></td>
					<td><?php echo number_format($tot_night_halt,2); ?></td>
					<td><?php echo number_format($tot_fuel_extra,2); ?></td>
					<td><?php echo number_format($tot_trip_amount,2); ?></td>
					</tr>
					<?php //endforeach;
					//}
					?>
				</tbody>
			</table><?php //echo $page_links;?>
		</div>
</div>
</fieldset>
</div>
        </div>
        <div class="tab-pane" id="tab_3">
         

<div class="page-outer">
		<iframe src="<?php echo base_url().'account/front_desk/SupplierPayment/DR'.$driver_id.'/true';?>" height="600px" width="100%">
		<p>Browser not Support</p>
		</iframe>

</div>
        </div>
		<div class="tab-pane" id="tab_4">
        		<iframe src="<?php echo base_url().'account/front_desk/DriverPaymentInquiry/DR'.$driver_id.'/true';?>" height="600px" width="100%">
		<p>Browser not Support</p>
		</iframe>
        	</div>
    </div>
</div>	


</fieldset>
</div>
