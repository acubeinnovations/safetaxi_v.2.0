
	 <div class="change-password-body">
		<fieldset class="body-border">
	   		<legend class="body-head">Change Password</legend>
			<?php echo form_open(base_url().'admin/changepassword');?>
		    <div class="form-group">
			   <?php echo form_label('Current Password','old_passwordlabel'); ?>
		       <?php echo form_password(array('name'=>'old_password','class'=>'form-control','id'=>'old_password','placeholder'=>'Enter Current Password','value'=>$old_password)); ?>
				<?php echo form_error('old_password', '<p class="text-red">', '</p>'); ?>
				<?php if($this->session->userdata('dbError') != ''){
					echo '<p class="text-red">'.$this->session->userdata('dbError').'</p>';
					$this->session->set_userdata(array('dbError'=>''));
				} ?>
		    </div>
		    <div class="form-group">
				<?php echo form_label('New Password','passwordlabel'); ?>
		        <?php echo form_password(array('name'=>'password','class'=>'form-control','placeholder'=>'Enter password','value'=>$password)); ?>
				<?php echo form_error('password', '<p class="text-red">', '</p>'); ?>
		    </div>
		    <div class="form-group">
				<?php echo form_label('Confirm Password','cpasswordlabel'); ?>
		        <?php echo form_password(array('name'=>'cpassword','class'=>'form-control','placeholder'=>'Confirm Password','value'=>$cpassword)); ?>
				<?php echo form_error('cpassword', '<p class="text-red">', '</p>'); ?>
		    </div>
		
	   		<div class="box-footer">
			<?php echo form_submit("admin-password-update","Change","class='btn btn-primary'");  ?>  
		    </div>
		 <?php echo form_close(); ?>
		</fieldset>
	</div><!-- body -->

