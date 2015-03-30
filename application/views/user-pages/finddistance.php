<?php
$count=1;
?>
<div class="box box-custom">
    <div class="box-body1">
<div class="trip-booking-body">


	<!--trip-booking-area -start-->
	<div class="trip-booking-area">
		<!--trip-booking-area-first-col -start-->
		<div class="trip-booking-area-first-col">
				<!--trip-booking -start-->
			<fieldset class="body-border">
			<legend class="body-head">Find Distance And Calculate Rate</legend>
				<div class="trip-booking">
						
					<table class="table-width-100-percent-td-width-25-percent">	
						
						<tr>
							<td>
								<div class="form-group margin-10-px margin-top-less-12">
									<?php echo form_label('Pickup','pickuplabel'); ?>
									<?php echo form_input(array('name'=>'trip_from','class'=>'form-control height-27-px','placeholder'=>'Enter Pick Up','id'=>'pickup')); ?>
									
									<div class="hide-me"> <input class="pickuplat" name="trip_from_lat" type="text"><input class="pickup_h"  type="text"><input class="pickuplng" name="trip_from_lng" type="text"><input class="distance_from_web" name="distance_in_km_from_web" type="text"></div>
								</div>
							</td>
							<td>
								<div class="form-group margin-10-px margin-top-less-12">
									<?php echo form_label('Drop','droplabel'); ?>
									<?php echo form_input(array('name'=>'trip_to','class'=>'form-control height-27-px','placeholder'=>'Enter Drop','id'=>'drop')); ?>
									
									<div class="hide-me"> <input class="drop_h"  type="text"><input class="droplat" name="trip_to_lat" type="text" ><input class="droplng" name="trip_to_lng" type="text"></div>
								</div>
							</td>
							<td>
							<input type="button" class="calculate-trip-distance-rate btn btn-success" value="calculate">
							</td>
							
							
							
							
					</tr>
					
				</table>
				<table class="table table-bordered" style="width:400px;margin:auto;">
					<tr>
						<td class="no-border"><p style="font-size:18px;">Estimate</p></td>
						<td class="no-border"></td>
					</tr>
					<tr>
						<td>Distance In KM :</td>
						<td class="trip-km"></td>
					</tr>
					<tr>
						<td>Rate(KM * 20) :</td>
						<td class="trip-rate"></td>
					</tr>
				</table>
				</div>
				
				
	</div>
	</div>
    <!-- end loading -->

