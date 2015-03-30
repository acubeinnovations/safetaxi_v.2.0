<?php
class notifications extends CI_Model {

	public function tripNotifications($app_key){
		
		$strSQL = "SELECT * FROM notifications WHERE app_key = '".$app_key."' AND notification_type_id=".NOTIFICATION_TYPE_NEW_TRIP." AND notification_status_id=".gINVALID." AND  notification_view_status_id=".NOTIFICATION_NOT_VIEWED_STATUS." ORDER BY id DESC LIMIT 1";
		$rsRES = $this->db->query($strSQL);
		$rsRES=$rsRES->result_array();
		if(count($rsRES)>0){
			return $rsRES;
		}else{
			
			return false;
		}

	}
	
	public function tripCancelNotifications($app_key){
		
		$strSQL = "SELECT trip_id,id FROM notifications WHERE app_key = '".$app_key."' AND notification_type_id=".NOTIFICATION_TYPE_TRIP_CANCELLED." AND notification_status_id=".gINVALID." AND  notification_view_status_id=".NOTIFICATION_NOT_VIEWED_STATUS." ORDER BY id";
		$rsRES = $this->db->query($strSQL);
		$rsRES=$rsRES->result_array();
		if ( count($rsRES) >= 1 ){
			$i=0;
			$data=array('notification_status_id'=>NOTIFICATION_STATUS_RESPONDED,'notification_view_status_id'=>NOTIFICATION_VIEWED_STATUS);
			//return mysqli_fetch_row($rsRES);
			for($i=0;$i<count($rsRES);$i++){
			$trips[$i]=array('tid'=>$rsRES[$i]->trip_id);	
			$this->updateNotifications($data,$rsRES[$i]->id);
			}
			return $trips;

		}else{
			
			return false;

		}
		
	}


	public function tripUpdateNotifications($app_key){
		
		$strSQL = "SELECT trip_id,id FROM notifications WHERE app_key = '".$app_key."' AND notification_type_id=".NOTIFICATION_TYPE_TRIP_UPDATE." AND notification_status_id=".gINVALID." AND  notification_view_status_id=".NOTIFICATION_NOT_VIEWED_STATUS." ORDER BY id";
		$rsRES = $this->db->query($strSQL);
		$rsRES=$rsRES->result_array();
		if ( count($rsRES) >= 1 ){
			$i=0;
			$data=array('notification_status_id'=>NOTIFICATION_STATUS_RESPONDED,'notification_view_status_id'=>NOTIFICATION_VIEWED_STATUS);
			for($i=0;$i<count($rsRES);$i++){
				$trips[$i]=array('tid'=>$rsRES[$i]->trip_id);	
				$this->updateNotifications($data,$rsRES[$i]->id);
			}
			return $trips;
		}else{
			
			return false;
		}
		
	}

	public function reccurenttrips($app_key){
		
		$strSQL = "SELECT N.trip_id as tid,N.id as nid,T.trip_from as fr,T.trip_to as 'to',UNIX_TIMESTAMP(CONCAT(T.pick_up_date,' ',T.pick_up_time)) as sec,C.name as cn,C.mobile as cm FROM notifications as N LEFT JOIN trips as T ON T.id=N.trip_id LEFT JOIN customers as C ON C.id=T.customer_id WHERE app_key = '".mysqli_real_escape_string($this->connection,$app_key)."' AND notification_type_id=".NOTIFICATION_TYPE_TRIP_RECCURENT." AND notification_status_id=".gINVALID." AND  notification_view_status_id=".NOTIFICATION_NOT_VIEWED_STATUS." ORDER BY N.id";
		$rsRES = $this->db->query($strSQL);
		$rsRES=$rsRES->result_array();
		if ( count($rsRES) >= 1 ){
			$i=0;
			$data=array('notification_status_id'=>NOTIFICATION_STATUS_RESPONDED,'notification_view_status_id'=>NOTIFICATION_VIEWED_STATUS);
			for($i=0;$i<count($rsRES);$i++){
			$customer['cn']		=	$rsRES[$i]->cn;
			$customer['cm']		=	$rsRES[$i]->cm;
			$trips[$i]['tid']	=	$rsRES[$i]->tid;	
			$trips[$i]['nid']	=	$rsRES[$i]->nid;
			$trips[$i]['fr']	=	$rsRES[$i]->fr;
			$trips[$i]['to']	=	$rsRES[$i]->to;
			$trips[$i]['sec']	=	$rsRES[$i]->sec*1000;
			$this->updateNotifications($data,$rsRES[$i]->nid);
			
			}
			$rtrips['customer']=$customer;
			$rtrips['trips']=$trips;
			return $rtrips;
		}else{
			
			return false;
		}
		
	}

	public function commonmsgNotifications($app_key){
		
		$strSQL = "SELECT id,message FROM notifications WHERE app_key = '".$app_key."' AND notification_type_id=".NOTIFICATION_TYPE_COMMON_MSGS." AND notification_status_id=".gINVALID." AND  notification_view_status_id=".NOTIFICATION_NOT_VIEWED_STATUS." ORDER BY id";
		$rsRES = $this->db->query($strSQL);
		$rsRES=$rsRES->result_array();
		if ( count($rsRES) >= 1 ){
			$i=0;
			$data=array('notification_status_id'=>NOTIFICATION_STATUS_RESPONDED,'notification_view_status_id'=>NOTIFICATION_VIEWED_STATUS);
			for($i=0;$i<count($rsRES);$i++){
			
			$cmsgs[$i]=$rsRES[$i]->message;	
			$this->updateNotifications($data,$rsRES[$i]->id);
			
			}
			return $cmsgs;
		}else{
			
			return false;
		}
		
	}

	public function paymentNotifications($app_key){
		
		$strSQL = "SELECT id,message FROM notifications WHERE app_key = '".mysqli_real_escape_string($this->connection,$app_key)."' AND notification_type_id=".NOTIFICATION_TYPE_PAYMENT_MSGS." AND notification_status_id=".gINVALID." AND  notification_view_status_id=".NOTIFICATION_NOT_VIEWED_STATUS." ORDER BY id";
		$rsRES = $this->db->query($strSQL);
		$rsRES=$rsRES->result_array();
		if ( count($rsRES) >= 1 ){
			$i=0;
			$data=array('notification_status_id'=>NOTIFICATION_STATUS_RESPONDED,'notification_view_status_id'=>NOTIFICATION_VIEWED_STATUS);
			for($i=0;$i<count($rsRES);$i++){
			
			$pmsgs[$i]=$rsRES[$i]->message;	
			$this->updateNotifications($data,$rsRES[$i]->id);
			
			}
			return $pmsgs;
		}else{
			
			return false;
		}
		
	}
	

	public function updateNotifications($dataArray = array(),$id) {
		if($dataArray){
			$i=0;
			$strSQL = "UPDATE  notifications SET ";
			foreach($dataArray as $key=>$value){
				$strSQL .= $key."='".$value;
				if(count($dataArray)-1>$i){
				$strSQL .="',";
				}else{
				$strSQL .="'";
				}
				$i++;
			}
			$strSQL .=" WHERE id='".$id."'";

			//$strSQL = substr($strSQL,0,-1);

			$$rsRES = $this->db->query($strSQL);
			
			if($this->db->affected_rows() == 1){
				
				return true;
			}else{
				return false;
			}	
		}else{
			
			return false;
		}
	}


}
