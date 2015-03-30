<?php 
class Settings_model extends CI_Model {
	
	
	public function addValues($tbl,$data){
	$this->db->set('created', 'NOW()', FALSE);
	$this->db->insert($tbl,$data); 
	return true;
	}

	public function addValues_returnId($tbl,$data){
	$this->db->set('created', 'NOW()', FALSE);
	$this->db->insert($tbl,$data);
	return $this->db->insert_id();
	}

	public function getValues($id,$tbl){ 
	$this->db->select('id,description,name');
	$this->db->from($tbl);
	 $this->db->where('id',$id );
	return $this->db->get()->result_array();
	
	}
	public function updateValues($tbl,$data,$id){
	 $this->db->where('id',$id );
	 $this->db->set('updated', 'NOW()', FALSE);
	$this->db->update($tbl,$data);
	return true;
	}
	public function deleteValues($tbl,$id){
	 $this->db->where('id',$id );
	$this->db->delete($tbl);
	return true;
	}
	
	
}
?>
