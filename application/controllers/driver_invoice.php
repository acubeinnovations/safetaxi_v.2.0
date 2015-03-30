<?php 
class Driver_invoice extends CI_Controller {
	public function __construct()
		{
		parent::__construct();
		$this->load->model("settings_model");
		$this->load->helper('my_helper');
		$this->load->model("driver_payment_model");
	
		no_cache();

		}
	public function index($param1,$param2="",$param3=""){
			$driver_id=$param1;
			$period=$param2;
			$voucher_type_id=$param3;
			
			if ($param2=="" && $param3=="") {
				$condition = 
							//'AND DP.voucher_type_id <> "'.PAYMENT.'" 
							'AND DP.period<='.date("m"). ' GROUP BY DP.id ORDER BY DP.period DESC';
			}elseif($param2!="" && $param3!=""){
				$condition = 'AND DP.period="'.$period.'" AND DP.voucher_type_id="'.$voucher_type_id.'"'.' GROUP BY DP.period DESC';
			}
			else{
				$condition="";
			}

			$data['values']=$this->driver_payment_model->getDriverInvoice($driver_id,$condition);
			$data['title']="Driver Payment";
      	    $page='user-pages/print_driver_payments';
      	    //print_r($data['values']); exit;
			$this->load_templates($page,$data);
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
	


	
	

	public function session_check() {
	if(($this->session->userdata('isLoggedIn')==true ) && ($this->session->userdata('type')==FRONT_DESK)) {
		return true;
		} else {
		return false;
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
