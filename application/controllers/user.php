<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
    parent::__construct();
    $this->load->helper('my_helper');
	$this->load->model('user_model');
	$this->load->model('driver_model');
	$this->load->model('customers_model');
	$this->load->model('trip_booking_model');
	$this->load->model('customers_model');
    $this->load->model('tarrif_model');
	$this->load->model('device_model');
	 $this->load->model('vehicle_model');
	 $this->load->model('driver_payment_model');

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
		$param1=$this->uri->segment(2);
		$param2=$this->uri->segment(3);
		$param3=$this->uri->segment(4);
       	if($param1==''){
		if($this->session_check()==true) {
		
			$this->home();
		
		}else{

			$this->checking_credentials();

		}
		}elseif($param1=='login'){
		$this->checking_credentials();
		}elseif($param1=='profile'){
		$this->profile();
		}elseif($param1=='changepassword'){
		$this->changePassword();
		}
		elseif($param1=='settings'){
		
		
			$this->settings();
		
		}elseif($param1=='trip-booking'){

			$this->ShowBookTrip($param2);
		
		}elseif($param1=='driver-notifications'){

		
			$this->DriverNotifications($param2);
		
		}elseif($param1=='trips'){
		
			$this->Trips($param2);
		

		}elseif($param1=='driver-payments'){
		
		
			$this->DriverPayments($param2,$param3);
		
		}
		elseif($param1=='drivers-payments'){
		
		
			$this->DriversPayments($param2);
		
		}

		elseif($param1=='customer'){

		
		
			$this->Customer($param2);
		

		}elseif($param1=='customerTrips'){

		
		
			$this->CustomerTrips($param2);
		

		}elseif($param1=='customers'){
		
			$this->Customers($param2);
		

		}elseif($param1=='setup_dashboard'){

		
		
			$this->setup_dashboard();
		

		}elseif($param1=='getNotifications'){
			
			
			$this->getNotifications();
		
		}else if($param1=='tariff'&& ($param2== '' || is_numeric($param2))){
	
		
				$this->tarrif($param1,$param2);
		
		}
		elseif($param1=='driver'){

		
		
				$this->ShowDriverView($param2);
		
		}elseif($param1=='find-distance'){

		
		
				$this->findDistance();
		
		}elseif($param1=='list-driver'&&($param2== ''|| is_numeric($param2))){
		
		
		
				$this->ShowDriverList($param1,$param2);
		
		}elseif($param1=='sendNotifications'){
		
		
				$this->sendNotifications();
		
		}elseif($param1=='driver-profile'&&($param2== ''|| is_numeric($param2))){
		
		
				$this->ShowDriverProfile($param1,$param2);
		
		}else{
			$this->notFound();
		}
		
	
    }
	public function home(){
		$data['title']="Home | ".PRODUCT_NAME;	
		$page='user-pages/user_home';
		$this->load_templates($page,$data);
	}

	public function checking_credentials() {
	if($this->session_check()==true) {
        	
				
					 redirect(base_url().'front-desk');
					
				 
		} else if(isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
			 
			 $username=$this->input->post('username');
			 $this->user_model->LoginAttemptsChecks($username);
			 if( $this->session->userdata('isloginAttemptexceeded')==false){
			 $this->form_validation->set_rules('username','Username','trim|required|min_length[3]|max_length[20]|xss_clean');
			 $this->form_validation->set_rules('password','Password','trim|required|min_length[3]|max_length[20]|xss_clean');
			 } else {
			 $captcha = $this->input->post('captcha');
			 $this->form_validation->set_rules('captcha', 'Captcha', 'trim|required|callback_captcha_check');
			 $this->form_validation->set_rules('username','Username','trim|required|min_length[3]|max_length[20]|xss_clean');
			 $this->form_validation->set_rules('password','Password','trim|required|min_length[3]|max_length[20]|xss_clean');
			}
			 if($this->form_validation->run()!=False){
			 $username = $this->input->post('username');
		   	 $pass  = $this->input->post('password');

		     if( $username && $pass && $this->user_model->UserLogin($username,$pass)) {
				 if($this->session->userdata('loginAttemptcount') > 1){
		       	 $this->user_model->clearLoginAttempts($username);
				 }
				 if($this->session->userdata('type')==FRONT_DESK){	
					 
					 	redirect(base_url().'front-desk');
					
				 }
				 
		        
		    } else {
				if($this->mysession->get('password_error')!='' ){
				$ip_address=$this->input->ip_address();
		        $this->user_model->recordLoginAttempts($username,$ip_address);
				}
		        $this->show_login();
		    }
			} else {

		 	$this->show_login();
			}
		} else {

		 	$this->show_login();
		}
	}
	
	
	public function show_login() 
	{  
		 $data['title']="Login | ".PRODUCT_NAME;	
		$this->load->view('user-pages/login',$data);
		
    }


	public function settings() {
	if($this->session_check()==true) {
	$tbl_arry=array('driver_statuses','customer_statuses','trip_statuses','trip_types','notification_types','notification_statuses','notification_view_statuses');
	
	for ($i=0;$i<count($tbl_arry);$i++){
	$result=$this->user_model->getArray($tbl_arry[$i]);
	if($result!=false){
	$data[$tbl_arry[$i]]=$result;
	}
	else{
	$data[$tbl_arry[$i]]='';
	}
	}
	$data['title']="Settings | ".PRODUCT_NAME;  
	$page='user-pages/settings';
	$this->load_templates($page,$data);
	}
	else{
			$this->notAuthorized();
		}
	}
	public function tarrif($param1,$param2){
	if($this->session_check()==true) {
	$tbl_arry=array();
	for ($i=0;$i<count($tbl_arry);$i++){
	$result=$this->user_model->getArray($tbl_arry[$i]);
	if($result!=false){
	$data[$tbl_arry[$i]]=$result;
	
	}
	else{
	$data[$tbl_arry[$i]]='';
	}
	}
		//start
		$condition='';
	    $per_page=10;
	   
	if(isset($_REQUEST['search'])){
		$data['search_from_date']=$fdate = $this->input->post('search_from_date');
		$data['search_to_date']=$tdate = $this->input->post('search_to_date');
		//valid date check
		/*if(!$this->date_check($fdate)){
	$this->mysession->set('Err_from_date','Invalid From Date for Tariff Search!');
	}
		if(!$this->date_check($tdate)){
	$this->mysession->set('Err_to_date','Invalid To Date for Tariff Search!');
	}*/
		if($fdate!=''&& $tdate==''){
		$tdate=date('Y-m-d');
		}
	 if(($fdate=='')&& ($tdate =='')){
	 $this->session->set_userdata('Date','Search with value');
	 redirect(base_url().'front-desk/tarrif');
		}
		else {
		//show search results
		
	if((isset($_REQUEST['search_from_date']) || isset($_REQUEST['search_to_date']))&& isset($_REQUEST['search'])){
	if($param2==''){
	$param2='0';
	} 
	if(($_REQUEST['search_from_date']>= $tdate)){
	$this->session->set_userdata('Date_err','Not a valid search');
	}
	if($_REQUEST['search_from_date']!=null){
	
	$where_arry['from_date >=']=$_REQUEST['search_from_date'];
	}
	if($_REQUEST['search_to_date']!=null){
	$where_arry['to_date <=']= $_REQUEST['search_to_date'];
	}
	/*else{
	$where_arry['to_date <=']= $tdate;
	}*/
	
	$this->mysession->set('condition',array("where"=>$where_arry));
	
	//print_r($where_arry);
	}
	}
	}
	    
		$tbl="tariffs";
		if(is_null($this->mysession->get('condition'))){ 
			if(isset($where_arry)){
			$this->mysession->set('condition',array("where"=>$where_arry));
			}
		}
		$baseurl=base_url().'front-desk/tarrif/';
		$uriseg ='4';
		
		
		$p_res=$this->mypage->paging($tbl,$per_page,$param2,$baseurl,$uriseg,$model='');
		if($param2==''){
		$this->mysession->delete('condition');
		}
	
	$data['values']=$p_res['values'];//print_r($data['values']);exit;	
	if(empty($data['values'])){
	$data['result']="No Results Found !";
	}
	$data['page_links']=$p_res['page_links'];
	//end
	//$data['allDetails']=$this->user_model->getAll_tarrifDetails();
	$data['title']="Tariff | ".PRODUCT_NAME; 
	$page='user-pages/tariff';
	$this->load_templates($page,$data);
	
	}
	else{
			$this->notAuthorized();
		}
	}
	

	public function Device($param2){
		if($this->session_check()==true) {
	
		$condition='';
	    $per_page=2;
	    $like_arry='';
		$data['s_imei']='';
		$data['s_sim_no']='';
	
		
	if((isset($_REQUEST['s_imei']) || isset($_REQUEST['s_sim_no'])) && isset($_REQUEST['search'])){
	if($param2==''){
	$param2=0;
	}
	
	if($_REQUEST['s_imei']!=null){
	$data['s_imei']=$_REQUEST['s_imei'];
	$like_arry['imei']=$_REQUEST['s_imei'];
	}
	if($_REQUEST['s_sim_no']!=null){
	$data['s_sim_no']=$_REQUEST['s_sim_no'];
	$like_arry['sim_no'] = $_REQUEST['s_sim_no'];
	}
	
	$this->mysession->set('condition',array("like"=>$like_arry));
	}
	if($this->mysession->get('condition')){
		$this->mysession->set('condition',array("like"=>$like_arry));
	}
	
	    
		$tbl="devices";
		$baseurl=base_url().'front-desk/device/';
		$uriseg ='4';
		
		
		$p_res=$this->mypage->paging($tbl,$per_page,$param2,$baseurl,$uriseg,$model='');
		if($param2==''){
		$this->session->set_userdata('condition','');
		}
		
	$data['values']=$p_res['values'];
	if(empty($data['values'])){
	$data['result']="No Results Found !";
	}
	$data['page_links']=$p_res['page_links'];
	$devices=$this->device_model->getReg_Num();
	if($devices!=false){
	$data['devices']=$devices;
	}else{
	$data['devices']='';
	}
	$data['title']="Device | ".PRODUCT_NAME; 
	$page='user-pages/device';
	$this->load_templates($page,$data);
	
	}
	else{
			$this->notAuthorized();
		}



	}




	public function ShowBookTrip($trip_id =''){ 
	if($this->session_check()==true) {
	if($this->mysession->get('post')!=NULL){
		$data=$this->mysession->get('post');
		if($this->session->userdata('customer_id')==null){
			$data['added_customer']='false';
		}else{
			$data['added_customer']='true';
		}
		if($data['id']!=gINVALID) {
			$condition=array('id'=>$data['id']);
			$values=$this->trip_booking_model->getDetails($condition);
			$data['trip_status_id']=$values[0]->trip_status_id;
		}else{
			$data['trip_status_id']=gINVALID;
		}
		$this->mysession->delete('post');
	}else if($trip_id!=''){
	$condition=array('id'=>$trip_id);
	$values=$this->trip_booking_model->getDetails($condition);
	if($values!=false){
		

	$data['id']=$trip_id;
	if($values[0]->customer_id!=gINVALID){
	$condition=array('id'=>$values[0]->customer_id);
		$customers=$this->customers_model->getCustomerDetails($condition);//print_r($customers);exit;
		if(count($customers)>0){
			$data['name']=$customers[0]['name'];
			$data['mobile']=$customers[0]['mobile'];
			$this->session->set_userdata('customer_id',$customers[0]['id']);
			$this->session->set_userdata('customer_name',$customers[0]['name']);
			$this->session->set_userdata('customer_mobile',$customers[0]['mobile']);
		}else{
			$data['name']='';
			$data['mobile']='';
		}
	}
	
	$data['trip_from']=$values[0]->trip_from;
	$data['trip_to']=$values[0]->trip_to;
	$data['trip_from_landmark']=$values[0]->trip_from_landmark;
	$data['trip_to_landmark']=$values[0]->trip_to_landmark;
	$data['pick_up_date']=$values[0]->pick_up_date;
	$data['pick_up_time']=$values[0]->pick_up_time;	
	$data['trip_from_lat']=$values[0]->trip_from_lat;	
	$data['trip_to_lat']=$values[0]->trip_to_lat;
	$data['trip_from_lng']=$values[0]->trip_from_lng;
	$data['trip_to_lng']=$values[0]->trip_to_lng;
	$data['driver_id']=$values[0]->driver_id;
	$data['trip_status_id']=$values[0]->trip_status_id;
	$data['localtrip']=$values[0]->local_trip;
	$data['radius']=1;
	$data['distance_in_km_from_web']=$values[0]->distance_in_km_from_web;
	$data['added_customer']='true';
	$data['roundtrip']	=$values[0]->round_trip;
	}else{
	$data['id']=gINVALID;
	$data['driver_id']=gINVALID;
	$data['name']='';
	$data['mobile']='';
	$data['trip_from']='';
	$data['trip_to']='';
	$data['trip_from_landmark']='';
	$data['trip_to_landmark']='';
	$data['pick_up_date']=date('Y-m-d');;
	$data['pick_up_time']='';	
	$data['trip_from_lat']='';	
	$data['trip_to_lat']='';
	$data['trip_from_lng']='';
	$data['trip_to_lng']='';
	$data['radius']=1;
	$data['distance_in_km_from_web']='';
	$data['added_customer']='false';
	$data['trip_status_id']=gINVALID;
	$data['roundtrip']	='f';
	$data['localtrip']='f';
	}
	}else{
	$data['id']=gINVALID;
	$data['driver_id']=gINVALID;
	$data['name']='';
	$data['mobile']='';
	$data['trip_from']='';
	$data['trip_to']='';
	$data['trip_from_landmark']='';
	$data['trip_to_landmark']='';
	$data['pick_up_date']=date('Y-m-d');;
	$data['pick_up_time']='';	
	$data['trip_from_lat']='';	
	$data['trip_to_lat']='';
	$data['trip_from_lng']='';
	$data['trip_to_lng']='';
	$data['radius']=1;
	$data['distance_in_km_from_web']='';
	$data['added_customer']='false';
	$data['trip_status_id']=gINVALID;
	$data['roundtrip']	='f';
	$data['localtrip']='f';
	}
	$tbl_arry=array('drivers');
	
	for ($i=0;$i<count($tbl_arry);$i++){
	$result=$this->user_model->getArray($tbl_arry[$i]);
	if($result!=false){
	$data[$tbl_arry[$i]]=$result;
	}
	else{
	$data[$tbl_arry[$i]]='';
	}
	}
	$conditon =array('trip_status_id'=>TRIP_STATUS_PENDING,'CONCAT(pick_up_date," ",pick_up_time) >='=>date('Y-m-d H:i'));
	$orderby = ' CONCAT(pick_up_date,pick_up_time) ASC';
	$data['notification']=$this->trip_booking_model->getDetails($conditon,$orderby);
	$data['customers_array']=$this->customers_model->getArray();
	if($data['id']!=gINVALID){
		$data['list_of_drivers']=$this->trip_booking_model->getNotifiedListOfDrivers($data['id']);

	}else{
		$data['list_of_drivers']='';
	}
	$data['driver']='';
	$data['title']="Trip Booking | ".PRODUCT_NAME;  
	$page='user-pages/trip-booking';
	$this->load_templates($page,$data);
	
	}
	else{
			$this->notAuthorized();
		}
	}

	public function getAvailableVehicle($available){
	
	
	return $this->trip_booking_model->selectAvailableVehicles($available);

	}

	public function tariffSelecter($data){
	
	return $this->tarrif_model->selectAvailableTariff($data);

	

	}

