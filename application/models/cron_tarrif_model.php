<?php 
class Cron_Tarrif_model extends CI_Model {


	public function insertDriverPayment($data){
	//print_r($data);exit;
	$tbl="driver_payment";
	$this->db->set('created', 'NOW()', FALSE);
	$this->db->insert($tbl,$data);
	return true;
	}


	function getDriverPayment(){
		$qry='SELECT GREATEST(T.distance_in_km_from_app,T.distance_in_km_from_web) as G_distance,T.total_amount,T.trip_status_id as Tripstatus, 
		T.trip_day_night_type_id as day_or_night,T.id as trip_id, T.driver_id as driver_id,D.name as driver_name,T.distance_in_km_from_app as Distance_app,
		T.distance_in_km_from_web as Distance_web, TF.day_rate as Day_rate,TF.night_rate as Night_rate, 
		TF.minimum_kilometers,TF.additional_kilometer_day_rate,TF.additional_kilometer_night_rate FROM trips T 
		LEFT JOIN tariffs TF ON TF.id=T.tariff_id LEFT JOIN drivers D ON D.id=T.driver_id WHERE T.trip_status_id='.TRIP_STATUS_TRIP_COMPLETED;
		$result=$this->db->query($qry);
		$result=$result->result_array();

		if(count($result)>0){
			return $result;
			//echo "<pre>"; print_r($result); echo "</pre>"; exit;
		}else{
			return false;
		}



	}

	
	
	

	}
	?>
