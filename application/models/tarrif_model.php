<?php 
class Tarrif_model extends CI_Model {
	public function addValues($data){
	//print_r($data);exit;
	$tbl="tariff_masters";
	$this->db->set('created', 'NOW()', FALSE);
	$this->db->insert($tbl,$data);
	return true;
	}
	public function editValues($data,$id){
	$tbl="tariff_masters";
	
	$this->db->where('id',$id );
	$this->db->set('updated', 'NOW()', FALSE);
	$this->db->update($tbl,$data);
	return true;
	}
	public function deleteValues($id){
	$tbl="tariff_masters";
	$this->db->where('id',$id );
	$this->db->delete($tbl);
	return true;
	}
	public function addTariff($data){
	
	$date=explode("-",$data['from_date']);
	$year=$date[0];
	$month=$date[1];
	$day=$date[2];
	$date=$data['from_date'];
	$date_result=$this->date_check($date);
	if( $date_result==true ) {
	$from_unix_time = mktime(0, 0, 0, $month, $day, $year);
	$day_before = strtotime("yesterday", $from_unix_time);
	$formatted_date = date('Y-m-d', $day_before);
	$to_date='9999-12-30';
	$tbl="tariffs";
	$qry=$this->db->where(array('to_date'=>$to_date));
	$qry=$this->db->get($tbl);
	$result=$qry->result_array();
	$from=$result[0]['from_date'];
	if($qry->num_rows()>0){
	$this->db->where('id',$result[0]['id']);
	$this->db->set('updated', 'NOW()', FALSE);
	$this->db->update($tbl,array('to_date'=>$formatted_date));
	
	}
	
	$this->db->set('to_date', $to_date);
	$this->db->set('created', 'NOW()', FALSE);
	$this->db->insert($tbl,$data);
	return true;
	}
	else{
	return false;
	}
	}
	
	
	public function edit_tarrifValues($data,$id){
	$tbl="tariffs";
	$date=explode("-",$data['from_date']);
	$year=$date[0];
	$month=$date[1];
	$day=$date[2];
	$date=$data['from_date'];
	$date_result=$this->date_check($date);
	if( $date_result==true ) {
	$from_unix_time = mktime(0, 0, 0, $month, $day, $year);
	$day_before = strtotime("yesterday", $from_unix_time);
	$formatted_date = date('Y-m-d', $day_before);
	$tbl="tariffs";
	$qry=$this->db->where(array('id'=>$id-1));
	$qry=$this->db->get($tbl);
	$result=$qry->result_array();
	$from=$result[0]['from_date'];
	if($qry->num_rows()>0){
	$this->db->where('id',$result[0]['id']);
	$this->db->set('updated', 'NOW()', FALSE);
	$this->db->update($tbl,array('to_date'=>$formatted_date));

	}
	$this->db->where('id',$id );
	$this->db->set('updated', 'NOW()', FALSE);
	$this->db->update($tbl,$data);
	return true;
	}
	}

	
	public function delete_tarrifValues($id){
	$tbl="tariffs";
	$this->db->where('id',$id );
	$this->db->delete($tbl);
	return true;
	}

	public function selectAvailableTariff($data){
	$qry='SELECT T.rate,T.additional_kilometer_rate, max( T.to_date ) ,TM.minimum_kilometers,T.vehicle_model_id,TM.vehicle_make_id,TM.title, T.tariff_master_id, T.id FROM tariffs AS T, tariff_masters AS TM WHERE T.tariff_master_id = TM.id
AND T.organisation_id ='.$this->session->userdata('organisation_id').' AND TM.organisation_id ='.$this->session->userdata('organisation_id').' AND  TM.vehicle_ac_type_id ='.$data['vehicle_ac_type'].' AND T.vehicle_model_id ='.$data['vehicle_model'].' AND T.to_date ="9999-12-30" GROUP BY T.tariff_master_id';
	$result=$this->db->query($qry);
	$result=$result->result_array();
	return $result;

	}

	public function selectTariffDetails($id){
	$qry='SELECT T.rate,T.driver_bata,T.additional_kilometer_rate,TM.minimum_kilometers, T.tariff_master_id, T.id FROM tariffs AS T, tariff_masters AS TM WHERE T.tariff_master_id = TM.id
AND T.organisation_id ='.$this->session->userdata('organisation_id').' AND T.id ='.$id;
	$result=$this->db->query($qry);
	$result=$result->result_array();
	return $result;

	}
	public function date_check($date){
	if( strtotime($date) >= strtotime(date('Y-m-d')) ){
	return true;
	}
	}
	}
	?>
