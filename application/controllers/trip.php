<?php 
class Trip extends CI_Controller {
	public function __construct()
		{
		parent::__construct();
		$this->load->model("settings_model");
		$this->load->helper('my_helper');
		$this->load->model("driver_model");
		$this->load->model("customers_model");
		$this->load->model("trip_booking_model");
		$this->load->model("user_model");
		no_cache();

		}
	public function index($param1 ='',$param2='',$param3=''){
	
		if($this->session_check()==true) {
	
		$tbl=array('trip-models'=>'trip_models','trip-statuses'=>'trip_statuses','booking-sources'=>'booking_sources','trip-expense'=>'trip_expense_type');
			if($param1=='getDescription') {
			$this->getDescription();
			}else if($param1=='view') {
		
			$this->tripView($param2);
			
			}else if($param1=='complete') {
		
			$this->tripComplete($param2,$param3);
			
			}
			if($param1) {
			
				if(isset($_REQUEST['add'])){
					$this->add($tbl,$param1);
					}else if(isset($_REQUEST['edit'])){
					$this->edit($tbl,$param1);
					}else if(isset($_REQUEST['delete'])){
					$this->delete($tbl,$param1);
					}else{
					$this->notFound();
					}
		}
		
	}
		
		else{
			$this->notAuthorized();
			}
	}
	public function notFound(){
		if($this->session_check()==true) {
		 $this->output->set_status_header('404'); 
		 $data['title']="Not Found";
      	 $page='not_found';
         $this->load_templates($page,$data);
		}else{
			$this->notAuthorized();
	}
	}
	
	public function add($tbl,$param1){
	
	if(isset($_REQUEST['select'])&& isset( $_REQUEST['description'])&& isset($_REQUEST['add'])){ 
			
		    $data['name']=$this->input->post('select');
			$data['description']=$this->input->post('description');
			$data['organisation_id']=$this->session->userdata('organisation_id');
			$data['user_id']=$this->session->userdata('id');
			
	        $this->form_validation->set_rules('select','Values','trim|required|min_length[2]|xss_clean');
			$this->form_validation->set_rules('description','Description','trim|required|min_length[2]|xss_clean');
		if($this->form_validation->run()==False){
         redirect(base_url().'organization/front-desk/settings');
		}
      else {
		$result=$this->settings_model->addValues($tbl[$param1],$data);
		if($result==true){
					$this->session->set_userdata(array('dbSuccess'=>'Details Added Succesfully..!'));
				    $this->session->set_userdata(array('dbError'=>''));
				     redirect(base_url().'organization/front-desk/settings');
						}
			}
							}
	}
	public function edit($tbl,$param1){
	if(isset($_REQUEST['select_text'])&& isset( $_REQUEST['description'])&& isset($_REQUEST['edit'])){ 
			
		    $data['name']=$this->input->post('select_text');
			$data['description']=$this->input->post('description');
			$id=$this->input->post('id_val');
	        $this->form_validation->set_rules('select_text','Values','trim|required|min_length[2]|xss_clean');
			$this->form_validation->set_rules('description','Description','trim|required|min_length[2]|xss_clean');
		if($this->form_validation->run()==False){
       // redirect(base_url().'user/settings');
       redirect(base_url().'organization/front-desk/settings');
		}
      else {
		$result=$this->settings_model->updateValues($tbl[$param1],$data,$id);
		if($result==true){
					$this->session->set_userdata(array('dbSuccess'=>'Details Updated Succesfully..!'));
				    $this->session->set_userdata(array('dbError'=>''));
				  //  redirect(base_url().'user/settings');
				  redirect(base_url().'organization/front-desk/settings');
						}
			}
							}
	
	}
	
