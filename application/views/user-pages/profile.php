<?php 

if(isset($values)){
	$user_id=$this->session->userdata('id');
	$username	=	$values[0]->username;
	$Firstname	= 	$values[0]->first_name; 
	$Lasttname	= 	$values[0]->last_name; 
	$email		= 	$values[0]->email; 
	$phone		= 	$values[0]->phone;	
	$address	= 	$values[0]->address; 
	
}else if(isset($postvalues)){
 $user_id=$this->session->userdata('id');
	$username	=	$postvalues['username'];
	$Firstname	= 	$postvalues['first_name']; 
	$Lasttname	= 	$postvalues['last_name']; 
	$email		= 	$postvalues['email']; 
	$phone		= 	$postvalues['phone']; 
	$address	= 	$postvalues['address']; 
	$fa_account	= 	$postvalues['fa_account']; 
}else{
	$username=	'';
	$Firstname= ''; 
	$Lasttname= ''; 
	$email= 	''; 
	$phone= 	''; 
	$address= 	''; 
	$fa_account= 	'';
}
?>
	
		 <div class="profile-body width-80-percent-and-margin-auto">
			<fieldset class="body-border">
   			 <legend class="body-head">Profile</legend>
				<div class="div-with-50-percent-width-with-margin-10">
				<?php echo form_open(base_url().'front-desk/profile');?>
				<div class="form-group">
				   <?php echo form_label('Username','usernamelabel'); ?>
				   <?php echo form_input(array('name'=>'username','class'=>'form-control','id'=>'username','placeholder'=>'Enter Username','disabled'=>'','value'=>$username)).form_hidden('husername',$username); ?>			
					<?php echo form_error('username', '<p class="text-red">', '</p>'); ?>
				</div>
				<div class="form-group">
					<?php echo form_label('First Name','firstnamelabel'); ?>
				    <?php echo form_input(array('name'=>'firstname','class'=>'form-control','placeholder'=>'Enter First Name','value'=>$Firstname)); ?>
					<?php echo form_error('firstname', '<p class="text-red">', '</p>'); ?>
				</div>
				<div class="form-group">
					<?php echo form_label('Last Name','lastnamelabel'); ?>
				    <?php echo form_input(array('name'=>'lastname','class'=>'form-control','placeholder'=>'Enter Last Name','value'=>$Lasttname)); ?>
					<?php echo form_error('lastname', '<p class="text-red">', '</p>'); ?>
				</div>
				<div class="form-group">
					<?php echo form_label('Email','emaillabel'); ?>
				    <?php echo form_input(array('name'=>'email','class'=>'form-control','placeholder'=>'Enter email','value'=>$email)); 
					if( isset($user_id)) {  echo form_hidden('hmail',$email); } ?>
					<?php echo form_error('email', '<p class="text-red">', '</p>'); ?>
				</div>
			</div>
			<div class="div-with-50-percent-width-with-margin-10">
				<div class="form-group">
					<?php echo form_label('Phone','phonelabel');?>
				    <?php echo form_input(array('name'=>'phone','class'=>'form-control','placeholder'=>'Enter Phone','value'=>$phone)); 
					if (isset($user_id)) {  echo form_hidden('hphone',$phone); 
					 }?>
					<?php echo form_error('phone', '<p class="text-red">', '</p>'); ?>
				</div>
				<div class="form-group">
					<?php echo form_label('Address','addresslabel'); ?>
				    <?php echo form_textarea(array('name'=>'address','class'=>'form-control','placeholder'=>'Enter Address','value'=>$address)); ?>
					<?php echo form_error('address', '<p class="text-red">', '</p>'); ?>
				</div>
		   		<div class="box-footer">
				<?php echo form_submit("user-profile-update","Update","class='btn btn-primary'");  ?>  
				</div>
			 <?php echo form_close(); ?>
			</div>
			</fieldset>
		</div><!-- body -->
	
