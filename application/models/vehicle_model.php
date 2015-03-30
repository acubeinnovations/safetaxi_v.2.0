<?php
class Vehicle_model extends CI_Model {
public function insertVehicle($data,$driver_data,$device_data){
$qry=$this->db->set('created', 'NOW()', FALSE);
$qry=$this->db->insert('vehicles',$data);
$v_id=mysql_insert_id();
if($qry>0){
	
	$this->mysession->set('vehicle_id',$v_id);
	return true;
	}
	else
	{
	$this->mysession->set('date_err','Invalid Date');
	}


}

public function getVehicles(){ 
	$qry='SELECT V.registration_number,V.id,V.vehicle_model_id,V.vehicle_make_id,VD.from_date,VD.to_date,VD.driver_id,VD.vehicle_id FROM vehicles AS V LEFT JOIN vehicle_drivers AS VD ON  V.id =VD.vehicle_id AND V.organisation_id = '.$this->session->userdata('organisation_id').' WHERE VD.organisation_id = '.$this->session->userdata('organisation_id').' AND VD.to_date="9999-12-30"';
	$results=$this->db->query($qry);
	$results=$results->result_array();
	if(count($results)>0){
	for($i=0;$i<count($results);$i++){
		$vehicles[$results[$i]['driver_id']]['registration_number']=$results[$i]['registration_number'];
		$vehicles[$results[$i]['driver_id']]['vehicle_model_id']=$results[$i]['vehicle_model_id'];
		$vehicles[$results[$i]['driver_id']]['vehicle_make_id']=$results[$i]['vehicle_make_id'];

		}
		return $vehicles;
	}else{
		return false;
	}
	}
public function getCurrentStatuses($id){ 
	$qry='SELECT * FROM trips WHERE CONCAT(pick_up_date," ",pick_up_time) <= "'.date("Y-m-d H:i").'" AND CONCAT(drop_date," ",drop_time) >= "'.date("Y-m-d H:i").'" AND vehicle_id="'.$id.'" AND organisation_id = '.$this->session->userdata('organisation_id').' AND trip_status_id='.TRIP_STATUS_CONFIRMED;
	$results=$this->db->query($qry);
	$results=$results->result_array();
	if(count($results)>0){
	
		return $results;
	}else{
		return false;
	}
	}
	
public function insertInsurance($data){
$v_id=$this->mysession->get('vehicle_id');
$qry=$this->db->set('vehicle_id', $v_id);
$qry=$this->db->insert('vehicles_insurance',$data);
$in_id=mysql_insert_id();
$map_qry=$this->db->set('vehicles_insurance_id', $in_id);
$map_qry=$this->db->where('id',$v_id);
$map_qry=$this->db->update('vehicles');
return true;

}
public function insertLoan($data){
$qry=$this->db->set('created', 'NOW()', FALSE);
$v_id=$this->mysession->get('vehicle_id');
$qry=$this->db->set('vehicle_id', $v_id);
$qry=$this->db->insert('vehicle_loans',$data);
$l_id=mysql_insert_id();
$map_qry=$this->db->set('vehicle_loan_id', $l_id);
$map_qry=$this->db->where('id',$v_id);
$map_qry=$this->db->update('vehicles');
return true;

}

public function insertOwner($data){
	$qry=$this->db->set('created', 'NOW()', FALSE);
	$v_id=$this->mysession->get('vehicle_id');
	$qry=$this->db->set('vehicle_id', $v_id);
	$qry=$this->db->insert('vehicle_owners',$data);
	if($o_id = $this->db->insert_id()){
		$map_qry=$this->db->set('vehicle_owner_id', $o_id);
		$v_id=$this->mysession->get('vehicle_id');
		$map_qry=$this->db->where('id',$v_id);
		$map_qry=$this->db->update('vehicles');
		return $o_id;
	}else{
		return false;
	}
	

}
public function  UpdateVehicledetails($data,$v_id){
	
	$this->db->where('id',$v_id );
	$this->db->set('updated', 'NOW()', FALSE);
	$this->db->update('vehicles',$data); 
	return true;


}

public function map_drivers($driver_id,$from_date,$updated_date) {
	$v_id=$this->mysession->get('vehicle_id');
	$to_date='9999-12-30';
	$tbl="vehicle_drivers";
	$qry=$this->db->where(array('vehicle_id'=>$v_id,'organisation_id'=>$this->session->userdata('organisation_id'),'to_date'=>$to_date));
	$qry=$this->db->get($tbl);
	$result=$qry->result_array();
	if($qry->num_rows()>0){
	$this->db->where('id',$result[0]['id']);
	$this->db->set('updated', 'NOW()', FALSE);
	$this->db->update($tbl,array('to_date'=>$updated_date));
	}

	$arry=array('vehicle_id'=>$v_id,'driver_id'=>$driver_id,'from_date'=>$from_date,'organisation_id'=>$this->session->userdata('organisation_id'),'user_id'=>$this->session->userdata('id'),'to_date'=>$to_date);
	$this->db->set('created', 'NOW()', FALSE);
	$this->db->insert($tbl,$arry);

	}