////////////////////////////////////////////////////////////////////////////////
	public function DriverPayments($param2,$param3=''){
		if($this->session_check()==true) {
			
			$driver_id=$param2;
			if(isset($param3) && $param3!=''){
			$payment_id=$param3;
			$data['payment_id']=$param3;
			$payment=$this->driver_payment_model->getPayment($payment_id);
		  	$data['payment_type']=$payment[0]['voucher_type_id'];
			if($data['payment_type']==INVOICE){
				$data['amount']=$payment[0]['dr_amount'];
			}else if($data['payment_type']==PAYMENT || $data['payment_type']==RECIEPT){
				$data['amount']=$payment[0]['cr_amount'];
			}
			$data['payment_date']=$payment[0]['payment_date'];
			
			}else{
			$data['payment_id']=gINVALID;
			$data['payment_type']='';
			$data['payment_date']='';
			$data['amount']='';
			}
			$tbl_arry=array('drivers','trip_statuses');
			for ($i=0;$i<count($tbl_arry);$i++){
					$result=$this->user_model->getArray($tbl_arry[$i]);
					if($result!=false){
					$data[$tbl_arry[$i]]=$result;
					}
					else{
					$data[$tbl_arry[$i]]='';
					}
			}	
			// print_r($data);exit;
			//$conditon = array('id'=>$trip_id); print_r($condition); exit;
			$drivers=$this->driver_model->getDetails($condition=''); //print_r($drivers); 
			$conditon = array('id'=>$driver_id);
			$result=$this->trip_booking_model->getDetails($conditon);
			

	$qry='SELECT (SUM(DP.cr_amount)) AS Creditamount,(SUM(DP.dr_amount)) AS Debitamount, VT.name as vouchertype,DP.voucher_number as voucher_number,
	DP.payment_date as date,DP.period as Period,DP.id as payment_id,DP.voucher_type_id as Voucher_type_id,D.name as Drivername,D.driver_status_id as Driverstatus_id,DP.driver_id as Driver_id FROM driver_payment AS DP 
	LEFT JOIN drivers AS D ON D.id=DP.driver_id LEFT JOIN voucher_types VT ON VT.id=DP.voucher_type_id WHERE D.id="'.$driver_id.'" 
	AND DP.voucher_type_id <> "'.RECEIPT.'"';


	$parameters='';

	$condition="";	
	if(isset($_GET['trip_search'])){ 
	if($param2==''){
		$param2='0';
	}

	
//Search period
	if(isset($_GET['periods']) && $_GET['periods']!=null){
	$data['period']=$_GET['periods'];
	$condition.=' AND DP.period = '.$data['period'];
	$parameters.='?periods='.$_GET['periods'];
	
	}
//Search period ends

	
	} 

	
	$baseurl=base_url().'front-desk/list-driver/'.$driver_id;
	$uriseg ='4';
	$qry.=$condition;
	$qry.=' GROUP BY DP.created ORDER BY DP.period DESC';
	$p_res=$this->mypage->paging($tbl='',$per_page=25,$offset=0,$baseurl,$uriseg,$custom='yes',$qry,$parameters);
	//print_r($p_res);
	$data['values']=$p_res['values']; //print_r($data['values']); exit;
	//$data['values']='';
	//print_r($data['values']);exit;
	$driver_trips='';
	$driver_statuses='';
	$res=$this->driver_payment_model->getDriverpaymentReceipt($param2);
	//$data['values']=$res['values']; print_r($data['values']); exit;
	//echo "<pre>"; print_r($res);echo "<pre>"; exit;
	for($i=0;$i<count($data['values']);$i++){
		//$id=$data['values'][$i]['id'];
		//print_r($data['values']);exit;
		$id=1;
		$availability=$this->driver_model->getCurrentStatuses($id);
		if($availability==false){
		$driver_statuses[$id]='Available';
		$driver_trips[$id]=gINVALID;
		}else{
		$driver_statuses[$id]='OnTrip';
		$driver_trips[$id]=$availability[0]['id'];
		}
	}
	$data['driver_statuses']=$driver_statuses;
	$data['driver_trips']=$driver_trips;
	if(empty($data['values'])){
				$data['result']="No Results Found !";
	}
	$data['trips']=$data['values'];

	
			/* search condition ends*/
			$data['title']="Driver Payments | ".PRODUCT_NAME;  
			$page='user-pages/driver-payments';
			$data['driver_id']=$driver_id;
			$data['val']=$res; //print_r($data['val']);exit;
		    $this->load_templates($page,$data);
		    }else{
				$this->notAuthorized();
			}
		
	}	
