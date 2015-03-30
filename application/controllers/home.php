<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 
	 */
	public function index()
	{	if( $this->session->userdata('isLoggedIn') ) {
		if( $this->session->userdata('type')==SYSTEM_ADMINISTRATOR){
			redirect(base_url().'admin');
		}else if($this->session->userdata('type')==FRONT_DESK){
			 redirect(base_url().'front-desk');
		}
		}else{
		$data['title']="Login | ".PRODUCT_NAME;	
		$this->load->view('user-pages/login',$data);
		
		}
	}
}
