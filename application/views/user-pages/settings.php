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
	  if($this->session->userdata('dbvalErr') != ''||$this->session->userdata('Err_num_name') != ''||$this->session->userdata('Err_num_desc') != ''||$this->session->userdata('Err_name') != ''||$this->session->userdata('Err_desc') != '') { ?>
	<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Alert!</b><br><?php
													echo $this->session->userdata('dbvalErr').br();
													echo $this->session->userdata('Err_num_name').br();
													echo $this->session->userdata('Err_num_desc').br();
													echo $this->session->userdata('Err_name').br();
													echo $this->session->userdata('Err_desc').br();
													 $this->session->set_userdata(array('dbvalErr'=>''));
													 $this->session->set_userdata(array('Err_num_name'=>''));
													 $this->session->set_userdata(array('Err_num_desc'=>''));
													 $this->session->set_userdata(array('Err_name'=>''));
													 $this->session->set_userdata(array('Err_desc'=>''));
										?>
                                    </div> 
							<?php    } ?>									
<div class="settings-body">

	<table class="tbl-settings">
	<div class="edit" for_edit='false'></div>
	<tr>
	<td>
	<fieldset class="body-border">
	<legend class="body-head">General</legend>
	<table class="">
	<tr><td><div class="form-group">
		<?php echo form_open(base_url()."general/driver_statuses");?>
		<?php echo form_label('Driver Statuses');?></td>
	<td><?php  
		$class="form-control";
		$tbl="driver_statuses";
		echo $this->form_functions->populate_editable_dropdown('select',$driver_statuses,$class,$tbl)?>
		<?php echo form_input(array('name'=>'select_text','id'=>'editbox','class'=>'form-control','style'=>'display:none','trigger'=>'true'));?>
		<?php echo form_input(array('name'=>'id_val','id'=>'id','style'=>'display:none'));?>
		</td>
	<td><?php echo form_input(array('name'=>'description','class'=>'form-control','id'=>'description','placeholder'=>'Description','value'=>'')); ?></td>

		<td><div  class="settings-add" ><?php echo nbs(5);?><i class="fa fa-plus-circle"></i><?php echo nbs(5);?></div><div class="hide-me"><?php echo form_submit("add","Add","id=settings-add-id","class=btn");?></div
		></td>
	<td><div  class="settings-edit" ><?php echo nbs(5);?><i class="fa fa-edit"></i><?php echo nbs(5);?></div><div class="hide-me xx"><?php echo form_submit("edit","Edit","id=settings-edit-id","class=btn");?></div></td>
		<td><div class="hide-me"><div  class="settings-delete" ><?php echo nbs(5);?><i class="fa fa-trash-o"></i><?php echo nbs(5);?></div><div class="hide-me"><?php echo form_submit("delete","Delete","id=settings-delete-id","class=btn");?></div></div></td>
		<?php echo form_error('name', '<p class="text-red">', '</p>'); ?>
		<?php echo form_close();?>
	<td style="width:5%;"></td>
	<td><div class="form-group">
		<?php echo form_open(base_url()."general/customer_statuses");?>
		<?php echo form_label('Customer Statuses');?></td>
	<td><?php  
		$class="form-control";
		$tbl="customer_statuses";
		echo $this->form_functions->populate_editable_dropdown('select',$customer_statuses,$class,$tbl)?>
		<?php echo form_input(array('name'=>'select_text','id'=>'editbox','class'=>'form-control','style'=>'display:none','trigger'=>'true'));?>
		<?php echo form_input(array('name'=>'id_val','id'=>'id','style'=>'display:none'));?>
		</td>
	<td><?php echo form_input(array('name'=>'description','class'=>'form-control','id'=>'description','placeholder'=>'Description','value'=>'')); ?></td>

		<td><div  class="settings-add" ><?php echo nbs(5);?><i class="fa fa-plus-circle"></i><?php echo nbs(5);?></div><div class="hide-me"><?php echo form_submit("add","Add","id=settings-add-id","class=btn");?></div
		></td>
	<td><div  class="settings-edit" ><?php echo nbs(5);?><i class="fa fa-edit"></i><?php echo nbs(5);?></div><div class="hide-me xx"><?php echo form_submit("edit","Edit","id=settings-edit-id","class=btn");?></div></td>
		<td><div class="hide-me"><div  class="settings-delete" ><?php echo nbs(5);?><i class="fa fa-trash-o"></i><?php echo nbs(5);?></div><div class="hide-me"><?php echo form_submit("delete","Delete","id=settings-delete-id","class=btn");?></div></div></td>
		<?php echo form_error('name', '<p class="text-red">', '</p>'); ?>
		<?php echo form_close();?>
	</tr>
	<tr >
	<td><div class="form-group">
		<?php echo form_open(base_url()."general/trip_statuses");?>
		<?php echo form_label('Trip Statuses');?></td>
	<td><?php  
		$class="form-control";
		$tbl="trip_statuses";
		echo $this->form_functions->populate_editable_dropdown('select',$trip_statuses,$class,$tbl)?>
		<?php echo form_input(array('name'=>'select_text','id'=>'editbox','class'=>'form-control','style'=>'display:none','trigger'=>'true'));?>
		<?php echo form_input(array('name'=>'id_val','id'=>'id','style'=>'display:none'));?>
		</td>
	<td><?php echo form_input(array('name'=>'description','class'=>'form-control','id'=>'description','placeholder'=>'Description','value'=>'')); ?></td>

		<td><div  class="settings-add" ><?php echo nbs(5);?><i class="fa fa-plus-circle"></i><?php echo nbs(5);?></div><div class="hide-me"><?php echo form_submit("add","Add","id=settings-add-id","class=btn");?></div
		></td>
	<td><div  class="settings-edit" ><?php echo nbs(5);?><i class="fa fa-edit"></i><?php echo nbs(5);?></div><div class="hide-me xx"><?php echo form_submit("edit","Edit","id=settings-edit-id","class=btn");?></div></td>
		<td><div class="hide-me"><div  class="settings-delete" ><?php echo nbs(5);?><i class="fa fa-trash-o"></i><?php echo nbs(5);?></div><div class="hide-me"><?php echo form_submit("delete","Delete","id=settings-delete-id","class=btn");?></div></div></td>
		<?php echo form_error('name', '<p class="text-red">', '</p>'); ?>
		<?php echo form_close();?>
	<td style="width:5%;"></td>
	<td><div class="form-group">
		<?php echo form_open(base_url()."general/notification_types");?>
		<?php echo form_label('Notification Types');?></td>
	<td><?php  
		$class="form-control";
		$tbl="notification_types";
		echo $this->form_functions->populate_editable_dropdown('select',$notification_types,$class,$tbl)?>
		<?php echo form_input(array('name'=>'select_text','id'=>'editbox','class'=>'form-control','style'=>'display:none','trigger'=>'true'));?>
		<?php echo form_input(array('name'=>'id_val','id'=>'id','style'=>'display:none'));?>
		</td>
	<td><?php echo form_input(array('name'=>'description','class'=>'form-control','id'=>'description','placeholder'=>'Description','value'=>'')); ?></td>

		<td><div  class="settings-add" ><?php echo nbs(5);?><i class="fa fa-plus-circle"></i><?php echo nbs(5);?></div><div class="hide-me"><?php echo form_submit("add","Add","id=settings-add-id","class=btn");?></div
		></td>
	<td><div  class="settings-edit" ><?php echo nbs(5);?><i class="fa fa-edit"></i><?php echo nbs(5);?></div><div class="hide-me xx"><?php echo form_submit("edit","Edit","id=settings-edit-id","class=btn");?></div></td>
		<td><div class="hide-me"><div  class="settings-delete" ><?php echo nbs(5);?><i class="fa fa-trash-o"></i><?php echo nbs(5);?></div><div class="hide-me"><?php echo form_submit("delete","Delete","id=settings-delete-id","class=btn");?></div></div></td>
		<?php echo form_error('name', '<p class="text-red">', '</p>'); ?>
		<?php echo form_close();?>
	</tr>
	<tr >
	<td><div class="form-group">
		<?php echo form_open(base_url()."general/notification_statuses");?>
		<?php echo form_label('Notification Statuses');?></td>
	<td><?php  
		$class="form-control";
		$tbl="notification_statuses";
		echo $this->form_functions->populate_editable_dropdown('select',$notification_statuses,$class,$tbl)?>
		<?php echo form_input(array('name'=>'select_text','id'=>'editbox','class'=>'form-control','style'=>'display:none','trigger'=>'true'));?>
		<?php echo form_input(array('name'=>'id_val','id'=>'id','style'=>'display:none'));?>
		</td>
	<td><?php echo form_input(array('name'=>'description','class'=>'form-control','id'=>'description','placeholder'=>'Description','value'=>'')); ?></td>

		<td><div  class="settings-add" ><?php echo nbs(5);?><i class="fa fa-plus-circle"></i><?php echo nbs(5);?></div><div class="hide-me"><?php echo form_submit("add","Add","id=settings-add-id","class=btn");?></div
		></td>
	<td><div  class="settings-edit" ><?php echo nbs(5);?><i class="fa fa-edit"></i><?php echo nbs(5);?></div><div class="hide-me xx"><?php echo form_submit("edit","Edit","id=settings-edit-id","class=btn");?></div></td>
		<td><div class="hide-me"><div  class="settings-delete" ><?php echo nbs(5);?><i class="fa fa-trash-o"></i><?php echo nbs(5);?></div><div class="hide-me"><?php echo form_submit("delete","Delete","id=settings-delete-id","class=btn");?></div></div></td>
		<?php echo form_error('name', '<p class="text-red">', '</p>'); ?>
		<?php echo form_close();?>

	<td style="width:5%;"></td>
	<td><div class="form-group">
		<?php echo form_open(base_url()."general/notification_view_statuses");?>
		<?php echo form_label('Notification View Statuses');?></td>
	<td><?php  
		$class="form-control";
		$tbl="notification_view_statuses";
		echo $this->form_functions->populate_editable_dropdown('select',$notification_view_statuses,$class,$tbl)?>
		<?php echo form_input(array('name'=>'select_text','id'=>'editbox','class'=>'form-control','style'=>'display:none','trigger'=>'true'));?>
		<?php echo form_input(array('name'=>'id_val','id'=>'id','style'=>'display:none'));?>
		</td>
	<td><?php echo form_input(array('name'=>'description','class'=>'form-control','id'=>'description','placeholder'=>'Description','value'=>'')); ?></td>

		<td><div  class="settings-add" ><?php echo nbs(5);?><i class="fa fa-plus-circle"></i><?php echo nbs(5);?></div><div class="hide-me"><?php echo form_submit("add","Add","id=settings-add-id","class=btn");?></div
		></td>
	<td><div  class="settings-edit" ><?php echo nbs(5);?><i class="fa fa-edit"></i><?php echo nbs(5);?></div><div class="hide-me xx"><?php echo form_submit("edit","Edit","id=settings-edit-id","class=btn");?></div></td>
		<td><div class="hide-me"><div  class="settings-delete" ><?php echo nbs(5);?><i class="fa fa-trash-o"></i><?php echo nbs(5);?></div><div class="hide-me"><?php echo form_submit("delete","Delete","id=settings-delete-id","class=btn");?></div></div></td>
		<?php echo form_error('name', '<p class="text-red">', '</p>'); ?>
		<?php echo form_close();?>

	</tr>

	</table>
	</fieldset>

</td>

</tr>
</table>

</div>
