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
       <?php    } ?>
		<?php if(isset($id) && $id > 0){

		$url='admin/front-desk/'.$username;
		$page_cap='Update User';
		
		}else{

		$url='admin/front-desk/new';
		$page_cap='Add User';
 		}
		 ?>
		 <div class="profile-body">
			<fieldset class="body-border">
   			 <legend class="body-head"><?php echo $page_cap; ?></legend>
				<?php echo form_open(base_url().$url);?>
			<div class="div-with-50-percent-width-with-margin-10">
				<div class="form-group">
				   <?php echo form_label('Username','usernamelabel'); ?>
					<?php if(isset($id)){ 
				   echo form_input(array('name'=>'username','class'=>'form-control','id'=>'username','placeholder'=>'Enter Username','value'=>$username,'disabled'=>''));
					}else{
					echo form_input(array('name'=>'username','class'=>'form-control','id'=>'username','placeholder'=>'Enter Username','value'=>$username));
					} ?>			
					<?php echo form_error('username', '<p class="text-red">', '</p>'); ?>
				</div>
				<?php if(!isset($id)) { ?>
				<div class="form-group">
				   <?php echo form_label('Password','passwordlabel'); ?>
				   <?php echo form_password(array('name'=>'password','class'=>'form-control','id'=>'password','placeholder'=>'Enter Password','value'=>$password)); ?>			
					<?php echo form_error('password', '<p class="text-red">', '</p>'); ?>
				</div>
				
				<div class="form-group">
				   <?php echo form_label('Confirm Password','cpasswordlabel'); ?>
				   <?php echo form_password(array('name'=>'cpassword','class'=>'form-control','id'=>'cpassword','placeholder'=>'Enter Confirm password')); ?>			
					<?php echo form_error('cpassword', '<p class="text-red">', '</p>'); ?>
				</div>
				<?php }else{
				echo form_hidden('id',$id);
				echo form_hidden('husername',$username);
				} ?>
				<div class="form-group">
					<?php echo form_label('First Name','firstnamelabel'); ?>
				    <?php echo form_input(array('name'=>'firstname','class'=>'form-control','placeholder'=>'Enter First Name','value'=>$firstname)); ?>
					<?php echo form_error('firstname', '<p class="text-red">', '</p>'); ?>
				</div>
				<div class="form-group">
					<?php echo form_label('Last Name','lastnamelabel'); ?>
				    <?php echo form_input(array('name'=>'lastname','class'=>'form-control','placeholder'=>'Enter Last Name','value'=>$lastname)); ?>
					<?php echo form_error('lastname', '<p class="text-red">', '</p>'); ?>
				</div>
				<?php if(isset($id)) { ?>
				<div class="form-group">
				<?php 
				 $class="form-control";
				 $selected=$status;
					echo form_label('Status','statuslabel');
				 echo $this->form_functions->populate_dropdown('status',$user_status,$selected,$class);
				 ?>
				</div>
				<?php }  ?>
				
			
				</div>
				<div class="div-with-50-percent-width-with-margin-10">
				
				<div class="form-group">
					<?php echo form_label('Email','emaillabel'); ?>
				    <?php echo form_input(array('name'=>'email','class'=>'form-control','placeholder'=>'Enter email','value'=>$email)); 
					  echo form_hidden('hmail',$email); ?>
					<?php echo form_error('email', '<p class="text-red">', '</p>'); ?>
				</div>
				<div class="form-group">
					<?php echo form_label('Phone','phonelabel'); ?>
				    <?php echo form_input(array('name'=>'phone','class'=>'form-control','placeholder'=>'Enter Phone','value'=>$phone)); 
					 echo form_hidden('hphone',$phone);?>
					<?php echo form_error('phone', '<p class="text-red">', '</p>'); ?>
				</div>
				<div class="form-group">
					<?php echo form_label('Address','addresslabel');
					if(isset($id)){
					$row_address=2;
					}	else{
					$row_address=5;
					}			
				 echo form_textarea(array('name'=>'address','class'=>'form-control','placeholder'=>'Enter Address','value'=>$address, 'rows'  => $row_address,'cols' => '10')); ?>
					<?php echo form_error('address', '<p class="text-red">', '</p>'); ?>
				</div>
		   		<div class="box-footer">
				<?php if(!isset($id)){ 
				echo form_submit("user-profile-add","Save","class='btn btn-primary'"); 
				}else{
				echo form_submit("user-profile-update","Update","class='btn btn-primary'");
				}
				 ?>  
				</div>
				</div>
			 <?php echo form_close(); ?>
			</fieldset>
			<?php if(isset($id)){ ?>
			<fieldset class="body-border">
   			 <legend class="body-head">Permissions</legend>
			<?php echo form_open(base_url().'admin/addUserPermissions/'.$id);?>
			<div class="form-group check-all-check-box-container">
				<input type="checkbox" name="checkall" class="checkall"/><?php echo nbs(3); ?>Check All
			</div>
			<table class="table table-bordered">
			<tr>
                <th style="width: 10px">Sl No</th>
                <th>Pages</th>
                <th style="width: 50px">Permission</th>
            </tr>
			<?php  $i=1;
				foreach ($pages as $key =>$page ) { ?>
				<tr>
		            <td style="width: 10px"><?php echo $i; ?></td>
		            <td><?php echo $page;  ?></td>
		            <td><?php if(in_array($key,$page_ids)){ $checked="checked='checked'"; }else{ $checked=""; }  ?> <input type="checkbox" name="permissions[]" <?php echo $checked; ?> class="permission-check-box" value="<?php echo $key; ?>"/></td>
           		</tr>
			
			<?php $i++; } ?>
				
			</table>
			<div class="form-group">
			<div class="hide-me"><?php echo form_input(array('name'=>'username','value'=>$username)); ?></div>
			<?php echo form_submit("user-permission-add","Add Permisions","class='btn btn-primary'"); ?> 


			</div>
			 <?php echo form_close(); ?>
			</fieldset>
			<?php }
				 ?> 
		</div><!-- body -->
	
