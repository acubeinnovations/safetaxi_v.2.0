<?php 
class Device extends CI_Controller {
	public function __construct()
		{
		parent::__construct();
		$this->load->model("device_model");
		$this->load->helper('my_helper');
		no_cache();

		}
		public function session_check() {
	if(($this->session->userdata('isLoggedIn')==true ) && ($this->session->userdata('type')==FRONT_DESK)) {
		return true;
	} else {
		return false;
	}
	}
	

	public function deivceManage(){
	if($this->session_check()==true) {
	if(isset($_REQUEST['deviceAdd']) || isset($_REQUEST['deviceUpdate'])){ 

	//$data['organisation_id']=$this->session->userdata('organisation_id');
	$data['user_id']=$this->session->userdata('id');
	if(!isset($_REQUEST['deviceUpdate'])){
	$data['imei']=$this->input->post('imei');
	$data['sim_no']=$this->input->post('sim_no');
	
	$device_id=-1;
	 $this->form_validation->set_rules('sim_no','Sim Number','trim|required|xss_clean|regex_match[/^[0-9]{10}$/]|is_unique[devices.sim_no]');
	 $this->form_validation->set_rules('imei','IMEI','trim|required|xss_clean|is_unique[devices.imei]');

	}else{
	$device_id=$this->input->post('device_id');
	$data['imei']=$this->input->post('imei'.$device_id);
	$data['sim_no']=$this->input->post('sim_no'.$device_id);
	$h_imei=$this->input->post('h_imei'.$device_id);
	$h_sim_no=$this->input->post('h_sim_no'.$device_id);
	
	$device_id=$this->input->post('device_id');
	if($h_sim_no==$data['sim_no']){
		$this->form_validation->set_rules('sim_no'.$device_id,'Sim Number','trim|required|xss_clean|regex_match[/^[0-9]{10}$/]');
	}else{
		$this->form_validation->set_rules('sim_no'.$device_id,'Sim Number','trim|required|xss_clean|regex_match[/^[0-9]{10}$/]|is_unique[devices.sim_no]');
	}
	if($h_imei==$data['imei']){
 		$this->form_validation->set_rules('imei'.$device_id,'IMEI','trim|required|xss_clean');
	}else{
		$this->form_validation->set_rules('imei'.$device_id,'IMEI','trim|required|xss_clean|is_unique[devices.imei]');
	}
		
	}
	
	
	 if($this->form_validation->run()==False){
		$this->mysession->set('post',$data);
		redirect(base_url().'organization/front-desk/device');	
	 }else{//to do
		
		if(isset($_REQUEST['deviceAdd']) && $device_id==gINVALID){
		   $res=$this->device_model->addDevice($data);
			if($res==true){
				$this->session->set_userdata(array('dbSuccess'=>' Added Succesfully..!'));
				$this->session->set_userdata(array('dbError'=>''));
				redirect(base_url().'organization/front-desk/device');
			}else{
				$this->mysession->set('post',$data);
				redirect(base_url().'organization/front-desk/device');
			}
		}else  if(isset($_REQUEST['deviceUpdate']) && $device_id!=gINVALID){
			$res=$this->device_model->updateDevice($data,$device_id);
			if($res==true){
				$this->session->set_userdata(array('dbSuccess'=>' Updated Succesfully..!'));
				$this->session->set_userdata(array('dbError'=>''));
				redirect(base_url().'organization/front-desk/device');
			}else{
				$this->mysession->set('post',$data);
				redirect(base_url().'organization/front-desk/device');
			}
	
		}
	 }
	}else{


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
	// sample code
	}
