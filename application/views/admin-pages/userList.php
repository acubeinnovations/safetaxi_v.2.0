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
	  <?php 
	  //search?>

<div class="page-outer">    
	<fieldset class="body-border">
		<legend class="body-head">List Users</legend>
		<div class="box-body table-responsive no-padding">
			<?php echo form_open(base_url().'admin/front_desk/list/');?>
			<table class="table list-org-table">
				<tbody>
					<tr>
					    <td><?php echo form_input(array('name'=>'sname','class'=>'form-control','id'=>'sname','placeholder'=>'By Name','size'=>30));?> </td>
					    <td><?php $class="form-control";
						echo $this->form_functions->populate_dropdown('status',$user_status,$selected='',$class,$id='',$msg='Select Status')?>
						</td>
					    <td><?php echo form_submit("search","Search","class='btn btn-primary'");?></td>
					    <?php echo form_close();?>
						<td><?php echo nbs(55); ?></td>
						<td><?php echo nbs(35); ?></td>
						<td><?php echo nbs(25); ?></td>
					</tr>
				</tbody>
			</table>
				<div class="msg"> <?php 
			if (isset($result)){ echo $result;} else {?></div>
		</div>
		<div class="box-body table-responsive no-padding">
			<table class="table table-hover table-bordered">
				<tbody>
					<tr>
					    <th>User Name</th>
						<th>Name</th>
					    <th>Address</th>
					    <th>Status</th>
					    <th>Action</th>
					</tr>
					<?php
					//$status=array('1'=>'Active','2'=>'Inactive');
					
					foreach($values as $row):
					?>
					<tr>
					    <td><?php echo $row['username'];?></td>
						<td><?php echo $row['first_name'].' '.$row['last_name'];?></td>
					    <td><?php echo $row['address'] ;?></td>
					    <td><?php if($row['user_status_id'] == USER_STATUS_ACTIVE) { ?>
							<span class="label label-success"><?php echo $user_status[$row['user_status_id']];?></span> 
						<?php } else {?>
							<span class="label label-danger"> <?php echo $user_status[$row['user_status_id']];?></span>
						<?php } ?>
						</td>	
						<td>
							<?php echo anchor(base_url().'admin/front_desk/'.$row['username'],'Edit','class="btn btn-primary"').nbs(3).anchor(base_url().'admin/front_desk/'.$row['username'].'/password-reset','Change Password','class="btn btn-primary"'); ?>
						</td>
					</tr>
					<?php endforeach;
					?>
				</tbody>
			</table><?php echo $page_links;?>
		</div>
		<?php } ?>
	</fieldset>
</div>

