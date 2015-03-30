<?php 
class Trip_booking_model extends CI_Model {
	
	function getDriver($vehicle_id){

	$this->db->from('vehicle_drivers');
	$condition=array('vehicle_id'=>$vehicle_id,'to_date'=>'9999-12-30');
    $this->db->where($condition);
	
    $results = $this->db->get()->result();
	if(count($results)>0){
	return $results[0]->driver_id;
	}
	}
	function getTripBokkingDate($id){

	$this->db->from('trips');
	$condition=array('id'=>$id);
    $this->db->where($condition);
	
    $results = $this->db->get()->result();
	if(count($results)>0){
	return $results[0]->booking_date;
	}
	}

	function getLatestTariff(){
	$qry = "SELECT id FROM tariffs  WHERE ".date('Y-m-d')." between from_date and to_date";
		$result=$this->db->query($qry);	
		$result=$result->result_array();
		if(count($result)>0){
			return $result[0]['id'];
		}else{
			return false;
		}

	}

	function getTripDriver($id){

	$this->db->from('trips');
	$condition=array('id'=>$id);
    $this->db->where($condition);
	
    $results = $this->db->get()->result();
	if(count($results)>0){
	return $results[0]->driver_id;
	}
	}

	function getVehicle($id){

	$this->db->from('vehicles');
	$condition=array('id'=>$id);
    $this->db->where($condition);
	
    $results = $this->db->get()->result();
	if(count($results)>0){
	return $results;
	}else{
		return false;
	}
	}

	function getDriverDetails($id){

	$qry='SELECT D.app_key,D.id FROM trips as T LEFT JOIN drivers as D on D.id=T.driver_id where T.id='.$id.' AND (T.trip_status_id='.TRIP_STATUS_DRIVER_CANCELLED.' OR T.trip_status_id='.TRIP_STATUS_CUSTOMER_CANCELLED.' OR T.trip_status_id='.TRIP_STATUS_ACCEPTED.')';
	$result=$this->db->query($qry);
	$result=$result->result_array();
	if(count($result)>0){
	return $result;
	}else{
	return false;
	}

	}

	function changeDriverstatus($driver_id,$data){
	
	$this->db->where('id',$driver_id );
	$this->db->set('updated', 'NOW()', FALSE);
	$this->db->update("drivers",$data);

	}

	function setNotifications($data,$trip_update){
		if($data['notification_type_id']==NOTIFICATION_TYPE_NEW_TRIP && $trip_update==FALSE){
		if($this->checkInNotifications($data['app_key'],$data['trip_id'])){
			$insert=false;
		}else{

			$insert=true;
		}
		}else{
			$insert=true;
		}
		if($insert==true){
		$this->db->set('created', 'NOW()', FALSE);
		$this->db->set('user_id', $this->session->userdata('id'), FALSE);
		$this->db->insert('notifications',$data);
		if($this->db->insert_id()>0){
			return $this->db->insert_id();
		}else{
			return false;
		}
		}else{
			return false;
		}


	}
	function checkInNotifications($app_key,$trip_id){
		$qry = "SELECT * FROM notifications WHERE app_key= ".mysql_real_escape_string($app_key)." AND trip_id=".mysql_real_escape_string($trip_id);
		$result=$this->db->query($qry);	
		$num = $result->num_rows();
		if($num>0){
			return true;
		}else{
			return false;
		}
	}
	function getNotifiedListOfDrivers($id){
		$qry = "SELECT DISTINCT D.id,D.vehicle_registration_number,D.name,D.mobile FROM notifications AS N LEFT JOIN drivers AS D ON D.app_key=N.app_key WHERE N.trip_id=".mysql_real_escape_string($id)." AND N.notification_type_id=".NOTIFICATION_TYPE_NEW_TRIP;
		$result=$this->db->query($qry);	
		$result=$result->result_array();
		if(count($result)>0){
			return $result;
		}else{
			return false;
		}

	}
	
