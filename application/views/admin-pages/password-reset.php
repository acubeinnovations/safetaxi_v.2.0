 <div class="change-password-body">
		<fieldset class="body-border">
	   		<legend class="body-head">User Reset Password</legend>
		<?php echo form_open(base_url().'admin/front-desk/'.$user.'/password-reset');?>
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
		<?php echo form_submit("user-password-reset","Change","class='btn btn-primary'");  ?>  
        </div>
	 <?php echo form_close(); ?>
	</fieldset>
	</div><!-- body -->
