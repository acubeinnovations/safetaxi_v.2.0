<?php 


?>
<div class="page-outer width-50-percent">
	   <fieldset class="body-border">
		<legend class="body-head">Send Notifications</legend>

        
			
			<?php echo form_open(base_url().'driver/sendNotification');?>
				<div class="form-group">
					<?php echo form_label('Driver','driverlabel'); ?>
				   <?php echo $this->form_functions->populate_dropdown('driver',$drivers,$driver,'form-control','',"Send Notification to all Drivers"); ?>
					
				</div>
				<div class="form-group">
					<?php echo form_label('Message','msglabel'); ?>
				    <?php echo form_textarea(array('name'=>'message','class'=>'form-control','placeholder'=>'Enter message','value'=>$message,'rows'=>'9')); ?>
					<?php echo $this->form_functions->form_error_session('message', '<p class="text-red">', '</p>'); ?>
				</div>
		   		<div class="box-footer">
				
				<?php echo form_submit("send-notification","SEND NOTIFICATION","class='btn btn-success'").nbs(2).form_reset("msg_reset","RESET","class='btn btn-danger'"); ?> 
				
			 <?php echo form_close(); ?>
				</div>	
			
		
       
       </fieldset> 
   
</div>

