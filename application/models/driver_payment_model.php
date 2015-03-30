<?php 
class Driver_payment_model extends CI_Model {
	public function addDriverpayment($data){
	//print_r($data);exit;
	$tbl="driver_payment";
	$this->db->set('created', 'NOW()', FALSE);
	$this->db->insert($tbl,$data);
	return true;
	}

	public function getPayment($id){ 
	$qry='SELECT * FROM driver_payment WHERE id= '.$id;
	$results=$this->db->query($qry);
	$results=$results->result_array();
	if(count($results)>0){
	
		return $results;
	}else{
		return false;
	}
	}

	public function editDriverpayment($data,$id){
	$tbl="driver_payment";
	
	$this->db->where('id',$id );
	$this->db->set('updated', 'NOW()', FALSE);
	$this->db->update($tbl,$data);
	return true;
	}
	public function getAllDriverpayment(){ 
	$qry='SELECT * FROM driver_payment';
	$results=$this->db->query($qry);
	$results=$results->result_array();
	if(count($results)>0){
	
		return $results;
	}else{
		return false;
	}
	}

	public function getDriverpaymentReceipt($driver_id){
	$qry='SELECT DP.driver_id as Driver_id,DP.created as Created_date,DP.payment_date as Payment_date,SUM(DP.dr_amount) as Receipt FROM voucher_types VT 
	LEFT JOIN driver_payment DP ON DP.voucher_type_id=VT.id AND DP.voucher_type_id= "'.RECEIPT.'" AND DP.driver_id="'.$driver_id.'" ';
	$results=$this->db->query($qry);
	$results=$results->result_array();
	if(count($results)>0){
	
		return $results;
	}else{
		return false;
	}
	}

	public function getDriverInvoice($driver_id,$condition){
		$qry='SELECT D.name as Driver_name,D.address as Driver_address,D.district as Driver_district,D.state as Driver_state,D.pin_code as 

	Driver_pincode,D.mobile as Driver_mobile,D.email as Driver_email,D.license_number as Driver_license,D.vehicle_registration_number as 

	Driver_vehicle_registration,D.dob as Driver_dob,DP.id as Driver_payment_id,DP.year as Driver_payment_year,DP.voucher_number as Voucher_number,DP.payment_date as Payment_date,DP.period as Driver_payment_period,DP.dr_amount as Driver_debit,DP.cr_amount as 

	Driver_credit,VT.name as Voucher_type FROM drivers D LEFT JOIN driver_payment AS DP ON DP.driver_id = D.id LEFT JOIN voucher_types AS VT ON 

	VT.id=DP.voucher_type_id WHERE DP.voucher_type_id <> "'.RECEIPT.'" AND  DP.driver_id="'.$driver_id.'"  '.$condition;
		//print_r($qry); exit;
	$results=$this->db->query($qry); ; 
	$results=$results->result_array();
	
	if(count($results)>0){
	
		return $results;
	}else{
		return false;
	}	
	}

	
	}
	?>