	function getNotifiedVehiclesCurrentPositions($id){
			$qry = "SELECT DISTINCT VL.id,VL.lat,VL.lng,VL.app_key,D.name FROM vehicle_locations_logs AS VL LEFT JOIN notifications AS N ON N.app_key=VL.app_key LEFT JOIN drivers AS D ON D.app_key=VL.app_key WHERE N.trip_id=".mysql_real_escape_string($id)." AND N.notification_type_id=".NOTIFICATION_TYPE_NEW_TRIP." AND VL.id IN (
SELECT max( id ) FROM vehicle_locations_logs GROUP BY app_key ) ORDER BY VL.created DESC";
		$result=$this->db->query($qry);	
		$result=$result->result_array();
		if(count($result)>0){
			return $result;
		}else{
			return false;
		}

	}

	function getTripDirections($id){
		$qry = "SELECT lat,lng  FROM vehicle_locations_logs  WHERE trip_id=".mysql_real_escape_string($id)." ORDER BY created ASC";
		$result=$this->db->query($qry);	
		$result=$result->result_array();
		if(count($result)>0){
			return $result;
		}else{
			return false;
		}

	}

	function getAvailableVehicles($data){
	$qry = "SELECT VL.app_key, VL.created, max(VL.id) as id, VL.lat, VL.lng,( 3959 * acos( cos( radians( ".mysql_real_escape_string($data['center_lat']).") ) * cos( radians( VL.lat ) ) * cos( radians( VL.lng ) - radians( ".mysql_real_escape_string($data['center_lng'])." ) ) + sin( radians( ".mysql_real_escape_string($data['center_lat'])." ) ) * sin( radians( VL.lat ) ) ) ) AS distance FROM vehicle_locations_logs AS VL LEFT JOIN drivers AS D ON D.app_key = VL.app_key WHERE D.driver_status_id = '".DRIVER_STATUS_ACTIVE."'  GROUP BY VL.app_key HAVING distance < ".mysql_real_escape_string($data['radius'])."  ORDER BY VL.created DESC";

	/*$qry = "SELECT VL.app_key, VL.created, VL.id, VL.lat, VL.lng,( 3959 * acos( cos( radians( ".mysql_real_escape_string($data['center_lat'])." ) ) * cos( radians( VL.lat ) ) * cos( radians( VL.lng ) - radians( ".mysql_real_escape_string($data['center_lng'])." ) ) + sin( radians( ".mysql_real_escape_string($data['center_lat'])." ) ) * sin( radians( VL.lat ) ) ) ) AS distance
FROM vehicle_locations_logs AS VL
LEFT JOIN drivers AS D ON D.app_key = VL.app_key
WHERE VL.id
IN (
SELECT max( id )
FROM vehicle_locations_logs
GROUP BY app_key
)
AND D.driver_status_id = '".DRIVER_STATUS_ACTIVE."'
HAVING distance < ".mysql_real_escape_string($data['radius'])."  
ORDER BY VL.created DESC"; 
------
	$qry = sprintf("SELECT VL.app_key,( 3959 * acos( cos( radians( '%s' ) ) * cos( radians( VL.lat ) ) * cos( radians( VL.lng ) - radians( '%s' ) ) + sin( radians( '%s' ) ) * sin( radians( VL.lat ) ) ) ) AS distance
FROM vehicle_locations_logs AS VL
LEFT JOIN drivers AS D ON D.app_key = VL.app_key
WHERE VL.id
IN (
SELECT max( id )
FROM vehicle_locations_logs
GROUP BY app_key
)
AND D.driver_status_id = '".DRIVER_STATUS_ACTIVE."'
HAVING distance < '%s'  
ORDER BY VL.created DESC",
  mysql_real_escape_string($data['center_lat']),
  mysql_real_escape_string($data['center_lng']),
  mysql_real_escape_string($data['center_lat']),
  mysql_real_escape_string($data['radius'])); 
	//echo $qry;exit;
	//inner query with time check
	/*SELECT max( id )
FROM vehicle_locations_logs WHERE  TIMEDIFF( NOW(),created) <= '00:15:00'
GROUP BY app_key
 VL.created, VL.id, VL.lat, VL.lng
	*/
	$result=$this->db->query($qry);
	$result=$result->result_array();
	if(count($result)>0){
	//return $result;
	for($i=0;$i<count($result);$i++){
	$driver[$i]['app_key']=$result[$i]['app_key'];
	}
	return $driver;
	}else{
	return false;
	}
	
	}


	



	function engageAllDrivers(){
	
	$qry = "UPDATE drivers as D LEFT JOIN trips as T ON T.driver_id=D.id  SET D.driver_status_id = ".DRIVER_STATUS_ENGAGED." WHERE  TIMEDIFF(CONCAT(T.pick_up_date,' ',T.pick_up_time), NOW() ) <= '00:30:00' AND T.trip_status_id='".TRIP_STATUS_ACCEPTED."' AND D.driver_status_id!= '".DRIVER_STATUS_DISMISSED."'  AND D.driver_status_id !='".DRIVER_STATUS_SUSPENDED."'";
	$result=$this->db->query($qry);
	
	}

	

	function  bookTrip($data) {
	
		$this->db->set('created', 'NOW()', FALSE);
		$this->db->insert('trips',$data);
		if($this->db->insert_id()>0){
			return $this->db->insert_id();
		}else{
			return false;
		}
	 
    }	


	function  updateTrip($data,$id) {
	$this->db->where('id',$id );
	$this->db->set('updated', 'NOW()', FALSE);
	$this->db->update("trips",$data);
	return true;
	}

	/**********/

	function getDetails($conditon ='',$orderby=''){

	$this->db->from('trips');
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
	

	function getVehiclesArray($condion=''){
	$this->db->from('vehicles');
	//$this->db->where('organisation_id',$org_id);
	if($condion!=''){
    $this->db->where($condion);
	}
    $results = $this->db->get()->result();
	
				//print_r($results);
		
			for($i=0;$i<count($results);$i++){
			$values[$results[$i]->id]=$results[$i]->registration_number;
			}
			if(!empty($values)){
			return $values;
			}
			else{
			return false;
			}

	}

	function getTodaysTripsDriversDetails(){
$qry='SELECT T.id,T.pick_up_date,T.pick_up_time,T.trip_from,T.trip_to,D.id as driver_id,D.name FROM trips AS T LEFT JOIN drivers AS D ON  D.id =T.driver_id  WHERE T.trip_status_id='.TRIP_STATUS_ACCEPTED.' AND  T.pick_up_date="'.date('Y-m-d').'"';

	$result=$this->db->query($qry);
	$result=$result->result_array();
	if(count($result)>0){
	return $result;
	}else{
	return false;
	}

	}




}
?>
