<div id="body-wrap">
	<?php	if($this->session->userdata('dbSuccess') != '') { ?>
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
       <?php	} ?> 
	

	<div id="body">
	     <h1>Trip Statistics For The Day</h1>                       
		 <div id="front-desk-dashboard" style="width: 100%; height: 600px;"></div>
	</div>

</div>