////////////////////////////////////////////////////////////////////////////////	

	////////////////////////////////////////////////////////////////////////////////
	public function DriversPayments($param2){
		if($this->session_check()==true) {
			/* */
			$trip_id=$param2;
			$tbl_arry=array('drivers','trip_statuses');
			for ($i=0;$i<count($tbl_arry);$i++){
					$result=$this->user_model->getArray($tbl_arry[$i]);
					if($result!=false){
					$data[$tbl_arry[$i]]=$result;
					}
					else{
					$data[$tbl_arry[$i]]='';
					}
			}	
			// print_r($data);exit;
			//$conditon = array('id'=>$trip_id); print_r($condition); exit;
			$drivers=$this->driver_model->getDetails($condition=''); //print_r($drivers); 
			$conditon = array('id'=>$trip_id);
			$result=$this->trip_booking_model->getDetails($conditon);
			
			/* search condition starts */
				//for search
	//$qry="SELECT * FROM trips AS T LEFT JOIN drivers AS D  ON D.id=T.driver_id LEFT JOIN  customers AS C ON C.id=T.customer_id";

	/*$qry="SELECT DS.name as driverstatus,D.id as driverid,D.name,SUM(DP2.dr_amount) as Current_amount, SUM(DP.cr_amount) as current,SUM(DP.dr_amount) as debit ,
	SUM(DP.cr_amount+DP.dr_amount) as total FROM drivers as D LEFT JOIN driver_payment AS DP ON DP.driver_id=D.id,
	LEFT JOIN driver_payment AS DP2 ON DP2.driver_id=D.id  
	LEFT JOIN driver_statuses as DS ON DS.ID=D.driver_status_id WHERE DP.period<month(NOW()) AND DP2.period=month(NOW()) AND DP.year<=year(NOW()) AND 
	DP.voucher_type_id <> '".RECEIPT."' GROUP BY D.id DESC"; */
	$data['vehiclenumber']='';
	$data['driver_id']='';
	$data['trip_pick_date']='';
	$parameters='';
	if(isset($_GET['trip_pick_date'])){
	$period=$_GET['trip_pick_date'].' 00:00:00';
	$data['trip_pick_date']=$_GET['trip_pick_date'];
	$parameters.='?trip_pick_date='.$_GET['trip_pick_date'];
	}else{
	$period='NOW()';
	}
	

	$qry="SELECT DS.name as driverstatus,D.id as driverid,D.name as Drivername,count(T.id) as no_of_trips,
	SUM(CASE WHEN DP.period=month('".$period."') THEN DP.dr_amount ELSE 0 END) AS Current_Invoice,
	SUM(CASE WHEN DP.period < month('".$period."') THEN DP.dr_amount ELSE 0 END) AS Old_Invoice,
	SUM(CASE WHEN DP.period=month('".$period."') THEN DP.cr_amount ELSE 0 END) AS Current_Payment,
	SUM(CASE WHEN DP.period < month('".$period."') THEN DP.cr_amount ELSE 0 END) AS Old_Payment
	 FROM drivers as D 
	LEFT JOIN driver_payment AS DP ON DP.driver_id=D.id LEFT JOIN driver_statuses as DS ON DS.id=D.driver_status_id LEFT JOIN trips as T ON T.driver_id=D.id
	WHERE DP.period<=month('".$period."') AND DP.year<=year('".$period."') AND DP.voucher_type_id <>  '".RECEIPT."' AND month(T.pick_up_date)=month('".$period."') AND year(T.pick_up_date)=year('".$period."') AND T.trip_status_id='".TRIP_STATUS_INVOICE_GENERATED."' ";


	$condition="";	
	if(isset($_GET['trip_search'])){ 
	if($param2==''){
	$param2='0';
	}
	$parameters.='?trip_search='.$_GET['trip_search'];
	//driver search
	if($_GET['vehicle_number']!=null){
	$data['vehiclenumber']= $_GET['vehicle_number'];
	
	$condition=' AND  D.vehicle_registration_number Like "%'.$_GET['vehicle_number'].'%"';
	
	$parameters.='?vehicle_number='.$_GET['vehicle_number'];
	} 



//
	if($_GET['drivers']!=null && $_GET['drivers']!=gINVALID){
	$data['driver_id']=$_GET['drivers'];
	
	$where_arry['driver_id']=$_GET['drivers'];
	
		$condition.=' AND D.id = '.$data['driver_id'];
	$parameters.='?driver_id='.$data['driver_id'];
	}

	
	//$t
	} 
	$qry.=$condition;
	$qry.=' GROUP BY DP.driver_id DESC';

	//echo "hellow";
	/*if(is_null($this->mysession->get('condition'))){
	$this->mysession->set('condition',array("like"=>$like_arry,"where"=>$where_arry));
	}*/
	//$tbl="drivers";
	$baseurl=base_url().'front-desk/drivers-payments/';
	$uriseg ='4';
	//echo $param2; exit;
	//echo $qry;//exit;
	$p_res=$this->mypage->paging($tbl='',$per_page=25,$param2,$baseurl,$uriseg,$custom='yes',$qry,$parameters);
	//print_r($p_res);
	$data['values']=$p_res['values'];
	$data['page_links']=$p_res['page_links'];
	//$data['values']='';
	//print_r($data['values']);exit;
	$driver_trips='';
	$driver_statuses='';
	for($i=0;$i<count($data['values']);$i++){
		//$id=$data['values'][$i]['id'];
		//print_r($data['values']);exit;
		$id=1;
		$availability=$this->driver_model->getCurrentStatuses($id);
		if($availability==false){
		$driver_statuses[$id]='Available';
		$driver_trips[$id]=gINVALID;
		}else{
		$driver_statuses[$id]='OnTrip';
		$driver_trips[$id]=$availability[0]['id'];
		}
	}
	$data['driver_statuses']=$driver_statuses;
	$data['driver_trips']=$driver_trips;
	if(empty($data['values'])){
				$data['result']="No Results Found !";
	}
	$data['trips']=$data['values'];

			
			/* search condition ends*/
			$data['title']="Trips | ".PRODUCT_NAME;  
			$page='user-pages/drivers-payments';
		    $this->load_templates($page,$data);
		    }else{
				$this->notAuthorized();
			}
		
	}	
