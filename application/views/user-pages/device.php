<?php

$sim_no='';
$imei='';
$device_id=-1;
if($this->session->userdata('dbError') != ''){ ?>
	<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Alert!</b><br><?php
													
										?>
                                    </div>
<?php  }  if($this->session->userdata('dbSuccess') != '') { ?>
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
<div class="device-body width-50-percent-margin-auto">
<fieldset class="body-border">
<legend class="body-head">Search</legend>
<table>
<tr>
<td><?php echo form_open(base_url()."front-desk/device"); 
 echo form_input(array('name'=>'s_sim_no','class'=>'form-control' ,'placeholder'=>'Sim No','value'=>$s_sim_no)); ?>
</td>
<td><?php  echo form_input(array('name'=>'s_imei','class'=>'form-control' ,'placeholder'=>'Enter IMEI','value'=>$s_imei)); ?></td>
<td><?php echo form_submit("search","Search","class='btn btn-primary'");
echo form_close();?></td>
</tr>
</table>
</fieldset>
<fieldset class="body-border" >
<legend class="body-head">Add Devices</legend>
<div class="form-group">
	<?php echo form_open(base_url()."device/deivceManage");?>
<table>
<tr>
		<td><div class="form-group"><?php echo form_input(array('name'=>'imei','class'=>'form-control' ,'id'=>'imei','placeholder'=>'Enter imei','value'=>$imei)); ?></div></td>
		<td><div class="form-group"><?php echo form_input(array('name'=>'sim_no','class'=>'form-control','id'=>'sim','placeholder'=>'Sim Number','value'=>$sim_no)); ?></div></td>
		<td><div class="form-group"><div  class="device-add"><?php echo nbs(5);?><i class="fa fa-plus-circle addDeviceico cursor-pointer"></i><?php echo nbs(5);?></div>
		<div class="hide-me"><?php echo form_submit("deviceAdd","ADD","id=addDevice","class=btn"); ?></div> </div></td>
		</tr>
</table>
		<?php  echo  $this->form_functions->form_error_session('imei','<p class="text-red">', '</p>'); ?>
		<?php echo  $this->form_functions->form_error_session('sim_no','<p class="text-red">', '</p>');?>
<?php echo form_close(); ?>
</div>
</fieldset>
<div class="msg"> <?php 
			if (isset($result)){ echo $result;} else {?></div>
<fieldset class="body-border border-style">
<legend class="body-head">Manage Devices</legend>
<?php echo br();?>
<table >
<tr>
<td><?php echo form_label('IMEI ','imei'); ?></td>
<td><?php echo form_label('Sim Number','sim_no'); ?></td>
<td width="200"><span class="reg_num_style"><?php echo form_label('Registration Number','reg_no'); ?></span></td>
</tr>
<?php 

foreach ($values as $det):
?>

<?php echo form_open(base_url()."device/deivceManage");?>
<tr>
<td><?php echo form_input(array('name'=>'imei'.$det['id'],'class'=>'form-control' ,'id'=>'imei','placeholder'=>'Enter imei','value'=>$det['imei'])).'<div class="hide-me">'.form_input(array('name'=>'h_imei'.$det['id'],'value'=>$det['imei'])); ?></div></td>
		<td><?php echo form_input(array('name'=>'sim_no'.$det['id'],'class'=>'form-control','id'=>'sim','placeholder'=>'Sim Number','value'=>$det['sim_no'])).'<div class="hide-me">'.form_input(array('name'=>'h_sim_no'.$det['id'],'value'=>$det['sim_no'])); ?></div>
		<div class="hide-me"><?php echo form_input(array('name'=>'device_id','class'=>'form-control','id'=>'device_id','value'=>$det['id'])); ?></div></td>
		<td width="200"><span class="reg_num_style"><?php if(empty($devices[$det['id']])){ echo 'Vehicle Not Assigned';}else {echo form_label($devices[$det['id']],'reg_num'); }?></span></td>
<td><div class="device-edit"><?php echo nbs(5);?><i class="fa fa-edit deviceUpdate cursor-pointer"></i><?php echo nbs(5);?><div class="hide-me xx"><?php echo form_submit("deviceUpdate","Edit","id=device-edit-id","class=btn");?></div></div></td><!--
<td><div  class="device-delete"><?php echo nbs(5);?><i class="fa fa-trash-o deviceDelete"></i><?php echo nbs(5);?><div class="hide-me"><?php echo form_submit("deviceDelete","Delete","id=device-delete-id","class=btn ");?></div></div></td>-->

</tr>
<tr>
		<td><?php  echo  $this->form_functions->form_error_session('imei'.$det['id'],'<p class="text-red">', '</p>'); ?></td>
		<td><?php echo  $this->form_functions->form_error_session('sim_no'.$det['id'],'<p class="text-red">', '</p>');?></td>
		<?php echo form_close(); ?>
		</tr>
<?php endforeach; ?>
</table>
<?php echo $page_links;?>
</fieldset>
<?php } ?>
</div>
