<?php
class user_model extends CI_Model {
	
	function LoginAttemptsChecks($username) {
		$this->db->from('users');
        $this->db->where('username',$username );
		$login = $this->db->get()->result();
		$this->db->from('user_login_attempts');
		if(count($login) > 0){
        $this->db->where('user_id',$login[0]->id);
        $login_attempts = $this->db->get()->result();
		 if (count( $login_attempts) >= 3 ) {
			$this->session->set_userdata(array('isloginAttemptexceeded'=>true));
			$this->session->set_userdata(array('loginAttemptcount'=>count($login_attempts)));
		}else{
			$this->session->set_userdata(array('isloginAttemptexceeded'=>false));
		}
		}
	}
	
	function UserLogin( $username, $password ) {
        $this->db->from('users');
        $this->db->where('username',$username );
		//$user_type_condition='user_type_id = '.ORGANISATION_ADMINISTRATOR.' OR user_type_id = '.FRONT_DESK.' AND user_status_id='.USER_STATUS_ACTIVE;
		//$this->db->where($user_type_condition);
        $this->db->where( 'password', md5($password) );
        $login = $this->db->get()->result();

       
        if ( is_array($login) && count($login) == 1 ) {
			
            $this->details = $login[0];
			if($this->details->user_type_id==FRONT_DESK){
				if($this->details->user_status_id==USER_STATUS_ACTIVE){
					$this->set_session();
          			  return true;
				}else{
				 $this->mysession->set('user_status_error','User is Not Active.');
				return false;
				}
			}else{
				$this->mysession->set('user_type_error','Please Login with  Front desk credentials.');
				return false;
			}
            
        }else{
		$this->mysession->set('password_error','Entered Password is Incorrect');
        return false;
		}
    }

	function clearLoginAttempts($username){
		$tables = array('user_login_attempts');
		$this->db->where('user_id',$this->session->userdata('id'));
		$this->db->delete($tables);

	}
	function recordLoginAttempts($username,$ip_address) {
		$this->db->from('users');
        $this->db->where('username',$username );
		$login = $this->db->get()->result();
		$this->db->from('user_login_attempts');
		if(count($login) > 0){
		$data=array('user_id'=>$login[0]->id,'ip_address'=>$ip_address);
		$this->db->set('created', 'NOW()', FALSE);
		$this->db->insert('user_login_attempts',$data);
		}

	}
	function set_session() {
        $this->session->set_userdata( array(
                'id'=>$this->details->id,
                'name'=> $this->details->first_name . ' ' . $this->details->last_name,
                'email'=>$this->details->email,
				'username'=>$this->details->username,
				'type'=>$this->details->user_type_id,
				'isLoggedIn'=>true,
				'token_pass' =>$this->details->password
            )
        );
    }
    var $details;
	function getProfile(){
	$this->db->from('users');
	$this->db->where('id',$this->session->userdata('id'));
	return $this->db->get()->result();
    }
	function updateProfile($data){
		$this->db->where('id',$this->session->userdata('id') );
		$succes=$this->db->update('users',$data);
		if($succes > 0) {
		$this->session->set_userdata(array('dbSuccess'=>'Profile Updated Successfully'));
		}
		return true;
    }
   	function changePassword($data) {
		$this->db->from('users');
        $this->db->where('id',$this->session->userdata('id'));
        $this->db->where( 'password', $data['old_password']);
        $changepassword = $this->db->get()->result();
		if ( is_array($changepassword) && count($changepassword) == 1 ) {
			$dbdata=array('password'=>$data['password']);
			$this->db->where('id',$this->session->userdata('id') );
			$succes=$this->db->update('users',$dbdata);
			if($succes > 0) {
			$this->session->set_userdata(array('dbSuccess'=>'Password changed Successfully'));
			$this->session->set_userdata(array('dbError'=>''));
			return true;
			}
		}else{
			$this->session->set_userdata(array('dbError'=>'Current Password seems to be different'));
			return false;
		}

   	}
	public function getPageId($page){
	$this->db->from('pages');
    $this->db->where('name',$page);
	$pagedetails=$this->db->get()->result();
		if(!empty($pagedetails)){
				return $pagedetails[0]->id;
		}else{
			return false;	
		}
	}
	public function getPageIds($id){
	$this->db->from('users');
    $this->db->where('id',$id);
	$userdetails=$this->db->get()->result();
		if(!empty($userdetails)){
				return $userdetails[0]->page_ids;
		}else{
			return false;	
		}
	}
	public function getArray($tbl){
	
	$flag=0;
	if($tbl=='drivers'){
	$query='SELECT * FROM drivers';
	$qry=$this->db->query($query);
	}
	
	else{
		//$qry=$this->db->where('organisation_id',$org_id);
		$qry=$this->db->order_by("name", "Asc"); 
		$qry=$this->db->get($tbl);
		
		}
		$count=$qry->num_rows();
			$l= $qry->result_array();
		
			for($i=0;$i<$count;$i++){
			if($flag==0){
			$values[$l[$i]['id']]=$l[$i]['name'];
			}
			else if($flag==1){
			$values[$l[$i]['id']]=$l[$i]['name'];
			}
			}
			if(!empty($values)){
			return $values;
			}
			else{
			return false;
			}
			
	}
  
	
	public function getAll_tarrifDetails(){
	$qry=$this->db->get('tariffs');
	$count=$qry->num_rows();
	$result=$qry->result_array();
	return $result;
	
	
	}
	public function getTarrif_masters(){
	//$this->db->where('organisation_id',$this->session->userdata('organisation_id') );
	//$this->db->where('user_id',$this->session->userdata('id') );
	$qry=$this->db->get('tariff_masters');
	$count=$qry->num_rows();
	$l= $qry->result_array();
	for($i=0;$i<$count;$i++){
			$values[$l[$i]['id']]=$l[$i]['title'];
			}
			if(!empty($values)){
			return $values;
			}
			else{
			return false;
			}
	}
	