	public function delete($tbl,$param1){
	if(isset($_REQUEST['delete'])){ 
	
	$id=$this->input->post('id_val');
	        $this->form_validation->set_rules('select_text','Values','trim|required|min_length[2]|xss_clean|alpha_numeric');
			//$this->form_validation->set_rules('select','Values','trim|required|min_length[2]|xss_clean|alpha_numeric');
			$this->form_validation->set_rules('description','Description','trim|required|min_length[2]|xss_clean|alpha_numeric');
		if($this->form_validation->run()==False){
        redirect(base_url().'organization/front-desk/settings');
		}
      else {
		$result=$this->settings_model->deleteValues($tbl[$param1],$id);
		if($result==true){
					$this->session->set_userdata(array('dbSuccess'=>'Details Deleted Succesfully..!'));
				    $this->session->set_userdata(array('dbError'=>''));
				    redirect(base_url().'organization/front-desk/settings');
						}
			}
	}
	}
	
	public function tripComplete($trip_id,$pagination=''){
	$data=array('trip_status_id'=>TRIP_STATUS_TRIP_COMPLETED);
	$res=$this->trip_booking_model->updateTrip($data,$trip_id);
	 redirect(base_url().'organization/front-desk/trips/'.$pagination);
	
	}	

	public function session_check() {
	if(($this->session->userdata('isLoggedIn')==true ) && ($this->session->userdata('type')==FRONT_DESK)) {
		return true;
		} else {
		return false;
		}
	} 
	public function tripView($param2){
	if($this->session_check()==true) {
	$trip_id=$param2;
	
	
	$tbl_arry=array('trips','drivers');
	for ($i=0;$i<count($tbl_arry);$i++){
			$result=$this->user_model->getArray($tbl_arry[$i]);
			if($result!=false){
			$data[$tbl_arry[$i]]=$result;
			}
			else{
			$data[$tbl_arry[$i]]='';
			}
	}
	/*$customer_types=$data['customer_types'];
	$trip_models=$data['trip_models'];
	$booking_sources=$data['booking_sources'];
	$vehicle_types=$data['vehicle_types'];
	$vehicle_beacon_light_options=$data['vehicle_beacon_light_options'];
	$vehicle_seating_capacity=$data['vehicle_seating_capacity'];
	$vehicle_ac_types=$data['vehicle_ac_types'];
	$vehicles=$this->trip_booking_model->getVehiclesArray($condition='');*/

	$drivers=$this->driver_model->getDriversArray($condition='');

	
	$conditon = array('id'=>$trip_id);
	$result=$this->trip_booking_model->getDetails($conditon);
	$result=$result[0];
	$data1['trip_id']=$result->id;
	
	//$dbdata=array('id'=>$result->customer_id);	

	//$customer 	=	$this->customers_model->getCustomerDetails($dbdata);
	//$customer=$customer[0];


	$data1['pick_up_date']		=	$result->pick_up_date;
	//$data1['drop_date']		=	$result->drop_date;
	$data1['pick_up_time']		=	$result->pick_up_time;
	//$data1['drop_time']		=	$result->drop_time;
	
	//$data1['vehicle_type']			=	$vehicle_types[$result->vehicle_type_id];
	//$data1['vehicle_ac_type']		=	$vehicle_ac_types[$result->vehicle_ac_type_id];


	//$data1['vehicle']				=	$vehicles[$result->vehicle_id];
	$data1['driver']				=	$drivers[$result->driver_id];
	
		$page='front-desk/trips';
		$data1['title']="Trip | ".PRODUCT_NAME;  
		$this->load_templates($page,$data1);
		}else{
				$this->notAuthorized();
			}
	}
	public function load_templates($page='',$data=''){
	if($this->session_check()==true) {
		$this->load->view('admin-templates/header',$data);
		$this->load->view('admin-templates/nav');
		$this->load->view($page,$data);
		$this->load->view('admin-templates/footer');
		}
	else{
			$this->notAuthorized();
		}
	}
		public function getDescription(){
		$id=$_REQUEST['id'];
		$tbl=$_REQUEST['tbl'];
		$res=$this->settings_model->getValues($id,$tbl);
		echo $res[0]['id']." ".$res[0]['description']." ".$res[0]['name'];
		}

	public function notAuthorized(){
	$data['title']='Not Authorized | '.PRODUCT_NAME;
	$page='not_authorized';
	$this->load->view('admin-templates/header',$data);
	$this->load->view('admin-templates/nav');
	$this->load->view($page,$data);
	$this->load->view('admin-templates/footer');
	
	}
}
