<?php
$count=1;
?>
<div class="box box-custom">
    <div class="box-body1">
<div class="trip-booking-body">
<div class="db-msgs">
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
       <?php    }else if($this->session->userdata('dbError') != ''){ ?>
	<div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         <b>Alert!</b><br><?php
		echo $this->session->userdata('dbError').br();
		$this->session->set_userdata(array('dbError'=>''));
	?>
      </div> 
	<?php    } ?>
 </div> 

	<!--trip-booking-area -start-->
	<div class="trip-booking-area">
		<!--trip-booking-area-first-col -start-->
		<div class="trip-booking-area-first-col">
				<!--trip-booking -start-->
			<fieldset class="body-border">
			<legend class="body-head">Trips</legend>
				<div class="trip-booking"><div class="float-right"><?php if($id!=gINVALID){ ?><a href="<?php echo base_url();?>front-desk/trip-booking" class="btn btn-sm btn-info">New Trip</a><?php } ?></div>
					<?php	
						$attributes = array('autocomplete'=>'off','id'=>'trip-form');
						 echo form_open(base_url().'trip-booking/book-trip',$attributes); ?>
					<table class="table-width-100-percent-td-width-25-percent">	
						<tr>
							<td>
								<div class="form-group margin-10-px margin-top-less-1">
									<?php echo form_label('Name','namelabel'); ?>
									<?php echo form_input(array('name'=>'name','class'=>'form-control height-27-px','placeholder'=>'Enter Name','value'=>$name,'id'=>'customer')).form_label('','name_error'); ?>
									<?php echo $this->form_functions->form_error_session('name', '<p class="text-red">', '</p>'); ?>
								</div>
							</td>
							<td>
								<div class="form-group margin-10-px margin-top-less-1">
									<?php echo form_label('Mobile','mobilelabel'); ?>
									<?php echo form_input(array('name'=>'mobile','class'=>'form-control height-27-px','placeholder'=>'Enter Mobile','value'=>$mobile,'id'=>'mobile')).form_label('','mobile_error'); ?>
									<?php echo $this->form_functions->form_error_session('mobile', '<p class="text-red">', '</p>'); ?>
								</div>
							</td>
							<td>
								<div class="form-group margin-10-px margin-top-less-1">
						<button class="btn btn-info btn-sm add-customer hide-me" type="button" added_customer="<?php echo $added_customer; ?>">ADD</button>
									<button class="btn btn-danger btn-sm clear-customer" type="button">CLEAR</button>
								</div>
							</td>
							
							
						</tr>
						<tr>
							<td>
								<div class="form-group margin-10-px margin-top-less-12">
									<?php echo form_label('Pickup','pickuplabel'); ?>
									<?php echo form_input(array('name'=>'trip_from','class'=>'form-control height-27-px','placeholder'=>'Enter Pick Up','value'=>$trip_from,'id'=>'pickup')); ?>
									<?php echo $this->form_functions->form_error_session('trip_from', '<p class="text-red">', '</p>'); ?>
									<div class="hide-me"> <input class="pickup_h"  type="text"><input class="pickuplat" name="trip_from_lat" type="text" value="<?php echo $trip_from_lat; ?>"><input class="pickuplng" name="trip_from_lng" type="text" value="<?php echo $trip_from_lng; ?>"><input class="distance_from_web" name="distance_in_km_from_web" type="text" value="<?php echo $distance_in_km_from_web; ?>"></div>
								</div>
							</td>
							<td>
								<div class="form-group margin-10-px margin-top-less-12">
									<?php echo form_label('Pickup Landmark','pickuplandmarklabel'); ?>
									<?php echo form_input(array('name'=>'trip_from_landmark','class'=>'form-control height-27-px','placeholder'=>'Enter Pick Up Landmark','value'=>$trip_from_landmark)); ?>
									<?php echo $this->form_functions->form_error_session('trip_from_landmark', '<p class="text-red">', '</p>'); ?>
									
								</div>
							</td>
							
							<td>
								<div class="form-group margin-10-px">
									<?php if($trip_status_id==TRIP_STATUS_ACCEPTED || $trip_status_id==TRIP_STATUS_PENDING || $id==gINVALID ){ if($roundtrip=='t') { $checked = "checked='checked'"; }else{ $checked = ""; } ?><div class="round-trip-container"> <input <?php echo $checked; ?> type="checkbox" name="roundtrip" class="roundtrip"/><?php echo nbs(2).form_label('Round Trip','Round_Trip'); } ?></div>
									<?php if($driver_id!=gINVALID && $trip_status_id==TRIP_STATUS_ACCEPTED ){ ?><input  class="btn btn-warning btn-sm revoke-driver " name="revoke" type="submit" value="REVOKE DRIVER" ><?php } ?>	<div class="hide-me"> <input name="driver_id" class="" value="<?php echo $driver_id; ?>" type="text"></div>
							 </div>
							</td>
							
							
							
					</tr>
					<tr>
							
							<td>
								<div class="form-group margin-10-px margin-top-less-12">
									<?php echo form_label('Drop','droplabel');   if($localtrip=='t') { $checked = "checked='checked'"; $disabled_drop="disabled=>'true'"; }else{ $checked = ""; $disabled_drop="";} ?><div class="float-right local-trip-container"> <input <?php echo $checked;  ?> type="checkbox" name="localtrip" class="localtrip"/><?php echo nbs(2).form_label('Local','local_trip');  ?> </div>
									<?php echo form_input(array('name'=>'trip_to','class'=>'form-control height-27-px','placeholder'=>'Enter Drop','value'=>$trip_to,'id'=>'drop',$disabled_drop));?>
									<?php echo $this->form_functions->form_error_session('trip_to', '<p class="text-red">', '</p>'); ?>
									<div class="hide-me"> <input class="drop_h"  type="text"> <input class="droplat" name="trip_to_lat" type="text" value="<?php echo $trip_to_lat; ?>"><input class="droplng" name="trip_to_lng" type="text" value="<?php echo $trip_to_lng; ?>"></div>
								</div>
							</td>
							<td>
								<div class="form-group margin-10-px margin-top-less-12">
									<?php echo form_label('Drop Landmark','droplandmarklabel'); ?>
									<?php echo form_input(array('name'=>'trip_to_landmark','id'=>'droploc','class'=>'form-control height-27-px','placeholder'=>'Enter Drop Landmark','value'=>$trip_to_landmark,$disabled_drop)); ?>
									<?php echo $this->form_functions->form_error_session('trip_to_landmark', '<p class="text-red">', '</p>'); ?>
								</div>
							</td>
							<td>
								<div class="input-group margin-10-px ">
										<?php if($id==gINVALID || ($driver_id==gINVALID && $trip_status_id==TRIP_STATUS_PENDING)){  ?>
                                        <input name="radius" class="form-control width-30-percent float-left height-27-px" value="<?php echo $radius; ?>" type="text">		<span class="input-group-addon float-left width-20-percent height-27-px">KM</span>		<?php } ?>
                                        
										<?php if($id!=gINVALID && $driver_id==gINVALID && $trip_status_id==TRIP_STATUS_PENDING){  ?><i class="fa fa-fw btn btn-info btn-sm margin-left-3-px no-padding search-ico">SEARCH AND NOTIFY</i> <div class="hide-me"> <input  class="btn btn-info btn-sm search" name="search" type="submit" ></div> <?php }else if($id!=gINVALID && $trip_status_id!=TRIP_STATUS_PENDING){ ?> <input  class="btn btn-info btn-sm search" name="reccurent" type="button" value="RECCURENT" id="reccurent" > <?php } ?>
                                    </div>
							</td>
							
					</tr>
					<tr>
							
							<td>
								<div class="form-group margin-10-px margin-top-less-12">
									<?php echo form_label('Pickup Date','pickupdatelabel'); ?>
									<?php echo form_input(array('name'=>'pick_up_date','class'=>'form-control height-27-px initialize-date-picker pickupdate','placeholder'=>'Enter Pick Up Date','value'=>$pick_up_date)); ?>
									<?php echo $this->form_functions->form_error_session('pick_up_date', '<p class="text-red">', '</p>'); ?>
								</div>
							</td>
							<td>
								<div class="form-group margin-10-px margin-top-less-12">
									<?php echo form_label('Pickup Time','pickuptimelabel'); ?>
									<?php echo form_input(array('name'=>'pick_up_time','class'=>'form-control height-27-px pickuptime initialize-time-picker','placeholder'=>'Enter Pickup Time','value'=>$pick_up_time)); ?>
									<?php if($id!=gINVALID){ ?>
									<div class="hide-me"><?php echo form_input(array('name'=>'pick_up_time_update','class'=>'form-control height-27-px pick_up_time_update','value'=>$pick_up_time)); ?><?php echo form_input(array('name'=>'pick_up_date_update','class'=>'form-control height-27-px  pick_up_date_update','value'=>$pick_up_date)); ?></div>
									<?php } ?>
									<?php echo $this->form_functions->form_error_session('pick_up_time', '<p class="text-red">', '</p>'); ?>
								</div>
							</td>
							<td>
								<div class="form-group margin-10-px margin-top-less-12"><?php  if($id!=gINVALID){ $saveandsearch="UPDATE"; }else{ $saveandsearch="SAVE AND SEARCH"; } if($id==gINVALID || $trip_status_id==TRIP_STATUS_PENDING || $trip_status_id==TRIP_STATUS_ACCEPTED) { ?> 
									<input class="btn btn-success btn-sm 	search-vehicles book_trip" name="book_trip_button" type="button" value="<?php echo $saveandsearch; ?>"><div class="hide-me"><input class="btn book_trip_submit" name="book_trip" type="submit"></div><div class="hide-me"> <input name="id" class="id" value="<?php echo $id; ?>" type="text"></div> 
									<?php  if($id!=gINVALID){ ?> <input  class="btn btn-danger btn-sm cancel-trip margin-top-10-px" name="cancel_trip" type="submit" value="CANCEL"> <?php } } ?>
								
								</div>
							</td>
					</tr>
				</table>
				</div>
				 <?php echo form_close(); ?>
				<!--trip-booking -end-->
				<!--trip-booking-info -start-->
				<div class="trip-booking-info">
						<div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active" id="list-tab"><a href="#tab_1" data-toggle="tab">List</a></li>
                                    <li class="" id="map-tab" loaded='false'><a href="#tab_2" data-toggle="tab">Map</a></li>
                                   	<li class="" id="track-map-tab" loaded='false'><a href="#tab_3" data-toggle="tab">Track Vehicle</a></li>
                                    
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
		                                  <div class="box-body list-notified-vehicles">
				                            <table class="table table-bordered">
						                            <tbody><tr>
						                                <th style="width: 5%">Sl</th>
						                                <th style="width:20%">Vehicle</th>
						                                <th style="width:20%">Driver</th>
						                                <th style="width:20%">Mobile</th>
														 <th style="width:15%">Reject</th>
														<th style="width:15%">Awarded</th>
						                            </tr>
										<?php if($list_of_drivers!=''){
												for($index=0;$index<count($list_of_drivers);$index++){
													if($driver_id!=gINVALID){
													if($list_of_drivers[$index]['id']!=$driver_id){ $reject='<span class="badge bg-red">+</span>';$awarded=''; }else{ $awarded='<span class="badge bg-green">+</span>';$reject='';}
															}else{
																	$reject='';$awarded='';

																} ?>
						                            <tr>
						                                <td><?php echo $index+1; ?></td>
														<td><?php echo $list_of_drivers[$index]['vehicle_registration_number']; ?></td>
														<td><?php echo $list_of_drivers[$index]['name']; ?></td>
						                                <td><?php echo $list_of_drivers[$index]['mobile']; ?></td>
						                                <td><?php echo $reject; ?></td>
						                                <td><?php echo $awarded; ?></td>
						                            </tr>
						                          <?php }
													}
													?>  
						                       	 </tbody>
											</table>
		                           	 	</div>
                                    </div><!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_2">
                                       <div id="map_canvas"></div>
                                    </div><!-- /.tab-pane -->
																		 <div class="tab-pane" id="tab_3">
                                       <div id="track_map_canvas"></div>
                                    </div><!-- /.tab-pane -->
                                </div><!-- /.tab-content -->
                            </div>

				</div>
				<!--trip-booking-info -end-->
			</fieldset>
		</div>
		<!--trip-booking-area-first-col -end-->
	
		<!--trip-booking-area-second-col -start-->
		<div class="trip-booking-area-second-col">

				<!--trip-booking-notifications -start-->
				<div class="trip-booking-notifications">
					 <fieldset class="body-border">
					<legend class="body-head">Notifications</legend>
						<div class="ajax-notifications">
						<?php
		
						if(count($notification)>0 && $notification!=''){
						for($notification_index=0;$notification_index<count($notification);$notification_index++){?>
						<a href="<?php echo base_url().'front-desk/trip-booking/'.$notification[$notification_index]->id;?>" class="notify-link">
						<div class="callout callout-warning no-right-padding width-100-percent float-left">
						<div class="notification<?php echo $notification_index; ?>">
							<table style="width:100%;" class="font-size-12-px">
								<tr>
									<td class='notification-trip-id'>
										Trip ID :<?php echo $notification[$notification_index]->id; ?>
									</td>
									<td>
										Cust :	<?php echo $customers_array[$notification[$notification_index]->customer_id]; ?>
									</td>
								</tr>
				
								<tr>
									<td class='notification-trip-id'>
										Pick up :
									</td>
									<td>
										<?php echo $notification[$notification_index]->trip_from; ?>
									</td>
								</tr>
								<tr>
									<td class='notification-pickup-city'>
									Date :</td><td><?php echo $notification[$notification_index]->pick_up_date; ?>
									</td>
								</tr>
							</table>
						</div>
						</div>
						</a>
						<?php }


						}


						?>
						</div>
 					</fieldset>
				</div>
				<!--trip-booking-notifications -end-->

		</div>
		<!--trip-booking-area-second-col -end-->

	</div>
	<!--trip-booking-area -end-->
	</div>
	
   </div><!-- /.box-body1 -->
	<div class='overlay-container'>
   		<div class="overlay modal"></div>
			<div class="loading-img"></div>
				<div class="modal-body width-50-percent-important border-2-px box-shadow height-300-px ">
						<?php $attributes = array('autocomplete'=>'off','id'=>'reccurent-trip-form');
						 echo form_open(base_url().'trip-booking/book-trip',$attributes); ?>
						<div class="reccurent-container" slider="<?php echo $count; ?>">
								<fieldset class="body-border width-90-percent position-absolute">
								<legend class="body-head">Recurrent</legend>
									
									<div class="form-group float-right recurrent-radio-container">
									<div class="div-continues">
									<?php
												echo nbs(1).form_radio(array('name' => 'recurrent','id' => 'continues-recurrent','value'=>'continues'));
								
												echo nbs(5).form_label('Continues').nbs(5);
												?></div> <div class="div-alternatives"><?php
												echo form_radio(array('name' => 'recurrent','id' => 'alternative-recurrent','value'=>'alternatives'));
								
											echo nbs(5).form_label('Alternatives');
											?>
									</div>
									</div>
									<div class="recurrent-container-continues">
										<div class="form-group">
									
												<?php 
								
												echo form_input(array('name'=>'reccurent_continues_pickupdatepicker','class'=>'form-control width-60-percent-with-margin-10','id'=>'reccurent_continues_pickupdatepicker','placeholder'=>'Pick up Date ')).form_input(array('name'=>'reccurent_continues_pickuptimepicker','class'=>'form-control width-30-percent-with-margin-left-20','id'=>'reccurent_continues_pickuptimepicker','placeholder'=>'Pick up time '));
												 ?><p class="text-red float-left margin-top-less-12 margin-left-15-px date clear-error"></p><p class="text-red float-right margin-top-less-12 margin-right-110-px time clear-error"></p><?php echo br(3); ?>
									
											</div>
											
										</div>
										<div class="recurrent-container-alternatives">
											<table class="alternative-table">
												<tr>
													<td class="width-80-percent">
														<div class="form-group">
														<?php 
														
											
														echo form_input(array('name'=>'reccurent_alternatives_pickupdatepicker[]','class'=>'form-control width-60-percent-with-margin-10','id'=>'reccurent_alternatives_pickupdatepicker0','placeholder'=>'Pick up Date and time ')).form_input(array('name'=>'reccurent_alternatives_pickuptimepicker[]','class'=>'form-control width-30-percent-with-margin-left-20','id'=>'reccurent_alternatives_pickuptimepicker0','placeholder'=>'Pick up time ')).br(3);
														?><p class="text-red float-left margin-top-less-15 margin-left-15-px date0 clear-error"></p><p class="text-red float-right margin-top-less-15 margin-right-90-px time0 clear-error"></p>
														 
														</div>
								
													</td>
													<td>
													
														<div class="float-left margin-15"><a class="btn btn-info btn-lg add-reccurent-dates" count="<?php echo$count; ?>">ADD</a></div>
													</td>
												</tr>
											</table>
											<div class="new-reccurent-date-textbox reccurent-slider">
											
								
											</div>
										</div>
										<div class="form-group">
												<?php $class="form-control";
							 
										echo $this->form_functions->populate_dropdown('driver',$drivers,$driver,$class,'driver',"Select driver"); ?>
										<p class="text-red float-left margin-left-15-px driver-error clear-error">
										</div>
										<div class="form-group">
												<a class="btn btn-success float-right btn-lg add-reccurent-trip" >SAVE RECCURRENT TRIP</a>
												<div class="hide-me"><input  class="book-reccurent-trip margin-top-10-px" name="book-reccurent-trip" type="submit"></div><div class="hide-me"> <input name="id" class="id" value="<?php echo $id; ?>" type="text"></div> 
										</div>
								</fieldset>	 <?php echo form_close(); ?>
							</div>
			</div><!-- modal -->
	</div>
	</div>
    <!-- end loading -->

