<div class="new-org-body">
	<fieldset class="body-border">
   			 <legend class="body-head">Profile</legend>	
		<?php echo form_open(base_url().'organization/admin/profile');?>
        <div class="form-group">
		   <?php echo form_label('Organization Name');?>
           <?php echo form_input(array('name'=>'name','class'=>'form-control','id'=>'name','placeholder'=>'Enter Organization Name','value'=>$name)); ?>
			<?php if(isset($org_id) && isset($user_id)) {  
			echo form_hidden('hname',$hname); 
			
			} ?>
	   <?php echo form_error('name', '<p class="text-red">', '</p>'); ?>
        </div>
	<div class="form-group">
		   <?php echo form_label('First Name');?>
           <?php echo form_input(array('name'=>'fname','class'=>'form-control','id'=>'fname','placeholder'=>'Enter First Name','value'=>$fname)); ?>
	   <?php echo form_error('fname', '<p class="text-red">', '</p>'); ?>
        </div>
	<div class="form-group">
		   <?php echo form_label('Last Name');?>
           <?php echo form_input(array('name'=>'lname','class'=>'form-control','id'=>'lname','placeholder'=>'Enter Last Name','value'=>$lname)); ?>
	  	  <?php echo form_error('lname', '<p class="text-red">', '</p>'); ?>
        </div>
        <div class="form-group">
			<?php echo form_label('Address','addresslabel'); ?>
            <?php echo form_textarea(array('name'=>'addr','class'=>'form-control','placeholder'=>'Enter Address','rows' => '4','value'=>$addr)); ?>
	    <?php echo form_error('addr', '<p class="text-red">', '</p>'); ?>
        </div>
	<div class="form-group">
			<?php
			echo form_input(array('name'=>'uname','class'=>'form-control','id'=>'uname','placeholder'=>'Enter Username','value'=>$uname,'disabled'=>''));
		 ?>
			
        </div>
	<div class="form-group">
			<?php echo form_label('Email-ID'); ?>
            <?php echo form_input(array('name'=>'mail','class'=>'form-control','id'=>'mail','placeholder'=>'Enter E-mail ID','value'=>$mail)); ?>
	    <?php if(isset($org_id) && isset($user_id)) {  echo form_hidden('hmail',$hmail); } ?>
		<?php echo form_error('mail', '<p class="text-red">', '</p>'); ?>
        </div>
	<div class="form-group">
			<?php echo form_label('Phone Number'); ?>
            <?php echo form_input(array('name'=>'phn','class'=>'form-control','id'=>'phn','placeholder'=>'Enter Phone Number','value'=>$phn)); ?>
			<?php if(isset($org_id) && isset($user_id)) {  echo form_hidden('hphone',$hphone); } ?>
		<?php echo form_error('phn', '<p class="text-red">', '</p>'); ?>
        </div>
	
		<div class="form-group">
		<?php if(isset($org_id) && isset($user_id)) {  echo form_hidden('user_id',$user_id).form_hidden('org_id',$org_id); } ?>
		</div>
   		<div class="box-footer">
		<?php // echo validation_errors();
				 echo form_submit("org-profile-update","Update","class='btn btn-primary'");   ?>  
        </div>
	 <?php echo form_close(); ?>
	</fieldset>
</div><!-- body -->
