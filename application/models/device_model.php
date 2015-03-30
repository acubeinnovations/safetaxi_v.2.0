<?php
class Device_model extends CI_Model {
	public function addDevice($data){
		$this->db->set('created', 'NOW()', FALSE);
		$this->db->insert('devices',$data);
		return true;
	}
		
	function  updateDevice($data,$id) {
	$this->db->where('id',$id );
	$this->db->set('updated', 'NOW()', FALSE);
	$this->db->update("devices",$data);
	return true;
	}

	public function getDeviceDetails($data){ 
		
	$this->db->from('deivices');
	$this->db->where($data);
	return $this->db->get()->result_array();
	
	}

	function getDeviceArray($condion=''){
	$this->db->from('devices');
	if($condion!=''){
    $this->db->where($condion);
	}
    $results = $this->db->get()->result();
	

		for($i=0;$i<count($results);$i++){
		$values[$results[$i]['id']]=$results[$i]['sim_no'];
		}
		if(!empty($values)){
		return $values;
		}
		else{
		return false;
		}

	}
	function getReg_Num(){
	$qry='SELECT V.registration_number,V.id As vehicle_id,VD.device_id ,VD.vehicle_id FROM vehicles AS V LEFT JOIN vehicle_devices AS VD ON VD.vehicle_id =V.id  WHERE VD.to_date="9999-12-30"';
	$results=$this->db->query($qry);
	$results=$results->result_array();
	if(count($results)>0){
	for($i=0;$i<count($results);$i++){
		$devices[$results[$i]['device_id']]=$results[$i]['registration_number'];
		}
		return $devices; 
	}else{
		return false;
	}
	}

}?>
