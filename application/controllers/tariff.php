<?php 
class Tariff extends CI_Controller {
	public function __construct()
		{
		parent::__construct();
		$this->load->model("tarrif_model");
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
	
	
	public function tarrif_manage(){
	if($this->session_check()==true) {
	if(isset($_REQUEST['tarrif-add'])){
	$data['title']=$this->input->post('title');
	$data['from_date']=$this->input->post('from_date');
	$data['minimum_kilometers']=$this->input->post('minimum_kilometers');
	$data['day_rate']=str_replace(",","",$this->input->post('day_rate'));
	$data['night_rate']=str_replace(",","",$this->input->post('night_rate'));
	$data['additional_kilometer_day_rate']=str_replace(",","",$this->input->post('additional_kilometer_day_rate'));
	$data['additional_kilometer_night_rate']=str_replace(",","",$this->input->post('additional_kilometer_night_rate'));
	$data['user_id']=$this->session->userdata('id');

	 $this->form_validation->set_rules('title','Title','trim|required|xss_clean');
	 $this->form_validation->set_rules('minimum_kilometers','Minimum Kilometers','trim|required|xss_clean|numeric');
	 $this->form_validation->set_rules('from_date','Date ','trim|required|xss_clean');
	 $this->form_validation->set_rules('day_rate','Day Rate','trim|required|xss_clean');
	 $this->form_validation->set_rules('night_rate','Night Rate','trim|required|xss_clean');
	 $this->form_validation->set_rules('additional_kilometer_day_rate','Additional Day Rate','trim|required|xss_clean');
	 $this->form_validation->set_rules('additional_kilometer_night_rate','Additional Night Rate','trim|required|xss_clean');
	
	 $err=true;
	if($this->date_check($data['from_date'])==false){
	$err=False;
	$this->session->set_userdata('Err_dt','Invalid Date for Tariff Add!');
	$this->session->set_userdata(array('Err_date'=>'Invalid Date!'));
	}
	
	 if($this->form_validation->run()==False || $err==False){
		$this->session->set_userdata('post',$data);
		redirect(base_url().'front-desk/tariff',$data);	
	 }
	 else{
		 $res=$this->tarrif_model->addTariff($data);
		if($res==true){
		$this->session->set_userdata(array('dbSuccess'=>' Added Succesfully..!'));
				    $this->session->set_userdata(array('dbError'=>''));
				    redirect(base_url().'front-desk/tariff');
		}
		else{
		
		redirect(base_url().'front-desk/tariff');
		}
	 }
	}
	if(isset($_REQUEST['edit'])){
	 $id= $this->input->post('manage_id');
	 
	 
	 	$data['title']=$this->input->post('title');
		$data['from_date']=$this->input->post('from_date');
		$h_dtpicker=$this->input->post('h_dtpicker');
		$data['minimum_kilometers']=$this->input->post('minimum_kilometers');
		$data['day_rate']=str_replace(",","",$this->input->post('day_rate'));
		$data['night_rate']=str_replace(",","",$this->input->post('night_rate'));
		$data['additional_kilometer_day_rate']=str_replace(",","",$this->input->post('additional_kilometer_day_rate'));
		$data['additional_kilometer_night_rate']=str_replace(",","",$this->input->post('additional_kilometer_night_rate'));
	
		$err=False;
		if($h_dtpicker!=$data['from_date'] ){
		if($this->date_check($data['from_date'])==false){
		$err=true;
		$this->mysession->set('Err_from_date'.$id,'Invalid Date for Tariff !');
		}
		}
		if($data['title']==''){
			$this->mysession->set('Err_title'.$id,'Title Required..!');
			$err=true;
			}
		if($data['minimum_kilometers']==''){
			$this->mysession->set('Err_minimum_kilometers'.$id,'Minimum Kilometers Required..!');
			$err=true;
			}
		if($data['day_rate']==''){
			$this->mysession->set('Err_day_rate'.$id,'Day Rate Required..!');
			$err=true;
			}
		if($data['night_rate']==''){
			$this->mysession->set('Err_night_rate'.$id,'Night Rate Required..!');
			$err=true;
			}
		if($data['additional_kilometer_day_rate']==''){
			$this->mysession->set('Err_additional_kilometer_day_rate'.$id,'Additional Day Rate Required..!');
			$err=true;
			}
		if($data['additional_kilometer_night_rate']==''){
			$this->mysession->set('Err_additional_kilometer_night_rate'.$id,'Additional Night Rate Required..!');
			$err=true;
			}
		
		/*if(preg_match('#[^0-9\.]#', $data['rate'])){
			$this->session->set_userdata(array('Err_rate'=>'Invalid Characters on Rate field!'));
			$err=true;
			}*/
		/*if(preg_match('#[^0-9\.]#', $data['additional_kilometer_rate'])){
			$this->session->set_userdata(array('Err_add_kilo'=>'Invalid Characters on Kilometers field!'));
			$err=true;
			}*/
		/*if(preg_match('#[^0-9\.]#', $data['additional_hour_rate'])){
			$this->session->set_userdata(array('Err_add_hrs'=>'Invalid Characters on Hours field!'));
			$err=true;
			}*/
		/*if(preg_match('#[^0-9\.]#', $data['driver_bata'])){
			$this->session->set_userdata(array('Err_bata'=>'Invalid Characters on Driver Bata field!'));
			$err=true;
			}	
		if(preg_match('#[^0-9\.]#', $data['night_halt'])){
			$this->session->set_userdata(array('Err_halt'=>'Invalid Characters on Night Halt field!'));
			$err=true;
			}*/
			if($err==true){
			redirect(base_url().'front-desk/tarrif');
			}
			else{ //print_r($data);exit;
			
		$res=$this->tarrif_model->edit_tarrifValues($data,$id);
		if($res==true){
		$this->session->set_userdata(array('dbSuccess'=>' Updated Succesfully..!'));
				    $this->session->set_userdata(array('dbError'=>''));
				    redirect(base_url().'front-desk/tariff');
		}
		}
	}
		/*	if(isset($_REQUEST['delete'])){
	 $id= $this->input->post('manage_id');
	 $res=$this->tarrif_model->delete_tarrifValues($id);
		if($res==true){
		$this->session->set_userdata(array('dbSuccess'=>' Deleted Succesfully..!'));
				    $this->session->set_userdata(array('dbError'=>''));
				    redirect(base_url().'organization/front-desk/tariff');
		}
	}*/
	}
	
	else{
			$this->notAuthorized();
			}
	}

	public function tariffSelecter(){
	if(isset($_REQUEST['vehicle_ac_type']) && isset($_REQUEST['vehicle_model'])){

	
	$data['vehicle_ac_type']=$_REQUEST['vehicle_ac_type'];
	$data['vehicle_model']=$_REQUEST['vehicle_model'];
	$data['organisation_id']=$this->session->userdata('organisation_id');

	$res['data']=$this->tarrif_model->selectAvailableTariff($data);
	if(count($res['data'])>0){
	echo json_encode($res);
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
	
	public function date_check($date){
	if( strtotime($date) >= strtotime(date('Y-m-d')) ){ 
	return true;
	}else{
	return false;

	}
	}
}
