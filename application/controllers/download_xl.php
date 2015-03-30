<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Download_xl extends CI_Controller {

	public function __construct()
{
    parent::__construct();
    $this->load->helper('my_helper');
    $this->load->model('print_model');
    $this->load->model('driver_model');
    $this->load->model('vehicle_model');
    $this->load->model('customers_model');
    $this->load->model('user_model');
    $this->load->model('trip_booking_model');
    no_cache();

}
	public function session_check() {
	if(($this->session->userdata('isLoggedIn')==true ) && ($this->session->userdata('type')==FRONT_DESK)) {
		return true;
	} else {
		return false;
	}

	}    
	public function index(){
		$param1=$this->uri->segment(4);
        if($this->session_check()==true) {
		
			if($param1=='driver'){

				$this->driverXL();

			}else if($param1=='vehicle'){
			
				$this->vehicleXL();

			}else if($param1=='trips'){
				
				$this->tripsXL();

			}else if($param1=='customers'){
				
				$this->customersXL();

			}else if($param1=='tariffs'){
				
				$this->tariffsXL();

			}
			else{

				$this->notFound();
			}
		}else{
			
			$this->notAuthorized();
		}
	
    }
	
    public function driverXL(){
		//echo $this->input->get('name');
		//echo $this->input->get('age');
	$name= $this->input->get('name');
	$city= $this->input->get('city');
	$qry='select * from drivers where organisation_id='.$this->session->userdata('organisation_id');
		if(isset($name)&& $name!=null && isset($city)&& $city!=null){
		$qry.=' AND name LIKE "%'.$name.'%" AND district LIKE "%'.$city.'%" ';
		}
		if($name!=null && $city==null){
		$qry.=' AND name LIKE "%'.$name.'%" ';
		}
		if($name==null && $city!=null){
		$qry.=' AND district LIKE "%'.$city.'%" ';
		}
	
	$data['values']=$this->print_model->all_details($qry);
	$data['title']='Driver List| '.PRODUCT_NAME;
	$page='user-pages/print_listDrivers';
	$this->load_templates($page,$data);	

	}


	public function vehicleXL(){
		//echo $this->input->get('name');
		//echo $this->input->get('age');
	$qry='select * from vehicles where organisation_id='.$this->session->userdata('organisation_id');
	
	if(isset($_REQUEST['reg_num'])){
	$qry.= ' AND registration_number LIKE "%'.$_REQUEST['reg_num'].'%"';
	}
	if(isset($_REQUEST['vehicle_owner']) &&$_REQUEST['vehicle_owner'] >0){
	$qry.= ' AND vehicle_owner_id='.$_REQUEST['vehicle_owner'];
	}
	if(isset($_REQUEST['vehicle_ownership']) && $_REQUEST['vehicle_ownership']>0){
	$qry.= ' AND vehicle_ownership_types_id='.$_REQUEST['vehicle_ownership'];
	
	}
	
	if(isset($_REQUEST['vehicle_model']) && $_REQUEST['vehicle_model']>0){
	$qry.= ' AND vehicle_model_id='.$_REQUEST['vehicle_model'];
	
	}

	$data['values']=$this->print_model->all_details($qry);
	$vehicle_trips='';
	$vehicle_statuses='';
	for($i=0;$i<count($data['values']);$i++){
		$id=$data['values'][$i]['id'];
		$availability=$this->vehicle_model->getCurrentStatuses($id);
		if($availability==false){
		$vehicle_statuses[$id]='Available';
		$vehicle_trips[$id]=gINVALID;
		}else{
		$vehicle_statuses[$id]='OnTrip';
		$vehicle_trips[$id]=$availability[0]['id'];
		}
	}
	$data['vehicle_statuses']=$vehicle_statuses;
	$data['vehicle_trips']=$vehicle_trips;
	if(empty($data['values'])){
	$data['result']="No Results Found !";
	}
	for ($i=0;$i<count($data['values']);$i++){
	$id=$data['values'][$i]['vehicle_owner_id'];
	$details[$id]=$this->user_model->getOwnerDetails($id);
	
	}
	if(!empty($details)){
	$data['owner_details']=$details;
	}
	
	$tbl_arry=array('vehicle_models','vehicle_types','vehicle_owners','vehicle_makes','vehicle_ownership_types');
	$count=count($tbl_arry);
	for ($i=0;$i<$count;$i++){
	$result=$this->user_model->getArray($tbl_arry[$i]);
	if($result!=false){
	$data[$tbl_arry[$i]]=$result;
	}
	else{
	$data[$tbl_arry[$i]]='';
	}
	}
	$drivers=$this->driver_model->getDrivers();
	if($drivers!=false){
	$data['drivers']=$drivers;
	}else{
	$data['drivers']='';
	}
	$data['title']='List Vehicles | '.PRODUCT_NAME;
	$page='user-pages/print_listVehicles';
	
	$this->load_templates($page,$data);	

	}
	public function tripsXL(){
		//echo $this->input->get('name');
		//echo $this->input->get('age');
		
			
			if((isset($_REQUEST['pickupdate']) || isset($_REQUEST['dropdate']) || isset($_REQUEST['customers'])|| isset($_REQUEST['drivers'])|| 
				isset($_REQUEST['trip_status']))){
				$qry="SELECT T.id AS trip_id, T.booking_date AS booking_dates,T.pick_up_date AS pickup_date,T.pick_up_time AS pickuptime, T.trip_from AS trip_from,
				 T.trip_to AS trip_to,C.name as customer_name,C.mobile as mob,D.name as drivername,D.vehicle_registration_number as vehiclenumber,
				 TS.name AS tripstatus  FROM trips  AS T 
				 LEFT JOIN drivers AS D  ON D.id=T.driver_id LEFT JOIN  customers AS C ON C.id=T.customer_id 
				 LEFT JOIN trip_statuses AS TS ON TS.id=T.trip_status_id";
				$condition="";	
				if(isset($_REQUEST['trip_search'])){ 
				if($param2==''){
				$param2='0';
				}

				//driver search
				if($_REQUEST['vehicle_number']!=null){
				$data['vehiclenumber']= $_REQUEST['vehicle_number'];
				if($condition==""){
				$condition=' WHERE D.vehicle_registration_number Like "%'.$_REQUEST['vehicle_number'].'%"';
			}
				$like_arry['vehiclenumber']=$_REQUEST['vehicle_number'];
				} 



				
				//from date
				if($_REQUEST['trip_pick_date']!=null ){
				$data['trip_pick_date']=$_REQUEST['trip_pick_date'];
				//$date_now=date('Y-m-d');
				
				$where_arry['trip_pick_date']=$_REQUEST['trip_pick_date'];
				if($condition==""){
					$condition =' WHERE T.pick_up_date >= "'.$_REQUEST['trip_pick_date'].'"';




				}else{
					//$condition.=' AND T.pick_up_date >= "'.$date_now.'"';
				}
				
				} 
				//from date ends



				//to date starts
				if($_REQUEST['trip_drop_date']!=null && $_REQUEST['trip_pick_date']!=null){
				$data['trip_drop_date']=$_REQUEST['trip_drop_date'];
				//$date_now=date('Y-m-d H');

				$where_arry['trip_drop_date']=$_REQUEST['trip_drop_date'];
				if($condition==""){
					$condition =' WHERE T.pick_up_date <= "'.$_REQUEST['trip_drop_date'].'"';




				}else{
					$condition.=' AND T.pick_up_date <= "'.$_REQUEST['trip_drop_date'].'"';
				}
				
				} 
				//to date ends





			//
				if($_REQUEST['drivers']!=null && $_REQUEST['drivers']!=gINVALID){
				$data['driver_id']=$_REQUEST['drivers'];
				
				$where_arry['driver_id']=$_REQUEST['drivers'];
				if($condition==""){
					$condition =' WHERE T.driver_id = '.$data['driver_id'];
				}else{
					$condition.=' AND T.driver_id = '.$data['driver_id'];
				}
				}



				if($_REQUEST['customers']!=null && $_REQUEST['customers']!=gINVALID){
				$data['customer_id']=$_REQUEST['customers'];
				
				$where_arry['customer_id']=$_REQUEST['customers'];
				if($condition==""){
					$condition =' WHERE T.customer_id = '.$data['customer_id'];
				}else{
					$condition.=' AND T.customer_id = '.$data['customer_id'];
				}
				}






				if($_REQUEST['trip_status_id']!=null && $_REQUEST['trip_status_id']!=gINVALID ){
				$data['status_id']=$_REQUEST['trip_status_id'];
				//$date_now=date('Y-m-d H:i:s');
				$where_arry['dstatus']=$_REQUEST['trip_status_id'];

				if($condition==""){
					$condition =' WHERE T.trip_status_id='.$data['status_id'];
				}else{
					$condition.=' AND T.trip_status_id='.$data['status_id'];
				}
				}

		
				$qry.=' order by CONCAT(T.pick_up_date," ",T.pick_up_time) ASC';
			
			
			$data['trips']=$this->print_model->all_details($qry);
			if(empty($data['trips']) || $data['trips']==false){
				$data['result']="No Results Found !";
			}
			$data['status_class']=array(TRIP_STATUS_PENDING=>'label-warning',TRIP_STATUS_CONFIRMED=>'label-success',TRIP_STATUS_CANCELLED=>'label-danger',TRIP_STATUS_CUSTOMER_CANCELLED=>'label-danger',TRIP_STATUS_ON_TRIP=>'label-primary',TRIP_STATUS_TRIP_COMPLETED=>'label-success',TRIP_STATUS_TRIP_PAYED=>'label-info',TRIP_STATUS_TRIP_BILLED=>'label-success');
			$data['trip_statuses']=$this->user_model->getArray('trip_statuses'); 
			
			$data['title']="Trips | ".PRODUCT_NAME;  
			$page='user-pages/print_listTrips';
		    $this->load_templates($page,$data);
	}

	}
	}
	public function load_templates($page='',$data=''){
	if($this->session_check()==true) {
   	$this->load->view($page,$data);
   } 
	else{
			$this->notAuthorized();
		}

    }  
    
	   public function customersXL(){
	
		
				$qry='select * from customers where organisation_id='.$this->session->userdata('organisation_id');
				
				 if(isset($_REQUEST['cust_name'])&& $_REQUEST['cust_name']!=null){
				
				$qry.=' AND name Like "%'.$_REQUEST['cust_name'].'%"';
				
				}else if(isset($_REQUEST['cust_mobile'])&& $_REQUEST['cust_mobile']!=null){
				
				$qry.=' AND mobile Like "%'.$_REQUEST['cust_mobile'].'%"';

				}
				if(isset($_REQUEST['cust_type']) &&$_REQUEST['cust_type']!=gINVALID){
					
					$qry.=' AND customer_type_id ="'.$_REQUEST['cust_type'].'"';
				
				}
				if(isset($_REQUEST['cust_group']) && $_REQUEST['cust_group']!=gINVALID){
					
					$qry.=' AND customer_group_id ="'.$_REQUEST['cust_group'].'"';
					
				}
			
			
			$data['customers']=$this->print_model->all_details($qry);
			//print_r($data['customers']);exit;
			for($i=0;$i<count($data['customers']);$i++){
					$id=$data['customers'][$i]['id'];
					$availability=$this->customers_model->getCurrentStatuses($id);
					if($availability==false){
					$customer_statuses[$id]='NoBookings';
					$customer_trips[$id]=gINVALID;
					}else{
					$customer_statuses[$id]='OnTrip';
					$customer_trips[$id]=$availability[0]['id'];
					}
				}
				$data['customer_statuses']=$customer_statuses;
				$data['customer_trips']=$customer_trips;	
			if(empty($data['customers']) || $data['customers']==false){
				$data['result']="No Results Found !";
			}
			$tbl_arry=array('customer_types','customer_groups');
	
			for ($i=0;$i<count($tbl_arry);$i++){
			$result=$this->user_model->getArray($tbl_arry[$i]);
			if($result!=false){
			$data[$tbl_arry[$i]]=$result;
			}
			else{
			$data[$tbl_arry[$i]]='';
			}
			}
			$data['title']="Customers | ".PRODUCT_NAME;  
			$page='user-pages/print_Customers';
		    $this->load_templates($page,$data);
	

	}
    
	public function notAuthorized(){
	$data['title']='Not Authorized | '.PRODUCT_NAME;
	$page='not_authorized';
	$this->load->view('admin-templates/header',$data);
	$this->load->view('admin-templates/nav');
	$this->load->view($page,$data);
	$this->load->view('admin-templates/footer');
	
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
	
	public function tariffsXL(){
			
			$data['vehicle_models']=$this->print_model->getModels();
	
			
		
				$qry='SELECT TM.id,TM.title,TM. vehicle_ac_type_id,TM.minimum_kilometers,T.vehicle_model_id,T.rate FROM tariff_masters As TM LEFT JOIN tariffs As T ON TM.id=T.tariff_master_id where TM.organisation_id='.$this->session->userdata('organisation_id');
				
				 if(isset($_REQUEST['title'])&& $_REQUEST['title']!=null){
				
				$qry.=' AND TM.title Like "%'.$_REQUEST['title'].'%"';
				
				}
				if(isset($_REQUEST['trip_model']) &&$_REQUEST['trip_model']!=gINVALID){
					
					$qry.=' AND TM.trip_model_id ="'.$_REQUEST['trip_model'].'"';
				
				}
				if(isset($_REQUEST['ac_type']) && $_REQUEST['ac_type']!=gINVALID){
					
					$qry.=' AND TM.vehicle_ac_type_id ="'.$_REQUEST['ac_type'].'"';
					
				}
			
			
			$data['res']=$this->print_model->all_details($qry);
				$count=count($data['res']);
				$tm= $data['res'];
				//echo '<pre>';print_r($tm);echo '</pre>';exit;
				for($i=0;$i<$count;$i++){
				$values[$tm[$i]['id']][$tm[$i]['vehicle_ac_type_id']][$tm[$i]['vehicle_model_id']]['rate']=$tm[$i]['rate'];
				$values[$tm[$i]['id']][$tm[$i]['vehicle_ac_type_id']][$tm[$i]['vehicle_model_id']]['minimum_kilometers']=$tm[$i]['minimum_kilometers'];
				$values[$tm[$i]['id']]['title']=$tm[$i]['title'];
				$values[$tm[$i]['id']]['model']=$tm[$i]['vehicle_model_id'];
				}
				$data['tariffs']=$values;
		//echo '<pre>';	print_r($data['tariffs']);echo '</pre>';exit;
			if(empty($data['tariffs']) || $data['tariffs']==false){
				$data['result']="No Results Found !";
			}
		
			$data['title']="Tarrifs | ".PRODUCT_NAME;  
			$page='user-pages/print_tariffmaster';
		    $this->load_templates($page,$data);
	

	}

}
