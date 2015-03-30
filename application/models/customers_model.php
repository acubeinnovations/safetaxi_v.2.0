<?php 
class Customers_model extends CI_Model {
	
	
	public function getCustomerDetails($data){ 
	$this->db->from('customers');
	if($data!=''){
		$this->db->where($data);
	}
	return $this->db->get()->result_array();
	
	}

	public function addCustomer($data){
		$data['user_id']=$this->session->userdata('id');
 		if($data['mobile']!=''){
		$condition['mobile']=$data['mobile'];
		$res=$this->getCustomerDetails($condition);
		if(count($res)==0){
			$this->db->set('created', 'NOW()', FALSE);
			$this->db->insert('customers',$data);
			$insert_id=$this->db->insert_id();

			if($insert_id > 0){
				return $insert_id;
			}else{
				return false;
			}
		}else{
			return $res[0]['id'];
		}
	
	}else{
			$this->db->set('created', 'NOW()', FALSE);
			$this->db->insert('customers',$data);
			$insert_id=$this->db->insert_id();

			if($insert_id > 0){
				return $insert_id;
			}else{
				return false;
			}

	}
	}
	public function getCurrentStatuses($id){ 
	$qry='SELECT * FROM trips WHERE CONCAT(pick_up_date," ",pick_up_time) <= "'.date("Y-m-d H:i").'" AND customer_id="'.$id.'"  AND trip_status_id='.TRIP_STATUS_ACCEPTED;
	$results=$this->db->query($qry);
	$results=$results->result_array();//echo $this->db->last_query();
	if(count($results)>0){
	
		return $results;
	}else{
		return false;
	}
	}
	
	function  updateCustomers($data,$id) {
	$this->db->where('id',$id );
	$this->db->set('updated', 'NOW()', FALSE);
	$this->db->update("customers",$data);
	return true;
	}
	
	public function getArray(){
		$qry=$this->db->get('customers');
		$count=$qry->num_rows();
		$l= $qry->result_array();
		
			for($i=0;$i<$count;$i++){
			$values[$l[$i]['id']]=$l[$i]['name'];
			}
			if(!empty($values)){
			return $values;
			}
			else{
			return false;
			}
	}
	public function getAllIds(){

	$qry=$this->db->select('id');
	$this->db->from('customers');
	$qry=$this->db->get();
	$count=$qry->num_rows();
	$result= $qry->result_array();
	for($i=0;$i<$count;$i++){
			$values[$result[$i]['id']]=$result[$i]['id'];
	}
	
	return $values;

	}
}