	public function map_devices($device_id,$from_date,$updated_date) {
	$v_id=$this->mysession->get('vehicle_id');
	$to_date='9999-12-30';
	$tbl="vehicle_devices";
	$qry=$this->db->where(array('vehicle_id'=>$v_id,'organisation_id'=>$this->session->userdata('organisation_id'),'to_date'=>$to_date));
	$qry=$this->db->get($tbl);
	$result=$qry->result_array();
	if($qry->num_rows()>0){
	$this->db->where('id',$result[0]['id']);
	$this->db->set('updated', 'NOW()', FALSE);
	$this->db->update($tbl,array('to_date'=>$updated_date));
	}

	$arry=array('vehicle_id'=>$v_id,'device_id'=>$device_id,'from_date'=>$from_date,'organisation_id'=>$this->session->userdata('organisation_id'),'user_id'=>$this->session->userdata('id'),'to_date'=>$to_date);
	$this->db->set('created', 'NOW()', FALSE);
	$this->db->insert($tbl,$arry);

	}


public function sample_call($data,$driver_data,$v_id){
	$to_date='9999-12-30';
	$tbl="vehicle_drivers";
	$qry=$this->db->where(array('vehicle_id'=>$v_id,'organisation_id'=>$data['organisation_id'],'to_date'=>$to_date));
	$qry=$this->db->get($tbl);
	$result=$qry->result_array();
	//$from=$result[0]['from_date'];
	if($qry->num_rows()>0){
	$this->db->where('id',$result[0]['id']);
	$this->db->set('updated', 'NOW()', FALSE);
	$this->db->update($tbl,array('to_date'=>$formatted_date));
	
	}
	
	$arry=array('vehicle_id'=>$v_id,'driver_id'=>$driver_data['driver_id'],'from_date'=>$date,'organisation_id'=>$data['organisation_id'],'user_id'=>$data['user_id'],'to_date'=>$to_date);
	$this->db->set('created', 'NOW()', FALSE);
	$this->db->insert($tbl,$arry);
	$this->mysession->set('vehicle_id',$v_id);
}
public function UpdateInsurancedetails($data,$id){

$this->db->where('id',$id);
$this->db->update('vehicles_insurance',$data); 
return true;

}
public function UpdateLoandetails($data,$id){
$this->db->set('updated', 'NOW()', FALSE);
$this->db->where('id',$id);
$this->db->update('vehicle_loans',$data); 
return true;

}
public function UpdateOwnerdetails($data,$id){
$this->db->set('updated', 'NOW()', FALSE);
$this->db->where('id',$id);
$this->db->update('vehicle_owners',$data);  
return true;

}
}?>
