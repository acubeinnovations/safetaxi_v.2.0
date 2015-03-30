<?php
if($this->session->userdata('post')==null){
$title='';
$minimum_kilometers='';
$from_date='';
$day_rate='';
$night_rate='';
$additional_kilometer_day_rate='';
$additional_kilometer_night_rate='';
}
else
{
$data=$this->session->userdata('post');
$title=$data['title'];
$minimum_kilometers=$data['minimum_kilometers'];
$from_date=$data['from_date'];
$day_rate=$data['day_rate'];
$night_rate=$data['night_rate'];
$additional_kilometer_day_rate=$data['additional_kilometer_day_rate'];
$additional_kilometer_night_rate=$data['additional_kilometer_night_rate'];

$this->session->set_userdata('post','');
}
?>

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
<div class="tarrif_master_body">
<fieldset class="body-border " >
<legend class="body-head">Search</legend>
<table>
	<tr>
		<td><?php echo form_open(base_url()."front-desk/tariff"); 
		 echo form_input(array('name'=>'search_from_date','class'=>'fromdatepicker form-control' ,'placeholder'=>' From Date')); ?>
		</td>
		<td><?php  echo form_input(array('name'=>'search_to_date','class'=>'fromdatepicker form-control' ,'placeholder'=>' To Date')); ?></td>
		<td><?php echo form_submit("search","Search","class='btn btn-primary'");
		echo form_close();?></td>
		</tr>
		</table>
			<p class="text-red"><?php
		 if($this->session->userdata('Date') != ''){
			echo $this->session->userdata('Date');
			$this->session->set_userdata(array('Date'=>''));
		 }
			?></p>
			<p class="text-red"><?php
		 if($this->session->userdata('Err_from_date') != ''){
			echo $this->session->userdata('Err_from_date');
			$this->session->set_userdata(array('Err_from_date'=>''));
		 }
			?></p>
			<p class="text-red"><?php
		 if($this->session->userdata('Err_to_date') != ''){
			echo $this->session->userdata('Err_to_date');
			$this->session->set_userdata(array('Err_to_date'=>''));
		 }
			?></p>

	
		</fieldset>
		<fieldset class="body-border " >
		<legend class="body-head">Add New Tariff</legend>
		<div class="form-group">
		<table>
		<tr>
		<td>
			<div class="form-group">
				<?php echo form_open(base_url()."tariff/tarrif_manage");
						echo form_input(array('name'=>'title','class'=>'form-control','id'=>'title','placeholder'=>'Title','value'=>$title)); 
				?>
			</div>
		</td>
		<td>
			<div class="form-group">
				<?php 
				if($minimum_kilometers==""){
					echo form_input(array('name'=>'minimum_kilometers','class'=>'form-control','id'=>'minimum_kilometers','placeholder'=>'Minimum Kilometers','value'=>$minimum_kilometers)); 
				}
				else
				{
					echo form_input(array('name'=>'minimum_kilometers','class'=>'form-control','id'=>'minimum_kilometers','placeholder'=>'Minimum Kilometers','value'=>number_format($minimum_kilometers,2))); 
				}
				?>
			</div>
		</td>
		<td>
			<div class="form-group">
				<?php echo form_input(array('name'=>'from_date','class'=>'fromdatepicker form-control' ,'placeholder'=>' From Date','value'=>$from_date)); ?>
			</div>
		</td>
		<td>
			<div class="form-group">
				<?php 
				if($day_rate==""){
				echo form_input(array('name'=>'day_rate','class'=>'form-control','id'=>'day_rate','placeholder'=>'Day Rate','value'=>$day_rate)); 
				}
				else
				{
				echo form_input(array('name'=>'day_rate','class'=>'form-control','id'=>'day_rate','placeholder'=>'Day Rate','value'=>number_format($day_rate,2))); 
				}?>
			</div>
		</td>
		<td>
			<div class="form-group">
			<?php 
				if($night_rate==""){
				echo form_input(array('name'=>'night_rate','class'=>'form-control','id'=>'night_rate','placeholder'=>'Night Rate','value'=>$night_rate)); 
				}
				else
				{
				echo form_input(array('name'=>'night_rate','class'=>'form-control','id'=>'night_rate','placeholder'=>'Night Rate','value'=>number_format($night_rate,2))); 
				}
				?>
			</div>
		</td>
		<td>
			<div class="form-group">
			<?php 
				if($additional_kilometer_day_rate==""){
				echo form_input(array('name'=>'additional_kilometer_day_rate','class'=>'form-control','id'=>'additional_kilometer_day_rate','placeholder'=>'Additional Kilometer Day Rate','value'=>$additional_kilometer_day_rate)); 
				}
				else{
				echo form_input(array('name'=>'additional_kilometer_day_rate','class'=>'form-control','id'=>'additional_kilometer_day_rate','placeholder'=>'Additional Kilometer Day Rate','value'=>number_format($additional_kilometer_day_rate,2))); 
				}?>
			</div>
		</td>
		<td>
			<div class="form-group">
			<?php
				if($additional_kilometer_night_rate==""){
						echo form_input(array('name'=>'additional_kilometer_night_rate','class'=>'form-control','id'=>'additional_kilometer_night_rate','placeholder'=>'Additional Kilometer Night Rate','value'=>$additional_kilometer_night_rate)); 
					}
					else{
						echo form_input(array('name'=>'additional_kilometer_night_rate','class'=>'form-control','id'=>'additional_kilometer_night_rate','placeholder'=>'Additional Kilometer Night Rate','value'=>number_format($additional_kilometer_night_rate,2))); 
					}?>
			</div>
		</td>
		<td>
			<div  class="tarrif-add" >
				<?php echo nbs(5);?><i class="fa fa-plus-circle cursor-pointer"></i><?php echo nbs(5);?></div><div class="hide-me"><?php echo form_submit("tarrif-add","Add","id=tarrif-add-id","class=btn");?>
			</div>
		</td>
	</tr>
	<tr>
		<td><?php echo  $this->form_functions->form_error_session('title','<p class="text-red">', '</p>');?></td>
		<td><?php echo  $this->form_functions->form_error_session('minimum_kilometers','<p class="text-red">', '</p>');?></td>
		<td><?php echo  $this->form_functions->form_error_session('from_date','<p class="text-red">', '</p>');?>
			<p class="text-red">
				<?php
					if($this->session->userdata('Err_dt') != ''){
						echo $this->session->userdata('Err_dt');
						$this->session->set_userdata(array('Err_dt'=>''));
					}
				?>
			</p>
		</td>
		<td><?php echo  $this->form_functions->form_error_session('day_rate','<p class="text-red">', '</p>');?></td>
		<td><?php  echo  $this->form_functions->form_error_session('night_rate','<p class="text-red">', '</p>'); ?></td>
		<td><?php echo  $this->form_functions->form_error_session('additional_kilometer_day_rate','<p class="text-red">', '</p>');?></td>
		<td><?php echo  $this->form_functions->form_error_session('additional_kilometer_night_rate','<p class="text-red">', '</p>'); ?></td>
	</tr>
