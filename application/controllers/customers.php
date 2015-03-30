<?php 
class Customers extends CI_Controller {
	public function __construct()
		{
		parent::__construct();
		$this->load->model("customers_model");
		$this->load->helper('my_helper');
		no_cache();

		}
	public function index($param1 ='',$param2='',$param3=''){
		if($this->session_check()==true) {
		if($param1=='customer-check') {
			
			$this->checkCustomer();
				
		}else if($param1=='add-customer') {
			
			$this->addCustomer();
				
		}else if($param1=='AddUpdate') {
			
			$this->Customer();
				
		}
		else{

			$this->notFound();
		}
		
	}else{
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
		public function checkCustomer(){
		if(isset($_REQUEST['mobile']) && $_REQUEST['mobile']!=''){
			$data['mobile']=$_REQUEST['mobile'];
		}
		if(isset($_REQUEST['email']) && $_REQUEST['email']!=''){
			$data['email']=$_REQUEST['email'];
		}
		
		$res=$this->customers_model->getCustomerDetails($data);
		if(!empty($res)){
		echo json_encode($res);
		if(isset($_REQUEST['customer']) && $_REQUEST['customer']=='yes'){
		ob_start();
		$this->set_customer_session($res);
		ob_end_clean();
		}
		}else{
		echo false;
		}
		
}

		public function addCustomer(){
		if(isset($_REQUEST['mobile']) || $_REQUEST['mobile']!=''  && isset($_REQUEST['name']) && $_REQUEST['name']!=''){
			$data['mobile']=$_REQUEST['mobile'];
			$data['name']=$_REQUEST['name'];
			$data['user_id']=$this->session->userdata('id');
			if(isset($_REQUEST['customer_status_id'])){
			$data['customer_status_id']=$_REQUEST['customer_status_id'];
			}else{
			$data['customer_status_id']=CUSTOMER_ACTIVE;
			}
			
		$res=$this->customers_model->addCustomer($data);
		if(isset($res) && $res!=false){

			//save customer in fa table
			$this->load->model("account_model");
			$fa_customer = $this->account_model->add_fa_customer($res,"C");
			echo true;
		}else{
			echo false;
		}
		}
		}

	   

		public function Customer(){
		if(isset($_REQUEST['customer-add-update'])){
			$customer_id=$this->input->post('customer_id');
			$data['name']=$this->input->post('name');
			$data['customer_status_id']=$this->input->post('customer_status_id');
			$data['mobile']=$this->input->post('mobile');
			$data['address']=$this->input->post('address');
			if($customer_id!=gINVALID){ 
			$hmail=$this->input->post('h_email');
			$hphone=$this->input->post('h_phone');
			}else{
			$hmail='';
			$hphone='';
			}
			$this->form_validation->set_rules('name','Name','trim|required|min_length[2]|xss_clean');
			
			/*
			if($customer_id!=gINVALID && $data['email'] == $hmail){
			$this->form_validation->set_rules('email','Mail','trim|valid_email');
			}else{
				$this->form_validation->set_rules('email','Mail','trim|valid_email|is_unique[customers.email]');
			}*/	
			if($customer_id!=gINVALID && $data['mobile'] == $hphone){
			$this->form_validation->set_rules('mobile','Mobile','trim|required|regex_match[/^[0-9]{10}$/]|numeric|xss_clean');
			}else{
			$this->form_validation->set_rules('mobile','Mobile','trim|required|regex_match[/^[0-9]{10}$/]|numeric|xss_clean||is_unique[customers.mobile]');
			}
			
			$data['user_id']=$this->session->userdata('id');
			if($this->form_validation->run() != False) {
				if($customer_id>gINVALID) {
				$res=$this->customers_model->updateCustomers($data,$customer_id);
					if(isset($res) && $res!=false){
						
						$this->session->set_userdata(array('dbSuccess'=>'Customer details Updated Successfully'));
						redirect(base_url().'front-desk/customers');	
					}
				}else if($customer_id==gINVALID){ 
				$res=$this->customers_model->addCustomer($data);
					if(isset($res) && $res!=false  && $res>0){
						
					 	$this->session->set_userdata(array('dbSuccess'=>'Customer details Added Successfully'));
						redirect(base_url().'front-desk/customers');	
					}
				}
				}else{
				$data['customer_id']=$customer_id;
				$this->mysession->set('post',$data);
				if($customer_id==gINVALID){
				$customer_id='';
				}
				redirect(base_url().'front-desk/customer/'.$customer_id);

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
	public function session_check() {
		if(($this->session->userdata('isLoggedIn')==true ) && ($this->session->userdata('type')==FRONT_DESK)) {
			return true;
			} else {
			return false;
			}
	} 

	public function set_customer_session($data){
	$session_data=array('customer_id'=>$data[0]['id'],'customer_name'=>$data[0]['name'],'customer_mobile'=>$data[0]['mobile']);
	$this->session->set_userdata($session_data);
	
	}
	
}
