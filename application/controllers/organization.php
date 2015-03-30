<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Organization extends CI_Controller {

public function __construct()
{
    parent::__construct();
    $this->load->helper('my_helper');
    no_cache();

}
	 public function index($param1 ='',$param2='',$param3 ='',$param4='')
		{
		if($param1=='login' && $param2=='' && $param3==''){

			$this->checking_credentials();

		 }elseif($param1=='admin' && $param2=='' && $param3==''){
			$this->admin();
		 }elseif($param1=='admin' && $param2=='profile' && $param3==''){
			$this->redirect_to_profile();
		 }elseif(($param1=='admin' || $param1=='front-desk' ) && $param2=='changepassword' && $param3==''){ 
			$this->changepassword();
		 } elseif($param1=='admin'  && $param2=='front-desk' && ($param3!= '' || $param4!= '')){
			$this->front_desk($param3,$param4);
		 }else{
				$this->notFound();
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
	
	public function checking_credentials() {
	if($this->session_check()==true) {
        	
				 redirect(base_url().'organization/admin');
				 
		}else if($this->front_desk_session_check()==true){

				redirect(base_url().'organization/front-desk');
			} else if(isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
			 $this->load->model('organization_model');
			 $username=$this->input->post('username');
			 $this->organization_model->LoginAttemptsChecks($username);
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

		     if( $username && $pass && $this->organization_model->OrganizationOrUserLogin($username,$pass)) {
				 if($this->session->userdata('loginAttemptcount') > 1){
		       	 $this->organization_model->clearLoginAttempts($username);
				 }
				 if($this->session->userdata('type')==ORGANISATION_ADMINISTRATOR){
				 redirect(base_url().'organization/admin');
				 }elseif($this->session->userdata('type')==FRONT_DESK){
				 redirect(base_url().'organization/front-desk');
				 }
				 
		        
		    } else {
				if($this->mysession->get('password_error')!='' ){
				$ip_address=$this->input->ip_address();
		        $this->organization_model->recordLoginAttempts($username,$ip_address);
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
	public function admin(){
	
	if($this->session_check()==true) {
		$data['title']="Home | ".PRODUCT_NAME;	
		$page='organization-pages/admin_home';
		$this->load_templates($page,$data);

		}else{
			$this->notAuthorized();
		}
	}
	
	public function show_login() 
	{   $data['title']="Login | ".PRODUCT_NAME;	
		$this->load->view('organization-pages/login',$data);
		
    }
	public function redirect_to_profile() {
	$this->load->model('organization_model');
	if(isset($_REQUEST['org-profile-update'])){
			$data['name'] = str_replace(' ','',($this->input->post('name')));
			$data['uname'] = trim($this->input->post('uname'));
			$data['hname']  = trim($this->input->post('hname'));
		    $data['fname'] = $this->input->post('fname');
		    $data['lname'] = $this->input->post('lname');
		    $data['addr']  = $this->input->post('addr');
		    $data['mail']  = $this->input->post('mail');
			$data['hmail']  = $this->input->post('hmail');
		    $data['phn'] = $this->input->post('phn');
			$data['hphone']  = $this->input->post('hphone');
			$data['user_id'] = $this->input->post('user_id');
			$data['org_id'] = $this->input->post('org_id');
			
		if($data['name'] == $data['hname']){
			$this->form_validation->set_rules('name','Organization','trim|required|min_length[2]|xss_clean');
		}else{
			$this->form_validation->set_rules('name','Organization','trim|required|min_length[2]|xss_clean|is_unique[organisations.name]');
		}
		$this->form_validation->set_rules('fname','First Name','trim|required|min_length[2]|xss_clean');
		$this->form_validation->set_rules('lname','Last Name','trim|required|min_length[2]|xss_clean');
		$this->form_validation->set_rules('addr','Address','trim|required|min_length[10]|xss_clean');
		if($data['mail'] == $data['hmail']){
			$this->form_validation->set_rules('mail','Mail','trim|required|valid_email');
		}else{
			$this->form_validation->set_rules('mail','Mail','trim|required|valid_email|is_unique[users.email]');
		}
		if($data['phn'] == $data['hphone']){
			$this->form_validation->set_rules('phn','Contact Info','trim|required|regex_match[/^[0-9]{10}$/]|numeric|xss_clean');
		}else{
			$this->form_validation->set_rules('phn','Contact Info','trim|required|regex_match[/^[0-9]{10}$/]|numeric|xss_clean|is_unique[users.phone]');
		}
	
		if($this->form_validation->run()!=False){
		
		$res    		   = $this->organization_model->update($data);
		if($res == true) { 
	   	    $this->session->set_userdata(array('dbSuccess'=>'Organization Profile Updated Succesfully..!'));
		    $this->session->set_userdata(array('dbError'=>''));
		    redirect(base_url().'organization/admin');
		}
		}
		else{
			 $this->profile($data);
			
		}
			
		}else{
		$result=$this->organization_model->getProfile();
		$org_res=$result['org_res'];
		$user_res=$result['user_res'];
		$data['org_id']=$org_res['id'];
		$data['name']=$org_res['name'];
		$data['hname']  = $org_res['name'];;
		$data['addr']=$org_res['address'];
		$data['user_id']=$user_res['id'];
		$data['uname']=$user_res['username'];
		$data['fname']=$user_res['first_name'];
		$data['lname']=$user_res['last_name'];
		$data['mail']=$user_res['email'];
		$data['hmail']=$user_res['email'];
		$data['phn']=$user_res['phone'];
		$data['hphone']=$user_res['phone'];
		$data['status']=$user_res['user_status_id'];
		$this->profile($data);
	}
	
	}

	public function profile($data ='') {
		if($this->session_check()==true) {
		$data['title']="Profile Update | ".PRODUCT_NAME; 
		$page='organization-pages/profile';
		$this->load_templates($page,$data);
	 	}
	}

	public function changepassword() {
	if($this->session_check()==true) {
		$this->load->model('organization_model');
		$data['old_password'] = 	'';
		$data['password']	  = 	'';
		$data['cpassword']	  = 	'';
       if(isset($_REQUEST['password-update'])){
			$this->form_validation->set_rules('old_password','Current Password','trim|required|min_length[5]|max_length[12]|xss_clean');
			$this->form_validation->set_rules('password','New Password','trim|required|min_length[5]|max_length[12]|xss_clean');
			$this->form_validation->set_rules('cpassword','Confirm Password','trim|required|min_length[5]|max_length[12]|matches[password]|xss_clean');
			$data['old_password'] = trim($this->input->post('old_password'));
			$data['password'] = trim($this->input->post('password'));
			$data['cpassword'] = trim($this->input->post('cpassword'));
			if($this->form_validation->run() != False) {
				$dbdata['password']  	= md5($this->input->post('password'));
				$dbdata['old_password'] = md5(trim($this->input->post('old_password')));
				$val    			    = $this->organization_model->changePassword($dbdata);
				if($val == true) {
					//change fa user password
					$this->load->model('account_model');
					$this->account_model->change_password($dbdata);

					redirect(base_url().'logout');
				}else{
					$this->show_change_password($data);
				}
			} else {
				
					$this->show_change_password($data);
			}
			} else {
			
					$this->show_change_password($data);
			}
		}else{
			$this->notAuthorized();
		}
		
	}
	

	public function show_change_password($data = '') {
			$data['title']="Change Password | ".PRODUCT_NAME;  
			$page='organization-pages/change-password';
			$this->load_templates($page,$data);
	}
	public function front_desk($action ='',$secondaction = '') {
		 if ($action =='new' && $secondaction == ''){
      
	if(isset($_REQUEST['user-profile-add'])) {		   
		    $firstname = trim($this->input->post('firstname'));
		    $lastname = trim($this->input->post('lastname'));
		    $address  = $this->input->post('address');
		    $username  = trim($this->input->post('username'));
		    $password  = $this->input->post('password');
		    $email  = $this->input->post('email');
		    $phone = $this->input->post('phone');
	        
		$this->form_validation->set_rules('firstname','First Name','trim|required|min_length[2]|xss_clean');
		$this->form_validation->set_rules('lastname','Last Name','trim|required|min_length[2]|xss_clean');
		$this->form_validation->set_rules('address','Address','trim|required|min_length[10]|xss_clean');
		$this->form_validation->set_rules('username','Username','trim|required|min_length[4]|max_length[15]|xss_clean|is_unique[users.username]');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[5]|max_length[12]|matches[cpassword]|xss_clean');
		$this->form_validation->set_rules('cpassword','Confirmation','trim|required|min_length[5]|max_length[12]|xss_clean');
		$this->form_validation->set_rules('email','Mail','trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('phone','Contact Info','trim|required|regex_match[/^[0-9]{10}$/]|numeric|xss_clean|is_unique[users.phone]');
		
      if($this->form_validation->run()==False){ 
        $data=array('title'=>'Add New Organization | '.PRODUCT_NAME,'firstname'=>$firstname,'lastname'=>$lastname,'username'=>$username,'password'=>$password,'address'=>$address,'email'=>$email,'phone'=>$phone);
	$this->showAddUser($data);
	}
      else {
	   $this->load->model('organization_model');
		  
		   //inserting values to db
		    $res	=	$this->organization_model->insertUser($firstname,$lastname,$address,$username,$password,$email,$phone);
		       if($res==true){ 
			    //sending email to user
					$to = $email;
					$message='Hi..'.$firstname.' '.$lastname.'</br> Your profile is created.Your </br> username :'.$username.'Password :'.$password.'Thanks & Regards</br> Acube Innovations';
				 // $rs=$this->sendEmail($message,$to);
				 // if($rs==true){
				    $this->session->set_userdata(array('dbSuccess'=>'User Added Succesfully..!'));
				    $this->session->set_userdata(array('dbError'=>''));
				    redirect(base_url().'organization/admin/front-desk/list');
		
				  //}
				}
	}
		}
			else if($this->session_check()==true){
			$data=array('title'=>'Add New Organization |'.PRODUCT_NAME,'firstname'=>'','lastname'=>'','username'=>'','password'=>'','address'=>'','email'=>'','phone'=>'');
				$this->showAddUser($data);
		} 
		
		}
    else if($action=='list' && ($secondaction == ''|| is_numeric($secondaction))) {
	$this->load->model('organization_model');
	$this->load->model('account_model');
	$data['user_status']=$this->organization_model->getUserStatus();//print_r($user_status);
	$condition='';
	$per_page=5;
	$like_arry='';
	$where_arry['user_type_id']=FRONT_DESK;
	$where_arry['organisation_id']=$this->session->userdata('organisation_id');
	//if(isset($where_arry) && count($where_arry)>0) {
	//	$this->mysession->set('condition',array('where'=>$where_arry));
	//}
	//for search
    if((isset($_REQUEST['sname'])|| isset($_REQUEST['status']))&& isset($_REQUEST['search'])){
	if($secondaction==''){
		$secondaction='0';
	}
	$this->mysession->delete('condition');
	if($_REQUEST['sname']!=null&& $_REQUEST['status']!=-1){
	$like_arry['name']= $_REQUEST['sname'];
	$where_arry['status_id']=$_REQUEST['status'];
	}
	if($_REQUEST['sname']==null&& $_REQUEST['status']!=-1){
	$where_arry['user_status_id']=$_REQUEST['status'];
	}
	if($_REQUEST['sname']!=null&& $_REQUEST['status']==-1){
	$like_arry['username']= $_REQUEST['sname'];
	}
		$this->mysession->set('condition',array('like'=>$like_arry,'where'=>$where_arry));
	}
	if(is_null($this->mysession->get('condition'))){
	$this->mysession->set('condition',array("like"=>$like_arry,"where"=>$where_arry));
	}
	$tbl='users';
	$baseurl=base_url().'organization/admin/front-desk/list/';
	$uriseg ='5';
    $p_res=$this->mypage->paging($tbl,$per_page,$secondaction,$baseurl,$uriseg);
	if($secondaction==''){
		$this->mysession->delete('condition');
	}
	$data['values']=$p_res['values'];
	if(empty($data['values'])){
	$data['result']="No Results Found !";
	}
	$data['page_links']=$p_res['page_links'];
	$data['title']='User List| '.PRODUCT_NAME;
	$page='organization-pages/userList';
	$this->load_templates($page,$data);
	}
    else
	{
	$this->load->model('organization_model');
	$result=$this->organization_model->checkUser($action);
	if(!$result){
	echo "page not found";

	}
	else{
	
	if($secondaction != '' && $secondaction =='password-reset') {

		//if user name  and password-reset comes what to do?
		$this->load->model('organization_model');
	   	$data['title']		  =		"Reset Password | CC Phase 1"; 
		$data['password']	  = 	'';
		$data['cpassword'] 	  = 	'';
		$data['user']	  =		$action;
			 
       if(isset($_REQUEST['user-password-reset'])){
	  
			$this->form_validation->set_rules('password','New Password','trim|required|min_length[5]|max_length[12]|xss_clean');
			$this->form_validation->set_rules('cpassword','Confirm Password','trim|required|min_length[5]|max_length[12]|matches[password]|xss_clean');
			$data['password'] = trim($this->input->post('password'));
			$data['cpassword'] = trim($this->input->post('cpassword'));
			if($this->form_validation->run() != False) {
				$dbdata['password']  				= md5($this->input->post('password'));
				$dbdata['passwordnotencrypted']  	= $this->input->post('password');
				$dbdata['name']  					= $result['first_name'].$result['last_name'];
				
				$dbdata['email']  					= $result['email'];
				$dbdata['id'] 						= $result['id'];
				$val    			    			= $this->organization_model->resetUserPassword($dbdata);
				if($val == true) {
						$message='Hi..'.$dbdata['name'].'</br> Your changed Password is '.$dbdata['password'].'.Thanks & Regards</br> Acube Innovations';
						$to=$dbdata['email'];
						//$this->sendEmail($message.$to);
						
					redirect(base_url().'organization/admin/front-desk/list');
				}else{
					$this->show_user_reset_password($data);
				}
			} else {
				
					$this->show_user_reset_password($data);
			}
		} else {
			
					$this->show_user_reset_password($data);
		}
	}else{
		
		$data['title']='Profile Update |'.PRODUCT_NAME;
		if(isset($_REQUEST['user-profile-update'])){
		//echo $this->input->post('fa_account');exit;
			$data['firstname']= trim($this->input->post('firstname'));
			$data['lastname'] = trim($this->input->post('lastname'));
			$data['address']  = $this->input->post('address');
			$data['username'] = $this->input->post('husername');
			$data['email'] 	  = $this->input->post('email');
			$data['phone']    = $this->input->post('phone');
			$data['id']		  = $this->input->post('id');
			$data['status']   =   $this->input->post('status');
			$data['fa_account']		  = $this->input->post('fa_account');
			
	        
			$this->form_validation->set_rules('firstname','First Name','trim|required|min_length[2]|xss_clean');
			$this->form_validation->set_rules('lastname','Last Name','trim|required|min_length[2]|xss_clean');
			$this->form_validation->set_rules('address','Address','trim|required|min_length[10]|xss_clean');
			//$this->form_validation->set_rules('username','Username','trim|required|min_length[5]|max_length[20]|xss_clean|is_unique[users.username]');
		if($this->input->post('email')==$this->input->post('hmail')){
			$this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean');
			}
			else{
			$this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|is_unique[users.email]');
			}
		if($this->input->post('phone')==$this->input->post('hphone')){
			$this->form_validation->set_rules('phone','Contact Info','trim|required|regex_match[/^[0-9]{10}$/]|numeric|xss_clean');
			
			}else{
			$this->form_validation->set_rules('phone','Contact Info','trim|required|regex_match[/^[0-9]{10}$/]|numeric|xss_clean|is_unique[users.phone]');
			}
		
		if($this->form_validation->run()!=False){
		
		$res    		   = $this->organization_model->updateUser($data);

		if($res == true) { 

		   //fa user edit
		   $this->load->model('account_model');
		   $this->account_model->edit_user($data);
                   
		   
	   	    $this->session->set_userdata(array('dbSuccess'=>'User Profile Updated Succesfully..!'));
		    $this->session->set_userdata(array('dbError'=>''));
		    redirect(base_url().'organization/admin/front-desk/list');
		}
		}else{
		$data['user_status']=$this->organization_model->getUserStatus();
		$this->showAddUser($data);

		}
		} else {
		$data['user_status']=$this->organization_model->getUserStatus();
		$data['title']='User Profile Update | '.PRODUCT_NAME;
		$data['id']=$result['id'];
		$data['username']=$result['username'];
		$data['firstname']=$result['first_name'];
		$data['fa_account']=$result['fa_account'];
		$data['lastname']=$result['last_name'];
		$data['address']=$result['address'];
		$data['email']=$result['email'];
		$data['phone']=$result['phone'];
		$data['status']=$result['user_status_id'];
		$this->showAddUser($data);
		}
		}
		}
		}
		}
	
	public function showAddUser($data){
	   if($this->session_check()==true) {
		$page='organization-pages/addUser';
		$this->load_templates($page,$data);
		}
	   else{
			$this->notAuthorized();
		}
	}

	


	public function load_templates($page='',$data=''){
	
	if($this->session_check()==true) {
    $this->load->view('admin-templates/header',$data);
	$this->load->view('admin-templates/nav');
	$this->load->view($page,$data);
	$this->load->view('admin-templates/footer');
	}else{
	$this->notAuthorized();
	}

	}	  
	public function session_check() {
	if(($this->session->userdata('isLoggedIn')==true ) && ($this->session->userdata('type')==ORGANISATION_ADMINISTRATOR) ) {
		return true;
		} else {
		return false;
		}
	}
	public function front_desk_session_check() {
	if(($this->session->userdata('isLoggedIn')==true ) && ($this->session->userdata('type')==FRONT_DESK) ) {
		return true;
		} else {
		return false;
		}
	}
	public function show_user_reset_password($data){
	if($this->session_check()==true) {
				$this->load->view('admin-templates/header',$data);
			  	$this->load->view('admin-templates/nav');
				$this->load->view('organization-pages/password-reset',$data);
				$this->load->view('admin-templates/footer');
					}
		else{
			$this->notAuthorized();
		}
	}
	
	public function sendEmail($message,$to){
	   if($this->session_check()==true) {
	
	 $config = Array(
  'protocol' => 'smtp',
  'smtp_host' => 'ssl://smtp.googlemail.com',
  'smtp_port' => 465,
  'smtp_user' => 'xxx@gmail.com', // change it to yours
  'smtp_pass' => 'xxx', // change it to yours
  'mailtype' => 'html',
  'charset' => 'iso-8859-1',
  'wordwrap' => TRUE
);
		$this->email->from(SYSTEM_EMAIL, 'Acube Innovations');
		$this->email->to($to);
		$this->email->subject('Succes Message');
		$this->email->message($message);
		if($this->email->send())
			{
			echo 'Email sent.';
			return true;
			}
		else
			{
			show_error($this->email->print_debugger());
			}
			}
		else{
			$this->notAuthorized();
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
	


	
}
