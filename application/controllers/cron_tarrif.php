<?php 
class Cron_tarrif extends CI_Controller {
	public function __construct()
		{
		parent::__construct();
		$this->load->model("cron_tarrif_model");
		$this->load->model("trip_booking_model");
		$this->load->model("driver_model");
		$this->load->model("driver_payment_model");
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

	public function cronDriverPayments(){
	
	$res=$this->cron_tarrif_model->getDriverPayment(); 
		if($res!=''){
			for($index=0; $index<count($res);$index++){
				$trip_id=$res[$index]['trip_id'];
				$driver_id=$res[$index]['driver_id'];
				$driver_name[$driver_id]=$res[$index]['driver_name'];
								
				$total_trip_amount=$res[$index]['total_amount'];
				$data=array('trip_status_id' => TRIP_STATUS_INVOICE_GENERATED);
				$this->trip_booking_model->updateTrip($data,$trip_id);

				$percentage=$total_trip_amount; //commented - $percentage=$total_trip_amount*10/100;//percentage calulation for commission

				if(isset($payments[$driver_id])){
					$payments[$driver_id]=$payments[$driver_id]+$percentage;

				}else{
					$payments[$driver_id]=$percentage;
				}
			} 
			foreach ($payments as $key => $value) {
				$db_data['driver_id']=$key;
				$db_data['payment_date']=date('Y-m-d');
				//
				$year = explode('-', date('Y-m-d'));
				$db_data['year']=$year[0];
				$db_data['period']=$year[1];
				//
				$db_data['voucher_type_id']=INVOICE;
				$db_data['dr_amount']=$value;
				$db_data['voucher_number']="INV";
				$this->driver_payment_model->addDriverpayment($db_data);
				$this->sendPaymentNotification($db_data,$driver_name);
			}
		}
	}	

	/* public function cronDriverPayments(){
	
	$res=$this->cron_tarrif_model->getDriverPayment(); 
		if($res!=''){
			for($index=0; $index<count($res);$index++){
				$G_distance=$res[$index]['G_distance'];
				$trip_id=$res[$index]['trip_id'];
				$day_or_night=$res[$index]['day_or_night'];
				$driver_id=$res[$index]['driver_id'];
				$Day_rate=$res[$index]['Day_rate'];
				$Night_rate=$res[$index]['Night_rate'];
				$minimum_kilometers=$res[$index]['minimum_kilometers'];
				$additional_kilometer_day_rate=$res[$index]['additional_kilometer_day_rate'];
				$additional_kilometer_night_rate=$res[$index]['additional_kilometer_night_rate'];
				$driver_name[$driver_id]=$res[$index]['driver_name'];
				if($day_or_night==DAY_TRIP){
					$rate=$Day_rate;
					$additional_rate=$additional_kilometer_day_rate;
				}
				elseif($day_or_night==NIGHT_TRIP){
					$rate=$Night_rate;
					$additional_rate=$additional_kilometer_night_rate;
				}
				$additional_km=$G_distance-$minimum_kilometers;
				$total_trip_amount=$rate+($additional_km * $additional_rate);
				$data=array('total_amount' => $total_trip_amount,'trip_status_id' => TRIP_STATUS_INVOICE_GENERATED);
				$this->trip_booking_model->updateTrip($data,$trip_id);

				$percentage=$total_trip_amount;//commented - $percentage=$total_trip_amount*10/100;//percentage calulation for commission

				if(isset($payments[$driver_id])){
					$payments[$driver_id]=$payments[$driver_id]+$percentage;

				}else{
					$payments[$driver_id]=$percentage;
				}
			} 
			foreach ($payments as $key => $value) {
				$db_data['driver_id']=$key;
				$db_data['payment_date']=date('Y-m-d');
				//
				$year = explode('-', date('Y-m-d'));
				$db_data['year']=$year[0];
				$db_data['period']=$year[1];
				//
				$db_data['voucher_type_id']=INVOICE;
				$db_data['dr_amount']=$value;
				$db_data['voucher_number']="INV";
				$this->driver_payment_model->addDriverpayment($db_data);
				$this->sendPaymentNotification($db_data,$driver_name);
			}
		}
	}	
*/

	public function sendPaymentNotification($driverdata,$driver_name){

	$condition=array('id'=>$driverdata['driver_id']);
	$drivers=$this->driver_model->getDriversAppKey($condition);
	$dateObj   = DateTime::createFromFormat('!m', $driverdata['period']);
	$monthName = $dateObj->format('F');
	$data['message']=' Dear '.$driver_name[$driverdata['driver_id']].', The service charge for the month of '.$monthName.' - '.date('Y').', is Rs.'.$driverdata['dr_amount'];
	
	$data['notification_type_id']=NOTIFICATION_TYPE_PAYMENT_MSGS;
	$data['notification_status_id']=gINVALID;
	$data['notification_view_status_id']=NOTIFICATION_NOT_VIEWED_STATUS;
	$this->driver_model->sendNotification($data,$drivers);

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
	}
	}
}
