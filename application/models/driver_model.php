<?php
class Driver_model extends CI_Model {
public function addDriverdetails($data){


	$this->db->set('created', 'NOW()', FALSE);
	$this->db->insert('drivers',$data);
	return $this->db->insert_id();
}

public function getDriverDetails($data){ 
		
	$this->db->from('customers');
	$this->db->where($data);
	return $this->db->get()->result_array();
	
	}
	public function getCurrentStatuses($id){ 
	$qry='SELECT * FROM trips WHERE CONCAT(pick_up_date," ",pick_up_time) <= "'.date("Y-m-d H:i").'"  AND driver_id="'.$id.'"';
	$results=$this->db->query($qry);
	$results=$results->result_array();
	if(count($results)>0){
	
		return $results;
	}else{
		return false;
	}
	}

	/*public function getDrivers(){ 
	$qry='SELECT * FROM drivers';
	$results=$this->db->query($qry);
	$results=$results->result_array();
	if(count($results)>0){
	for($i=0;$i<count($results);$i++){
		$drivers[$results[$i]['vehicle_id']]['driver_name']=$results[$i]['name'];
		$drivers[$results[$i]['vehicle_id']]['mobile']=$results[$i]['mobile'];
		$drivers[$results[$i]['vehicle_id']]['from_date']=$results[$i]['from_date'];

		}
		return $drivers;
	}else{
		return false;
	}
	}*/

	/**/
	public function getDrivers(){ 
	$qry='SELECT * FROM drivers';	
	$results=$this->db->query($qry);
	$results=$results->result_array();
	if(count($results)>0){
	
		return $results;
	}else{
		return false;
	}
	}
	/**/










	function getDriversArray($condion=''){
	$this->db->from('drivers');
	if($condion!=''){
    $this->db->where($condion);
	}
    $results = $this->db->get()->result();
	

		for($i=0;$i<count($results);$i++){
		$values[$results[$i]->id]=$results[$i]->name;
		}
		if(!empty($values)){
		return $values;
		}
		else{
		return false;
		}

	}

	function getDriversAppKey($condion=''){
	$this->db->from('drivers');
	if($condion!=''){
    $this->db->where($condion);
	}
    $results = $this->db->get()->result();
	

		for($i=0;$i<count($results);$i++){
		$values[$i]=$results[$i]->app_key;
		}
		if(!empty($values)){
		return $values;
		}
		else{
		return false;
		}

	}

	function getDetails($conditon ='',$orderby=''){

	$this->db->from('drivers');
	if($conditon!=''){
		$this->db->where($conditon);
	}
	
	if($orderby!=''){
		$this->db->order_by($orderby);
	}
 	$results = $this->db->get()->result();//return $this->db->last_query();exit;
		if(count($results)>0){
		return $results;

		}else{
			return false;
		}
	}

	public function UpdateDriverdetails($data,$id){

	$arry=array('id'=>$id);
	$this->db->set('updated', 'NOW()', FALSE);
	$qry=$this->db->where($arry);
	$qry=$this->db->update("drivers",$data);
	
	return true;
	}

	function sendNotification($data,$drivers){
		for($driver_index=0;$driver_index<count($drivers);$driver_index++){
		$data['app_key']=$drivers[$driver_index];
		$data['trip_id']=gINVALID;
		$this->db->set('created', 'NOW()', FALSE);
		if($this->session->userdata('id')!=''){
			$user_id=$this->session->userdata('id');
		}else{
			$user_id=gINVALID;
		}
		$this->db->set('user_id',$user_id , FALSE);
		$this->db->insert('notifications',$data);
		
		}
	
	}


}?>
