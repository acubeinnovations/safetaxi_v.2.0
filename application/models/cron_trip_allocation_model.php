<?php 
class Cron_trip_allocation_model extends CI_Model {

	function getTrips($conditon ='',$orderby=''){

	$this->db->from('trips');
	if($conditon!=''){
		$this->db->where($conditon);
	}
	
	if($orderby!=''){
		$this->db->order_by($orderby);
	}
 	$results = $this->db->get()->result();
		if(count($results)>0){
		return $results;

		}else{
			return false;
		}
	}

	function getDriversWithTripAccepted($trip_id){
	$qry="select * from notifications where notification_type_id=".NOTIFICATION_TYPE_NEW_TRIP." and notification_view_status_id=".NOTIFICATION_VIEWED_STATUS." and notification_status_id=".NOTIFICATION_STATUS_RESPONDED." and trip_id=".$trip_id." and amount > 0  order by amount asc";

	$result=$this->db->query($qry);
	$result=$result->result_array();
	if(count($result)>0){
	return $result;
	}else{
	return false;
	}
	}
	
	function getDriverArray(){

	$qry='SELECT id,app_key FROM drivers where driver_status_id='.DRIVER_STATUS_ACTIVE.' or driver_status_id='.DRIVER_STATUS_ENGAGED;
	$qry=$this->db->query($qry);
	$count=$qry->num_rows();
	$l= $qry->result_array();
		
			for($i=0;$i<$count;$i++){
		
			$values[$l[$i]['app_key']]=$l[$i]['id'];
			
			}
			if(!empty($values)){
			return $values;
			}
			else{
			return false;
			}

	}

	function sendNotification($data,$drivers){
		for($driver_index=0;$driver_index<count($drivers);$driver_index++){
		$data['app_key']=$drivers[$driver_index];
		if(isset($data['app_key'])){
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
	
	}

	}
	?>