////////////////////////////////////////////////////////////////////////////////	





	public function Trips($param2){
		if($this->session_check()==true) {
			/* */
			
			$tbl_arry=array('customers','drivers','trip_statuses');
			for ($i=0;$i<count($tbl_arry);$i++){
					$result=$this->user_model->getArray($tbl_arry[$i]);
					if($result!=false){
					$data[$tbl_arry[$i]]=$result;
					}
					else{
					$data[$tbl_arry[$i]]='';
					}
			}	
			// print_r($data);exit;
			//$drivers=$this->driver_model->getDriversArray($condition='');
			
	$qry="SELECT T.id AS trip_id, T.booking_date AS booking_dates,T.pick_up_date AS pickup_date,T.pick_up_time AS pickuptime, T.trip_from AS trip_from,
	 T.trip_to AS trip_to,C.name as customer_name,C.mobile as mob,D.name as drivername,D.vehicle_registration_number as vehiclenumber,
	 TS.name AS tripstatus  FROM trips  AS T 
	 LEFT JOIN drivers AS D  ON D.id=T.driver_id LEFT JOIN  customers AS C ON C.id=T.customer_id 
	 LEFT JOIN trip_statuses AS TS ON TS.id=T.trip_status_id";
	$condition="";
	$parameters='';	
	
	if($param2==''){
	$param2='0';
	}

	//driver search
	if(isset($_GET['vehicle_number']) && $_GET['vehicle_number']!=null){
	$data['vehiclenumber']= $_GET['vehicle_number'];
	if($condition==""){
	$condition=' WHERE D.vehicle_registration_number Like "%'.$_GET['vehicle_number'].'%"';
	$parameters='?vehicle_number='.$_GET['vehicle_number'];	
	}
	
	} 

	//from date
	 
	
	//to date starts
	if(isset($_GET['trip_drop_date']) && $_GET['trip_drop_date']!=null && isset($_GET['trip_pick_date']) &&  $_GET['trip_pick_date']!=null){
	$data['trip_drop_date']=$_GET['trip_drop_date'];
	//$date_now=date('Y-m-d H');
	if($condition==""){
		$condition =' WHERE T.pick_up_date >= "'.$_GET['trip_pick_date'].'" AND T.pick_up_date <="'.$_GET['trip_drop_date'].'"';
		$parameters='?trip_pick_date='.$_GET['trip_pick_date'].'&trip_drop_date='.$_GET['trip_drop_date'];	
	}else{
		$condition.=' AND T.pick_up_date >= "'.$_GET['trip_pick_date'].'" AND T.pick_up_date <="'.$_GET['trip_drop_date'].'"';
		$parameters.='&trip_pick_date='.$_GET['trip_pick_date'].'&trip_drop_date='.$_GET['trip_drop_date'];
	}
	
	}else if(isset($_GET['trip_pick_date']) && $_GET['trip_pick_date']!=null ){
	$data['trip_pick_date']=$_GET['trip_pick_date'];
	if($condition==""){
		$condition =' WHERE T.pick_up_date >= "'.$_GET['trip_pick_date'].'"';
		$parameters='?trip_pick_date='.$_GET['trip_pick_date'];	
	}else{
		$condition.=' AND T.pick_up_date >= "'.$_GET['trip_pick_date'].'"';
		$parameters.='&trip_pick_date='.$_GET['trip_pick_date'];	
	}
	
	}else if(isset($_GET['trip_drop_date']) && $_GET['trip_drop_date']!=null ){
	$data['trip_drop_date']=$_GET['trip_drop_date'];
	if($condition==""){
		$condition =' WHERE T.pick_up_date >= "'.$_GET['trip_drop_date'].'"';
		$parameters='?trip_drop_date='.$_GET['trip_drop_date'];	
	}else{
		$condition.=' AND T.pick_up_date >= "'.$_GET['trip_drop_date'].'"';
		$parameters.='&trip_drop_date='.$_GET['trip_drop_date'];	
	}
	
	}

	if(isset($_GET['drivers']) && $_GET['drivers']!=null && $_GET['drivers']!=gINVALID){
	$data['driver_id']=$_GET['drivers'];
	
	if($condition==""){
		$condition =' WHERE T.driver_id = '.$data['driver_id'];
		$parameters='?drivers='.$_GET['drivers'];	
	}else{
		$condition.=' AND T.driver_id = '.$data['driver_id'];
		$parameters.='&drivers='.$_GET['drivers'];
	}
	}

	if(isset($_GET['customers']) && $_GET['customers']!=null && $_GET['customers']!=gINVALID){
		$data['customer_id']=$_GET['customers'];
		if($condition==""){
			$condition =' WHERE T.customer_id = '.$data['customer_id'];
			$parameters='?customers='.$_GET['customers'];
		}else{
			$condition.=' AND T.customer_id = '.$data['customer_id'];
			$parameters.='&customers='.$_GET['customers'];
		}
	}






	if(isset($_GET['trip_status_id']) && $_GET['trip_status_id']!=null && $_GET['trip_status_id']!=gINVALID ){
	$data['status_id']=$_GET['trip_status_id'];
	if($condition==""){
		$condition =' WHERE T.trip_status_id='.$data['status_id'];
		$parameters='?trip_status_id='.$_GET['trip_status_id'];
	}else{
		$condition.=' AND T.trip_status_id='.$data['status_id'];
		$parameters.='&trip_status_id='.$_GET['trip_status_id'];
	}
	}

	//echo $qry.'<br>';
	//echo $condition.'<br>';

	$baseurl=base_url().'front-desk/trips/';
	$uriseg ='3';
	
	$p_res=$this->mypage->paging($tbl='',$per_page=10,$param2,$baseurl,$uriseg,$custom='yes',$qry.$condition,$parameters);
	//print_r($p_res);exit;

	$data['values']=$p_res['values'];
	$data['page_links']=$p_res['page_links'];
	
	$driver_trips='';
	
	$data['driver_trips']=$driver_trips;
	if(empty($data['values'])){
				$data['result']="No Results Found !";
	}
	$data['trips']=$data['values'];
	$data['trip_sl_no']=$param2; 
	
			/* search condition ends*/
			$data['title']="Trips | ".PRODUCT_NAME;  
			$page='user-pages/trips';
		    $this->load_templates($page,$data);
		    }else{
				$this->notAuthorized();
			}
		
	}	
	

	public function DriverNotifications($param2){
		if($this->session_check()==true) {
			
			$trip_id=$param2;
			$tbl_arry=array('notification_view_statuses','notification_types');
			for ($i=0;$i<count($tbl_arry);$i++){
					$result=$this->user_model->getArray($tbl_arry[$i]);
					if($result!=false){
					$data[$tbl_arry[$i]]=$result;
					}
					else{
					$data[$tbl_arry[$i]]='';
					}
			}	
			
			
			
	$qry="SELECT T.id AS trip_id ,NT.name as notification_type,NVS.name as notification_view_status,NVS.id AS notification_view_status_id, N.id  AS notification_id , T.booking_date AS booking_dates,T.pick_up_date AS pickup_date,T.pick_up_time AS pickuptime, T.trip_from AS trip_from,
	 T.trip_to AS trip_to,C.name as customer,C.mobile as mobile,D.name as drivername,D.vehicle_registration_number as vehiclenumber,
	 TS.name AS tripstatus  FROM notifications  AS N
	 LEFT JOIN drivers AS D  ON D.app_key=N.app_key
	 LEFT JOIN  trips AS T ON T.id=N.trip_id
	 LEFT JOIN  customers AS C ON C.id=T.customer_id 
	 LEFT JOIN notification_types AS NT  ON NT.id=N.notification_type_id 
	 LEFT JOIN 	notification_view_statuses AS NVS ON NVS.id=N.notification_view_status_id
	 LEFT JOIN trip_statuses AS TS ON TS.id=T.trip_status_id";
	$condition="";	
	$baseurl=base_url().'front-desk/driver-notifications/';
	if(isset($_GET['id']) && is_numeric($_GET['id'])){
	$parameters='?id='.$_GET['id'];
	$qry.=" WHERE D.id=".$_GET['id'];
	$data['id']=$_GET['id'];
	}else{
		redirect(base_url().'front-desk/list-driver');
	}
	if($param2=='' || $param2=='1'){
	$param2='0';
	}
	
	
	if(isset($_GET['period']) && $_GET['period']!=gINVALID){
		$data['period']=$_GET['period'];
		$todatefinder=$data['period'].'/'.date('d/Y');
		$lastday = date('t',strtotime(date('m/d/Y',strtotime($todatefinder))));
		$fromdate=date('Y').'-'.$data['period'].'-'.'01 00:00:00';
		$todate=date('Y').'-'.$data['period'].'-'.$lastday.' 23:59:59';
		$qry.=' AND N.created BETWEEN "'.$fromdate.'" AND "'.$todate.'"';
		$parameters.='&period='.$_GET['period'];
		
	}else{

		$data['period']='';

	}
	if(isset($_GET['notification_view_status']) && $_GET['notification_view_status']!=gINVALID){
		$data['notification_view_status']=$_GET['notification_view_status'];
		$qry.=' AND N.notification_view_status_id='.$data['notification_view_status'];
		$parameters.='&notification_view_status='.$_GET['notification_view_status'];
		
	}else{

		$data['notification_view_status']='';

	}
	if(isset($_GET['notification_type']) && $_GET['notification_type']!=gINVALID){
		$data['notification_type']=$_GET['notification_type'];
		
		$qry.=' AND N.notification_type_id='.$data['notification_type'];
		$parameters.='&notification_type='.$data['notification_type'];
		
	}else{

		$data['notification_type']='';
	
	}

	
	$uriseg ='3';
	//echo $qry; exit;
	
	$p_res=$this->mypage->paging($tbl='',$per_page=10,$param2,$baseurl,$uriseg,$custom='yes',$qry,$parameters);
	$data['notification_sl_no']=$param2+1;
	$data['values']=$p_res['values'];
	$data['periods']=$p_res['values'];
	$data['periods']=array("1"=>"January","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November",
"12"=>"December");
	$data['page_links']=$p_res['page_links'];
	/*echo '<pre>';
	print_r($data['values']);
	echo '</pre>';exit;*/
	
	if(empty($data['values'])){
		$data['msg']="No Results Found !";
	}else{
		$data['msg']="";
	}
	$data['trips']=$data['values'];

	
			/* search condition ends*/
			$data['title']="Notifications | ".PRODUCT_NAME;  
			$page='user-pages/driver-notifications';
		    $this->load_templates($page,$data);
		    }else{
				$this->notAuthorized();
			}
		
	}



	public function Customer($param2=''){
		if($this->session_check()==true) {
		$data['mode']=$param2;
		
		
			if($param2!=''){
				$condition=array('id'=>$param2);
				$result=$this->customers_model->getCustomerDetails($condition);
				$pagedata['id']=$result[0]['id'];
				$pagedata['name']=$result[0]['name'];
				$pagedata['mobile']=$result[0]['mobile'];
				$pagedata['address']=$result[0]['address'];
				$pagedata['customer_status_id']=$result[0]['customer_status_id'];
				
			}
			$tbl_arry=array('customer_statuses');
			
			for ($i=0;$i<count($tbl_arry);$i++){
			$result=$this->user_model->getArray($tbl_arry[$i]);
			if($result!=false){
			$data[$tbl_arry[$i]]=$result;
			}
			else{
			$data[$tbl_arry[$i]]='';
			}
			} 
			$data['title']="Customer | ".PRODUCT_NAME;
			if(isset($pagedata)){ 
				$data['values']=$pagedata;
			}else{
				$data['values']=false;
			}
			
			
			$page='user-pages/customer';
		    $this->load_templates($page,$data);
		}else{
			$this->notAuthorized();
		}

	}	
	


	public function load_templates($page='',$data=''){
	if($this->session_check()==true) {		
		
		if($this->checkPermissions($page)==true){
		$this->load->view('admin-templates/header',$data);
		$this->load->view('admin-templates/nav');
		$this->load->view($page,$data);
		$this->load->view('admin-templates/footer');
		}else{
			$this->notAuthorized();
		}
		}else{
			$this->notAuthorized();
		}
	}
	
	public function checkPermissions($page){
	
		$page=explode('/',$page);
		$page_id=$this->user_model->getPageId($page[count($page)-1]);
		if($page_id!=false){		
			$id=$this->session->userdata('id');
			$permitted_page_ids=$this->user_model->getPageIds($id);
				if($permitted_page_ids!=false){
					$permitted_page_ids=explode(',',$permitted_page_ids);
					if(in_array($page_id, $permitted_page_ids)){
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				}
		}else{

			return false;
		}
		
	}

public function	Customers($param2){
			if($this->session_check()==true) {
				if($this->mysession->get('condition')!=null){
						$condition=$this->mysession->get('condition');
						if(isset($condition['like']['name']) || isset($condition['like']['mobile'])|| isset($condition['where']['customer_status_id'])){
						}
						else{
						$this->mysession->delete('condition');
						}
						}
			$tbl_arry=array('customer_statuses');
	
			for ($i=0;$i<count($tbl_arry);$i++){
			$result=$this->user_model->getArray($tbl_arry[$i]);
			if($result!=false){
			$data[$tbl_arry[$i]]=$result;
			}
			else{
			$data[$tbl_arry[$i]]='';
			}
			}
			//print_r($data['customer_types']);exit;
			$tbl="customers";
			$baseurl=base_url().'front-desk/customers/';
			$per_page=5;
			$uriseg ='3';
			
			$where_arry='';
			$like_arry='';

			if((isset($_REQUEST['customer'])|| isset($_REQUEST['mobile']) || isset($_REQUEST['customer_status_id']))&& isset($_REQUEST['customer_search'])){	
				
				if($param2==''){
				$param2='0';
				}
				if($_REQUEST['customer']!=null){
					$data['customer']=$_REQUEST['customer'];
					$like_arry['name']=$_REQUEST['customer'];
				}
				if($_REQUEST['mobile']!=null){
					$data['mobile']=$_REQUEST['mobile'];
					$like_arry['mobile']=$_REQUEST['mobile'];
				}
				if($_REQUEST['customer_status_id']!=null && $_REQUEST['customer_status_id']!=gINVALID){
				$data['customer_status_id']=$_REQUEST['customer_status_id'];
				$where_arry['customer_status_id']=$_REQUEST['customer_status_id'];
				}
				
				$this->mysession->set('condition',array("where"=>$where_arry,"like"=>$like_arry));
			}
			if(is_null($this->mysession->get('condition'))){
			$this->mysession->set('condition',array("where"=>$where_arry,"like"=>$like_arry));
			}else{
			$search_condition=$this->mysession->get('condition');
			if(isset($search_condition['like']['name'])){
			$data['customer']=$search_condition['like']['name'];
			}
			if(isset($search_condition['like']['mobile'])){
			$data['mobile']=$search_condition['like']['mobile'];
			}
			if(isset($search_condition['where']['customer_status_id'])){
			$data['customer_status_id']=$search_condition['where']['customer_status_id'];
			}
			}
						
			$paginations=$this->mypage->paging($tbl,$per_page,$param2,$baseurl,$uriseg,$model='');
			if($param2==''){
				$this->mysession->delete('condition');
			}
			$data['page_links']=$paginations['page_links'];
			$data['customers']=$paginations['values'];	
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
				}//print_r($customer_statuses);print_r($customer_trips);exit;
				if(isset($customer_statuses) && count($customer_statuses)>0){
				$data['customer_current_statuses']=$customer_statuses;
				}	
				if(isset($customer_trips) && count($customer_trips)>0){
				$data['customer_trips']=$customer_trips;
				}		
			if(empty($data['customers'])){
				$data['result']="No Results Found !";
				}
			$data['title']="Customers | ".PRODUCT_NAME;  
			$page='user-pages/customers';
		    $this->load_templates($page,$data);
		}else{
			$this->notAuthorized();
		}
}
	