	public function getDriverList(){
	$qry=$this->db->select('id,name,phone,mobile');
	//$qry=$this->db->where('organisation_id',$organisation_id);
	$qry=$this->db->get('drivers');
	$count=$qry->num_rows();
	return $qry->result_array();
	 
	}
	public function getVehicleDetails($id){
	$query="SELECT vehicles.registration_number,vehicles.vehicle_model_id FROM `vehicles` INNER JOIN vehicle_drivers where vehicles.id=vehicle_drivers.vehicle_id and vehicle_drivers.driver_id='.$id.' and vehicle_drivers.to_date='9999-12-30'";
	$qry=$this->db->query($query);
	return $qry->row_array();
	}
   public function getDriverDetails($arry){
   $qry=$this->db->where($arry);
   $qry=$this->db->get('drivers');
   return $qry->row_array();
   
   }
   public function getType($id){
   $qry=$this->db->select('id,name,phone,mobile');
   }
   public function getRecordsById($tbl,$id){ 
   if($tbl=='vehicles'){
   $to_date='9999-12-30';
   $qry=$this->db->where(array('vehicle_id'=>$id,'to_date'=>$to_date));
   $qry=$this->db->get('vehicle_drivers'); 
   $result['driver']= $qry->row_array();
   $dev_qry=$this->db->where(array('vehicle_id'=>$id,'to_date'=>$to_date));
   $dev_qry=$this->db->get('vehicle_devices'); 
   $result['device']= $dev_qry->row_array();
   }
	$v_qry=$this->db->where('id',$id);
	$v_qry=$this->db->get($tbl);
	$result['vehicle']= $v_qry->row_array();
	return $result;
}
	public function getDriverNameById($param2){
	$qry=$this->db->select('name');
	$qry=$this->db->where('id',$param2);
	$qry=$this->db->get('drivers');

	return $qry->row_array();
	}
	public function getDeviceImeiById($param2){
	$qry=$this->db->select('imei');
	$qry=$this->db->where('id',$param2);
	$qry=$this->db->get('devices');

	return $qry->row_array();
	}
	public function getInsurance($id){
	$qry=$this->db->where('id',$id);
	$qry=$this->db->get('vehicles_insurance');
	return $qry->row_array();
	
	}
	public function getLoan($id){
	$qry=$this->db->where('id',$id);
	$qry=$this->db->get('vehicle_loans');
	return $qry->row_array();
	
	}
	public function getOwner($id){
	$qry=$this->db->where('id',$id);
	$qry=$this->db->get('vehicle_owners');
	return $qry->row_array();
	
	}
	public function getValues($tbl,$id){
	$qry=$this->db->select('name');
	$qry=$this->db->where('id',$id);
	$qry=$this->db->get($tbl);
	return $qry->result_array();
	
	}
	public function getOwnerDetails($id){
	$qry=$this->db->select('mobile,address');
	$qry=$this->db->where('id',$id);
	$qry=$this->db->get('vehicle_owners');
	return $qry->row_array();
	}
	
}
