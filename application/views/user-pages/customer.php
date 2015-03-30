<?php 


	$customer_id		=	'-1';
	$name				=	'';	
	$customer_status_id		= 	'';
	
	
	
	$mobile				= 	'';
	$address			= 	'';

	if($this->mysession->get('post')!=NULL || $values!=false){
	
	if($this->mysession->get('post')!=NULL){
	$data						=	$this->mysession->get('post');//print_r($data);
	if(isset($data['customer_id'])){
	$customer_id = $data['customer_id'];
	}
	
	}else if($values!=false){
	$data =$values;
	$customer_id = $data['id'];
	
	}
	$name				=	$data['name'];	
	
	$customer_status_id		= 	$data['customer_status_id'];
	if($customer_status_id==gINVALID){$customer_status_id		='';}
	
	
	$mobile				= 	$data['mobile'];
	$address			= 	$data['address'];
	}
	$this->mysession->delete('post');
?>
<div class="page-outer">
	   <fieldset class="body-border">
		<legend class="body-head">Customers</legend>

        <div class="profile-body width-80-percent-and-margin-auto">
			<!--<fieldset class="body-border">
   			 <legend class="body-head">Personal Details</legend>-->
		
			<div class="div-with-50-percent-width-with-margin-10">
				<?php echo form_open(base_url().'customers/AddUpdate');?>
				
				<div class="form-group">
					<?php echo form_label('Name','namelabel'); ?>
				    <?php echo form_input(array('name'=>'name','class'=>'form-control','placeholder'=>'Enter Name','value'=>$name)); ?>
					<?php echo $this->form_functions->form_error_session('name', '<p class="text-red">', '</p>'); ?>
				</div>
			<!--
				<div class="form-group">
					<?php echo form_label('Email','emaillabel'); ?>
				    <?php echo form_input(array('name'=>'email','class'=>'form-control','placeholder'=>'Enter email','value'=>$email)); 
					if($customer_id!='' && $customer_id>gINVALID) {  ?><div class="hide-me"> <?php echo form_input(array('name'=>'h_email','class'=>'form-control','value'=>$email)); ?></div><?php } ?>
					<?php echo $this->form_functions->form_error_session('email', '<p class="text-red">', '</p>'); ?>
				</div>
				-->
				<div class="form-group">
					<?php echo form_label('Phone','phonelabel'); ?>
				    <?php echo form_input(array('name'=>'mobile','class'=>'form-control','placeholder'=>'Enter Phone','value'=>$mobile)); 
					if($customer_id!='' && $customer_id>gINVALID) {  ?><div class="hide-me"> <?php echo form_input(array('name'=>'h_phone','value'=>$mobile)); ?></div><?php } ?>
					<?php echo $this->form_functions->form_error_session('mobile', '<p class="text-red">', '</p>'); ?>
				</div>
				<div class="form-group">
					<?php echo form_label('Customer Statuses','cgrouplabel'); ?>
				   <?php echo $this->form_functions->populate_dropdown('customer_status_id',$customer_statuses,$customer_status_id,$class ='form-control',$id='',$msg="Select status"); ?>
					
				</div>
			
			</div>
			<div class="div-with-50-percent-width-with-margin-10">
				
				<div class="form-group">
					<?php echo form_label('Address','addresslabel'); ?>
				    <?php echo form_textarea(array('name'=>'address','class'=>'form-control','placeholder'=>'Enter Address','value'=>$address,'rows'=>'9')); ?>
					<?php echo form_error('address', '<p class="text-red">', '</p>'); ?>
				</div>
		   		<div class="box-footer">
				<?php if($customer_id!='' && $customer_id>gINVALID){ $save_update_button='UPDATE';$class_save_update_button="class='btn btn-primary'"; }else{ $save_update_button='SAVE';$class_save_update_button="class='btn btn-success'"; }?>
				<?php echo form_submit("customer-add-update",$save_update_button,$class_save_update_button).nbs(2).form_reset("customer_reset","RESET","class='btn btn-danger'"); ?> 
				<div class="hide-me"> <?php echo form_input(array('name'=>'customer_id','class'=>'form-control','value'=>$customer_id)); 
				?></div>
			 <?php echo form_close(); ?>
			</div>
			</div>
		 
			<!--</fieldset>-->
		</div>
       
          
    </div>
</div>