</table>
<?php echo form_close();?>
</div>
</fieldset>
<div class="msg"> <?php 
			if (isset($result)){ echo $result;} else {?></div>
<fieldset class="body-border ">
<legend class="body-head">Manage Tariff</legend>
<?php echo br();?>
<table>
<tr>
<td><?php echo form_label('Title ','title'); ?></td>
<td><?php echo form_label('Minimum Kilometers','minimum_kilometers'); ?></td>
<td><?php echo form_label('From Date','from_Date'); ?></td>
<td><?php echo form_label('Day Rate','dayrate'); ?></td>
<td><?php echo form_label('Night Rate','nightrate'); ?></td>
<td><?php echo form_label('Additional Day Rate','additional_day_Rate'); ?></td>
<td><?php echo form_label('Additional Night Rate','additional_day_rate'); ?></td>
<td></td>
<td></td>
</tr>
<?php 
foreach($values as $det):

?>

<tr>
<td>
			<div class="form-group">
				<?php echo form_open(base_url()."tariff/tarrif_manage");
						echo form_input(array('name'=>'title','class'=>'form-control','id'=>'title','placeholder'=>'Title','value'=>$det['title']));
						if(null!=$this->mysession->get('Err_title'.$det['id'])){
							echo '<p class="text-red">'.$this->mysession->get('Err_title'.$det['id']).'</p>';
							$this->mysession->delete('Err_from_date'.$det['id']);
						} 
				?>
			</div>
		</td>
		<td>
			<div class="form-group">
				<?php 
				
					echo form_input(array('name'=>'minimum_kilometers','class'=>'form-control','id'=>'minimum_kilometers','placeholder'=>'Minimum Kilometers','value'=>number_format($det['minimum_kilometers'],2)));
				if(null!=$this->mysession->get('Err_minimum_kilometers'.$det['id'])){
					echo '<p class="text-red">'.$this->mysession->get('Err_minimum_kilometers'.$det['id']).'</p>';
					$this->mysession->delete('Err_minimum_kilometers'.$det['id']);
				}
				
				?>
			</div>
		</td>
		<td>
			<div class="form-group">
				<?php echo form_input(array('name'=>'from_date','class'=>'fromdatepicker form-control' ,'placeholder'=>' From Date','value'=>$det['from_date']));
			if(null!=$this->mysession->get('Err_from_date'.$det['id'])){
				echo '<p class="text-red">'.$this->mysession->get('Err_from_date'.$det['id']).'</p>';
				$this->mysession->delete('Err_from_date'.$det['id']);
			} ?>
			</div>
		</td>
		<td>
			<div class="form-group">
				<?php 
				
				echo form_input(array('name'=>'day_rate','class'=>'form-control','id'=>'day_rate','placeholder'=>'Day Rate','value'=>number_format($det['day_rate'],2)));
				if(null!=$this->mysession->get('Err_day_rate'.$det['id'])){
					echo '<p class="text-red">'.$this->mysession->get('Err_day_rate'.$det['id']).'</p>';
					$this->mysession->delete('Err_day_rate'.$det['id']);
				} 
				?>
			</div>
		</td>
		<td>
			<div class="form-group">
			<?php 
				
				echo form_input(array('name'=>'night_rate','class'=>'form-control','id'=>'night_rate','placeholder'=>'Night Rate','value'=>number_format($det['night_rate'],2)));
				if(null!=$this->mysession->get('Err_night_rate'.$det['id'])){
				echo '<p class="text-red">'.$this->mysession->get('Err_night_rate'.$det['id']).'</p>';	
				$this->mysession->delete('Err_night_rate'.$det['id']);
				} 
				
				?>
			</div>
		</td>
		<td>
			<div class="form-group">
			<?php 
				
				echo form_input(array('name'=>'additional_kilometer_day_rate','class'=>'form-control','id'=>'additional_kilometer_day_rate','placeholder'=>'Additional Kilometer Day Rate','value'=>number_format($det['additional_kilometer_day_rate'],2)));
			if(null!=$this->mysession->get('Err_additional_kilometer_day_rate'.$det['id'])){
			echo  '<p class="text-red">'.$this->mysession->get('Err_additional_kilometer_day_rate'.$det['id']).'</p>'; 
			$this->mysession->delete('Err_additional_kilometer_day_rate'.$det['id']); }
			?>
			</div>
		</td>
		<td>
			<div class="form-group">
			<?php
				
						echo form_input(array('name'=>'additional_kilometer_night_rate','class'=>'form-control','id'=>'additional_kilometer_night_rate','placeholder'=>'Additional Kilometer Night Rate','value'=>number_format($det['additional_kilometer_night_rate'],2)));
					if(null!=$this->mysession->get('Err_additional_kilometer_night_rate'.$det['id'])){
						echo '<p class="text-red">'.$this->mysession->get('Err_additional_kilometer_night_rate'.$det['id']).'</p>';
						$this->mysession->delete('Err_additional_kilometer_night_rate'.$det['id']);
						} 
					?>
			
           <div class="hide-me"><?php echo form_input(array('name'=>'manage_id','class'=>'form-control','id'=>'manage_id','value'=> $det['id'],'trigger'=>'true' ));?>
			</div>
		</td>
		<td>
			<div  class="tarrif-edit" ><?php echo nbs(5);?><i class="fa fa-edit cursor-pointer"></i><?php echo nbs(5);?></div><div class="hide-me xx"><?php echo form_submit("edit","Edit","id=tarrif-edit-id","class=btn");?>
			</div>
		</td>
		<td><div class="hide-me">
			<div  class="tarrif-delete" ><?php echo nbs(5);?><i class="fa fa-trash-o cursor-pointer"></i><?php echo nbs(5);?></div><div class="hide-me"><?php echo form_submit("delete","Delete","id=tarrif-delete-id","class=btn");?>
			</div>
		</div>
		</td>
		<?php echo form_close();?>
	</tr>

<?php endforeach; ?>
</table>
<?php echo $page_links;?>
</fieldset>
<?php } ?>
</div>