public function profile() {
	   if($this->session_check()==true) {
		
			$dbdata = '';
              if(isset($_REQUEST['user-profile-update'])){ 
			$dbdata['first_name'] = $this->input->post('firstname');
			$dbdata['last_name']  = $this->input->post('lastname');
		    $dbdata['email'] 	   = $this->input->post('email');
			$hmail 	   = $this->input->post('hmail');
			$dbdata['phone'] 	   = $this->input->post('phone');
			$hphone 	   = $this->input->post('hphone');
		    $dbdata['address']   = $this->input->post('address');
			$dbdata['username']   = $this->input->post('husername');
			$fadata['firstname'] = $this->input->post('firstname');
			$fadata['lastname']  = $this->input->post('lastname');
		    $fadata['email'] 	   = $this->input->post('email');
			$fadata['phone'] 	   = $this->input->post('phone');
			$fadata['fa_account']   = $this->input->post('fa_account');
			//$this->form_validation->set_rules('username','Username','trim|required|min_length[5]|max_length[20]|xss_clean');
			$this->form_validation->set_rules('firstname','First Name','trim|required|min_length[2]|xss_clean');
			$this->form_validation->set_rules('lastname','Last Name','trim|required|min_length[2]|xss_clean');
			if($dbdata['email'] == $hmail){
			$this->form_validation->set_rules('email','Mail','trim|required|valid_email');
		}else{
			$this->form_validation->set_rules('email','Mail','trim|required|valid_email|is_unique[users.email]');
		}
			if($dbdata['phone'] == $hphone){
			$this->form_validation->set_rules('phone','Phone','trim|required|regex_match[/^[0-9]{10}$/]|numeric|xss_clean');
		}else{
			$this->form_validation->set_rules('phone','Phone','trim|required|regex_match[/^[0-9]{10}$/]|numeric|xss_clean||is_unique[users.phone]');
		}
			
			$this->form_validation->set_rules('address','Address','trim|required|min_length[10]|xss_clean');
			//$dbdata['username']  = $this->input->post('username');
		   	
			
			if($this->form_validation->run() != False) {
				$val    		   = $this->user_model->updateProfile($dbdata);
				if($val==true){
				//fa user edit
					$this->load->model('account_model');
					$this->account_model->edit_user($fadata);
                   
				redirect(base_url().'front-desk');
				}
			}else{
				$this->show_profile($dbdata);
			}
		}else{
			
			$this->show_profile($dbdata);

		}
	   }	
		else{
			$this->notAuthorized();
		}
	}
	public function show_profile($data) {
		  if($this->session_check()==true) {
			if($data == ''){
			$data['values']=$this->user_model->getProfile();
			}else{
			$data['postvalues']=$data;
			}
			$data['title']="Profile | ".PRODUCT_NAME;  
			$page='user-pages/profile';
		    $this->load_templates($page,$data);
		    }
			else{
				$this->notAuthorized();
			}
	}
	public function changePassword() {
	if($this->session_check()==true) {
	   $this->load->model('user_model');
	   $data['old_password'] = 	'';
		$data['password']	  = 	'';
		$data['cpassword'] 	  = 	'';
       if(isset($_REQUEST['user-password-update'])){
			$this->form_validation->set_rules('old_password','Current Password','trim|required|min_length[5]|max_length[12]|xss_clean');
			$this->form_validation->set_rules('password','New Password','trim|required|min_length[5]|max_length[12]|xss_clean');
			$this->form_validation->set_rules('cpassword','Confirm Password','trim|required|min_length[5]|max_length[12]|matches[password]|xss_clean');
			$data['old_password'] = trim($this->input->post('old_password'));
			$data['password'] = trim($this->input->post('password'));
			$data['cpassword'] = trim($this->input->post('cpassword'));
			if($this->form_validation->run() != False) {
				$dbdata['password']  	= md5($this->input->post('password'));
				$dbdata['old_password'] = md5(trim($this->input->post('old_password')));
				$val    			    = $this->user_model->changePassword($dbdata);
				if($val == true) {				
					redirect(base_url().'front-desk');
				}else{
					$this->show_change_password($data);
				}
			} else {
				
					$this->show_change_password($data);
			}
		} else {
			
					$this->show_change_password($data);
		}
		           }
		else{
			$this->notAuthorized();
		}
	}	
   
	public function show_change_password($data) {
		if($this->session_check()==true) {
				$data['title']="Change Password | ".PRODUCT_NAME;  
				$page='user-pages/change_password';
				 $this->load_templates($page,$data);
		}else{
			$this->notAuthorized();
		}
	}
	public function ShowDriverView($param2) {
		if($this->session_check()==true) {
				$tbl=array();
				$data['select']=$this->select_Box_Values($tbl);
				
				
			//trip details
		
			if($param2!=''){
			
			$data['trips']=$this->trip_booking_model->getDriverVouchers($param2);
			}

			
			//sample ends
				$data['title']="Driver Details | ".PRODUCT_NAME;  
				$page='user-pages/addDrivers';
				 $this->load_templates($page,$data);
		}else{
			$this->notAuthorized();
		}
	}
	
	  public function ShowDriverList($param1,$param2) {
	if($this->session_check()==true) {
	
	$data['drivers']=$this->driver_model->getDriversArray($condition=''); 
			
	$qry="SELECT D.id,D.name,D.mobile,D.vehicle_registration_number,D.app_key,DS.name as driver_status,D.driver_status_id FROM drivers AS D
	 LEFT JOIN driver_statuses AS DS ON DS.id=D.driver_status_id";
	
	$baseurl=base_url().'front-desk/list-driver/';
	$parameters='';
	if(isset($_GET['id']) && is_numeric($_GET['id'])){
	$parameters='?id='.$_GET['id'];
	$condition=" WHERE D.id=".$_GET['id'];
	$data['id']=$_GET['id'];
	}

	if($param2=='' || $param2=='1'){
	$param2='0';
	}
	
	
	if(isset($_GET['driver_name']) && $_GET['driver_name']!=''){
		$data['driver_name']=$_GET['driver_name'];
		
		if($condition!=''){
		$condition.=' AND D.name LIKE "%'.$data['driver_name'].'%"';
		$parameters.='&driver_name='.$_GET['driver_name'];
		}else{
		$condition=' WHERE D.name LIKE "%'.$data['driver_name'].'%"';
		$parameters='?driver_name='.$_GET['driver_name'];
		}
		
		
	}else{

		$data['driver_name']='';

	}
	if(isset($_GET['driver_city']) && $_GET['driver_city']!=''){
		$data['driver_city']=$_GET['driver_city'];
		
		if($condition!=''){
		$condition.=' AND D.city LIKE "%'.$data['driver_city'].'%"';
		$parameters.='&driver_name='.$_GET['driver_name'];
		}else{
		$condition=' WHERE D.city LIKE "%'.$data['driver_city'].'%"';
		$parameters='?driver_city='.$_GET['driver_city'];
		}
	}else{

		$data['driver_city']='';

	}
	if(isset($_GET['status']) && $_GET['status']!=gINVALID){
		$data['status_id']=$_GET['status'];
		if($condition!=''){
		$condition.=' AND D.driver_status_id='.$data['status_id'];
		$parameters.='&status='.$data['status_id'];
		}else{
		$condition=' WHERE D.driver_status_id='.$data['status_id'];
		$parameters='?status='.$data['status_id'];
		}
		
	}else{

		$data['status_id']='';
	
	}
	if(isset($_GET['drivers']) && $_GET['drivers']!=gINVALID){
		$data['driver_id']=$_GET['drivers'];
		if($condition!=''){
		$condition.=' AND D.id='.$data['driver_id'];
		$parameters.='&drivers='.$data['driver_id'];
		}else{
		$condition=' WHERE D.id='.$data['driver_id'];
		$parameters='?drivers='.$data['driver_id'];
		}
		
	}else{

		$data['driver_id']='';
	
	}
	
	$uriseg ='3';
	//echo $qry.$condition; exit;
	
	$p_res=$this->mypage->paging($tbl='',$per_page=10,$param2,$baseurl,$uriseg,$custom='yes',$qry.$condition,$parameters);
	$data['driver_sl_no']=$param2+1;
	$data['values']=$p_res['values'];
	$data['page_links']=$p_res['page_links'];
	
	if(empty($data['values'])){
		$data['results']="No Results Found";
	}else{
		$data['results']='true';
	}

	$data['title']='List Drivers | '.PRODUCT_NAME;
	$page='user-pages/driverList';
	$this->load_templates($page,$data);	
	}

	

	}

	public function sendNotifications(){
	if($this->session_check()==true) {
			if($this->mysession->get('post')!=''){
				$data=$this->mysession->get('post');print_r($data);
				$this->mysession->delete('post');
			}else{
				$data['driver']='';
				$data['message']='';
			}
			$data['title']='Send Notification | '.PRODUCT_NAME;
			$page='user-pages/sendNotification';
			
			$data['drivers']=$this->driver_model->getDriversArray($condition=''); 
			$this->load_templates($page,$data);

	}else{
					$this->notAuthorized();
	}

	}
	
		public function ShowDriverProfile($param1,$param2){
			if($this->session_check()==true) {
			$data['mode']=$param2;
			if($param2!=null && $param2!=gINVALID){
			
			$arry=array('id'=>$param2);
			$data['result']=$this->user_model->getDriverDetails($arry);
			}   
			//trip details
		
		
			//print_r($data['trips']);exit;
			$data['title']='Driver Profile| '.PRODUCT_NAME;
			$page='user-pages/addDrivers';
			$tbl=array();
			$data['select']=$this->select_Box_Values($tbl);
			$this->load_templates($page,$data);
		
			}
			else{
					$this->notAuthorized();
			}
	}

	public function tripVouchers($param2){
			if($this->session_check()==true) {
		
			$data['title']='Trip Vouchers | '.PRODUCT_NAME;
			$page='user-pages/trip_vouchers';
			$this->load_templates($page,$data);
		
			}else{
				$this->notAuthorized();
			}
	}
	public function select_Box_Values($tbl_arry){
		$data=array();
		for ($i=0;$i<count($tbl_arry);$i++){
		$result=$this->user_model->getArray($tbl_arry[$i]);
		if($result!=false){
		$data[$tbl_arry[$i]]=$result;
		}
		else{
		$data[$tbl_arry[$i]]='';
		}
		}
		return $data;
	}
	
	
	public function date_check($date){
	if( strtotime($date) >= strtotime(date('Y-m-d')) ){
	return true;
	}
	}
	public function setup_dashboard(){
	if(isset($_REQUEST['setup_dashboard']) ){
	$data=$this->trip_booking_model->getTodaysTripsDriversDetails();
	if($data!=false){
	echo json_encode($data);
	}else{
		echo 'false';
	}
	}
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

	public function getNotifications(){
	if(isset($_REQUEST['notify']) ){
	$conditon =array('trip_status_id'=>TRIP_STATUS_PENDING,'CONCAT(pick_up_date," ",pick_up_time) >='=>date('Y-m-d H:i'));
	//$where_or=array('trip_status_id'=>TRIP_STATUS_CONFIRMED,'trip_status_id'=>TRIP_STATUS_ONTRIP);
	$orderby = ' CONCAT(pick_up_date," ",pick_up_time) ASC';
	$notification=$this->trip_booking_model->getDetails($conditon,$orderby);
	$customers_array=$this->customers_model->getArray();
	$json_data=array('notifications'=>$notification,'customers'=>$customers_array);
	if(count($notification)>0 && count($customers_array) >0 ){
		echo json_encode($json_data);
	}else{
		echo 'false';
	}
	}
}
	public function findDistance(){
		if($this->session_check()==true) {
		
			$data['title']='Find Distance | '.PRODUCT_NAME;
			$page='user-pages/finddistance';
			$this->load_templates($page,$data);
		
			}else{
				$this->notAuthorized();
			}
	}

	public function captcha_check($str){
		if (trim($str) != trim($this->session->userdata('captcha_code')))
		{
			$this->form_validation->set_message('captcha_check', 'Captcha mismach.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}
