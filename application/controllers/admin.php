<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
{
    parent::__construct();
    $this->load->helper('my_helper');
	$this->load->model('admin_model');
    no_cache();

}
	public function session_check() {
	if(($this->session->userdata('isLoggedIn')==true ) && ($this->session->userdata('type')==SYSTEM_ADMINISTRATOR)) {
		return true;
	} else {
		return false;
	}

	}    
	public function index(){
	
        if($this->session_check()==true) {//newly added nijo
		$data['title']="Home | CC Phase1";   
        $page='admin-pages/home';
     
		$this->load_templates($page,$data);
		}else{
			$this->notAuthorized();
		}
	
    }
	
    public function front_desk() {
		$action=$this->uri->segment(3);
		$secondaction=$this->uri->segment(4);
		if ($action =='new' && $secondaction == ''){
      
	if(isset($_REQUEST['user-profile-add'])) {		   
		    $firstname = trim($this->input->post('firstname'));
		    $lastname = trim($this->input->post('lastname'));
		    $address  = $this->input->post('address');
		    $username  = trim($this->input->post('username'));
		    $password  = $this->input->post('password');
		    $email  = $this->input->post('email');
		    $phone = $this->input->post('phone');
			$user_permission_id = $this->input->post('user_permission_id');
	        
		$this->form_validation->set_rules('firstname','First Name','trim|required|min_length[2]|xss_clean');
		$this->form_validation->set_rules('lastname','Last Name','trim|required|min_length[2]|xss_clean');
		$this->form_validation->set_rules('address','Address','trim|xss_clean');
		$this->form_validation->set_rules('username','Username','trim|required|min_length[4]|max_length[15]|xss_clean|is_unique[users.username]');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[5]|max_length[12]|matches[cpassword]|xss_clean');
		$this->form_validation->set_rules('cpassword','Confirmation','trim|required|min_length[5]|max_length[12]|xss_clean');
		$this->form_validation->set_rules('email','Mail','trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('phone','Contact Info','trim|required|regex_match[/^[0-9]{10}$/]|numeric|xss_clean|is_unique[users.phone]');
		
      if($this->form_validation->run()==False){ 
        $data=array('title'=>'Add New User | '.PRODUCT_NAME,'firstname'=>$firstname,'lastname'=>$lastname,'username'=>$username,'password'=>$password,'address'=>$address,'email'=>$email,'phone'=>$phone);
	$this->showAddUser($data);
	}
      else {
	  
		  
		   //inserting values to db
		    $res	=	$this->admin_model->insertUser($firstname,$lastname,$address,$username,$password,$email,$phone);
		       if($res==true){ 
			    //sending email to user
					$to = $email;
					$message='Hi..'.$firstname.' '.$lastname.'</br> Your profile is created.Your </br> username :'.$username.'Password :'.$password.'Thanks & Regards</br>'.PRODUCT_NAME;
				 // $rs=$this->sendEmail($message,$to);
				 // if($rs==true){
				    $this->session->set_userdata(array('dbSuccess'=>'User Added Succesfully..!'));
				    $this->session->set_userdata(array('dbError'=>''));
				    redirect(base_url().'admin/front_desk/list');
		
				  //}
				}
	}
		}
			else if($this->session_check()==true){
			$data=array('title'=>'Add New User |'.PRODUCT_NAME,'firstname'=>'','lastname'=>'','username'=>'','password'=>'','address'=>'','email'=>'','phone'=>'','user_permission_id'=>'');
				$this->showAddUser($data);
		} 
		
		}
    else if($action=='list' && ($secondaction == ''|| is_numeric($secondaction))) {
	$data['user_status']=$this->admin_model->getUserStatus();//print_r($user_status);
	$condition='';
	$per_page=5;
	$like_arry='';
	$where_arry['user_type_id']=FRONT_DESK;
	//$where_arry['organisation_id']=$this->session->userdata('organisation_id');
	//if(isset($where_arry) && count($where_arry)>0) {
	//	$this->mysession->set('condition',array('where'=>$where_arry));
	//}
	//for search
    if((isset($_REQUEST['sname'])|| isset($_REQUEST['status']))&& isset($_REQUEST['search'])){
	if($secondaction=='' || $secondaction=='1'){
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
	$baseurl=base_url().'admin/front_desk/list';
	$uriseg ='4';
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
	$page='admin-pages/userList';
	$this->load_templates($page,$data);
	}
    else
	{
	
	$result=$this->admin_model->checkUser($action);
	if(!$result){
	echo "page not found";

	}
	else{
	
	if($secondaction != '' && $secondaction =='password-reset') {

		//if user name  and password-reset comes what to do?
		
	   	$data['title']		  =		"Reset Password |".PRODUCT_NAME; 
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
				$val    			    			= $this->admin_model->resetUserPassword($dbdata);
				if($val == true) {
						$message='Hi..'.$dbdata['name'].'</br> Your changed Password is '.$dbdata['password'].'.Thanks & Regards</br>'.PRODUCT_NAME;
						$to=$dbdata['email'];
						//$this->sendEmail($message.$to);
						
					redirect(base_url().'admin/front_desk/list');
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
		$tbl=array('pages');
		$data['pages']=$this->admin_model->getPages();
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
						
			
	        
			$this->form_validation->set_rules('firstname','First Name','trim|required|min_length[2]|xss_clean');
			$this->form_validation->set_rules('lastname','Last Name','trim|required|min_length[2]|xss_clean');
			$this->form_validation->set_rules('address','Address','trim|xss_clean');
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
		
		$res    		   = $this->admin_model->updateUser($data);

		if($res == true) { 

		 
		     $this->session->set_userdata(array('dbSuccess'=>'User Profile Updated Succesfully..!'));
		    $this->session->set_userdata(array('dbError'=>''));
		    redirect(base_url().'admin/front_desk/list');
		}
		}else{
		$data['user_status']=$this->admin_model->getUserStatus();
		$data['user_permission_id']='';
		$data['page_ids']=explode(',',$result['page_ids']);
		$this->showAddUser($data);
		
		}
		} else {
		$data['user_status']=$this->admin_model->getUserStatus();
		$data['title']='User Profile Update | '.PRODUCT_NAME;
		$data['id']=$result['id'];
		$data['username']=$result['username'];
		$data['firstname']=$result['first_name'];
		
		$data['lastname']=$result['last_name'];
		$data['address']=$result['address'];
		$data['email']=$result['email'];
		$data['phone']=$result['phone'];
		$data['status']=$result['user_status_id'];
		$data['user_permission_id']=$result['user_permission_id'];
		$data['page_ids']=explode(',',$result['page_ids']);
		$this->showAddUser($data);
		}
		}
		}
		}
		}
	
	public function show_user_reset_password($data){
	if($this->session_check()==true) {
				$this->load->view('admin-templates/header',$data);
			  	$this->load->view('admin-templates/nav');
				$this->load->view('admin-pages/password-reset',$data);
				$this->load->view('admin-templates/footer');
					}
		else{
			$this->notAuthorized();
		}
	}
	
	public function profile(){
	   if($this->session_check()==true) {
		
		$dbdata = '';
              if(isset($_REQUEST['admin-profile-update'])){
			$this->form_validation->set_rules('username','Username','trim|required|min_length[4]|max_length[15]|xss_clean');
			$this->form_validation->set_rules('firstname','First Name','trim|required|min_length[2]|xss_clean');
			$this->form_validation->set_rules('lastname','Last Name','trim|required|min_length[2]|xss_clean');
			if($this->input->post('email')==$this->input->post('hmail')){
			$this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean');
			}
			else{
			$this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|is_unique[users.email]');
			}
			$this->form_validation->set_rules('phone','Phone','trim|required|regex_match[/^[0-9]{10}$/]|numeric|xss_clean');
			$this->form_validation->set_rules('address','Address','trim|xss_clean');
			$dbdata['username']  = $this->input->post('username');
		   	$dbdata['first_name'] = $this->input->post('firstname');
			$dbdata['last_name']  = $this->input->post('lastname');
		    $dbdata['email'] 	   = $this->input->post('email');
			$dbdata['phone'] 	   = $this->input->post('phone');
		    $dbdata['address']   = $this->input->post('address');
			if($this->form_validation->run() != False) {
				$val    		   = $this->admin_model->updateProfile($dbdata);
				redirect(base_url().'admin/front_desk/'.$dbdata['username']);
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
	public function addUserPermissions($id){
		if(isset($_REQUEST['user-permission-add'])){
			$pages=$_REQUEST['permissions'];
			$username=$_REQUEST['username'];
			$permissions='';
			if(!empty($pages)){
				foreach ($pages as $key =>$value ) { 

				$permissions.=$value;
					if($key<count($pages)-1){
						$permissions.=',';
					}

				}
			
				$data=array('page_ids'=>$permissions);
			
			}else{
				$data=array('page_ids'=>'');
			}

			$this->admin_model->updatePermisions($data,$id);
		$this->session->set_userdata(array('dbSuccess'=>'Permissions Added Successfully'));
		redirect(base_url().'admin/front_desk/'.$username);
		}
	}
	public function show_profile($data) {
		  if($this->session_check()==true) {
			if($data == ''){
			$data['values']=$this->admin_model->getProfile();
			}else{
			$data['postvalues']=$data;
			}
			$data['title']="Profile | CC Phase 1";  
		    $page='admin-pages/profile';
			$this->load_templates($page,$data);
		    }
			else{
				$this->notAuthorized();
			}
	}
	public function changePassword() {
	if($this->session_check()==true) {
	  
	   	$data['title']		  =		"Change Password | CC Phase 1"; 
		$data['old_password'] = 	'';
		$data['password']	  = 	'';
		$data['cpassword'] 	  = 	'';
       if(isset($_REQUEST['admin-password-update'])){
			$this->form_validation->set_rules('old_password','Current Password','trim|required|min_length[5]|max_length[12]|xss_clean');
			$this->form_validation->set_rules('password','New Password','trim|required|min_length[5]|max_length[12]|xss_clean');
			$this->form_validation->set_rules('cpassword','Confirm Password','trim|required|min_length[5]|max_length[12]|matches[password]|xss_clean');
			$data['old_password'] = trim($this->input->post('old_password'));
			$data['password'] = trim($this->input->post('password'));
			$data['cpassword'] = trim($this->input->post('cpassword'));
			if($this->form_validation->run() != False) {
				$dbdata['password']  	= md5($this->input->post('password'));
				$dbdata['old_password'] = md5(trim($this->input->post('old_password')));
				$val    			    = $this->admin_model->changePassword($dbdata);
				if($val == true) {				
					//change fa admin password
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
		           }
		else{
			$this->notAuthorized();
		}
	}	
   public function showAddUser($data){
	   if($this->session_check()==true) {
		$page='admin-pages/addUser';
		$data['user_permissions']=array('1'=>'Permission For All','2'=>'Permission For Trips Booking','3'=>'Permission For View Trips' );
		$this->load_templates($page,$data);
		}
	   else{
			$this->notAuthorized();
		}
	}
	public function show_change_password($data) {
		if($this->session_check()==true) {
				$page='admin-pages/change-password';
				$this->load_templates($page,$data);
					}
		else{
			$this->notAuthorized();
		}
	}

	public function showAddOrg($data){
	   if($this->session_check()==true) {
		$page='admin-pages/addOrg';
		$this->load_templates($page,$data);
		}
	   else{
			$this->notAuthorized();
		}
	}
	
	public function sendEmail($data){
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
		$this->email->to($data['mail']);
		$this->email->subject('Succes Message');
		$this->email->message('You have succesfully added a new organisation'.$data['name'].'!!</br> Following are your User Credentials.</br> Username:'.$data['uname'].'</br> Password:'.$data['pwd'].'Thanks & Regards</br> Acube Innovations');
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
	public function sendEmailOnorganizationPaswordReset($data){
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
		$this->email->to($data['email']);
		$this->email->subject('Succes Message');
		$message ='Hi '.$data['name'].'!!</br> Your Passsword is reset by admin.Your </br> Username:'.$data['username'].'</br> Password:'.$data['passwordnotencrypted'].'</br>Thanks & Regards</br> Acube Innovations';
	    $this->email->message($message);
		if($this->email->send())
			{
			
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
	public function notAuthorized(){
	$data['title']='Not Authorized | '.PRODUCT_NAME;
	$page='not_authorized';
	$this->load->view('admin-templates/header',$data);
	$this->load->view('admin-templates/nav');
	$this->load->view($page,$data);
	$this->load->view('admin-templates/footer');
	
	}

}
