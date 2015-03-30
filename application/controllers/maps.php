<?php 
class Maps extends CI_Controller {
	public function __construct()
		{
		parent::__construct();
		
		$this->load->helper('my_helper');
		$this->load->model('trip_booking_model');
		no_cache();

		}
	public function index($param1 ='',$param2='',$param3=''){
		if($this->session_check()==true) {
		if($param1=='get-distance') {
			
			$this->getDistance();
				
		}else if($param1=='get-places') {
			
			$this->getPlaces();
				
		}else if($param1=='get-latlng'){

			$this->getLatLng();
		}else if($param1=='get-markers'){

			$this->getMarkers();
		}else if($param1=='get-directions'){
			$this->getDirections();
		}
	}else{
			echo 'you are not authorized access this page..';
	}
	}
		
		public function getDistance(){
		if(isset($_REQUEST['url'])) {
		$target_url=str_replace(' ', '+',$_REQUEST['url']) ;
			$data=file_get_contents($target_url);
			$decode = json_decode($data);//print_r($data);exit;
			if(isset($decode->rows[0]->elements[0]->status) && $decode->rows[0]->elements[0]->status!='NOT_FOUND') {
			$jsondata['distance']=$decode->rows[0]->elements[0]->distance->text;
			$jsondata['duration']=$decode->rows[0]->elements[0]->duration->text;
			$jsondata['No_Data']='false';
			echo json_encode($jsondata);
			}
		else{
			$jsondata['No_Data']='true';
			echo json_encode($jsondata);
		}
		}
		}
		public function getMarkers(){
			if(isset($_REQUEST['trip_id'])){
			$trip_id=$_REQUEST['trip_id'];
			$vehicles=$this->trip_booking_model->getNotifiedVehiclesCurrentPositions($trip_id);
			
			for($index=0;$index<count($vehicles);$index++){
				$lat=$vehicles[$index]['lat'];
				$lng=$vehicles[$index]['lng'];
				$driver_name=$vehicles[$index]['name'];
				$target_url="https://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$lng."&key=".API_KEY;

				$data=file_get_contents($target_url);
				$decode = json_decode($data);//print_r($decode->results[0]);
				//$markers.='['.$lat.','.$lng.',Location :'.$decode->results[0]->formatted_address.',Driver : '.$driver_name.']';
				$markers[$index][0]=$lat;
				$markers[$index][1]=$lng;
				$markers[$index][2]='Location :'.$decode->results[0]->formatted_address.',Driver : '.$driver_name;
				
				
			}

			echo json_encode($markers);


			}
		}
		public function getDirections(){
			if(isset($_REQUEST['trip_id'])){
			$trip_id=$_REQUEST['trip_id'];
			$trip_directions=$this->trip_booking_model->getTripDirections($trip_id);
			
			//print_r($trip_directions);exit;

			echo json_encode($trip_directions);


			}
		}
		public function getPlaces(){
			if(isset($_REQUEST['url']) && isset($_REQUEST['insert_to'])) {
			$target_url=$_REQUEST['url'];
			$jsondata ='';
				$data=file_get_contents($target_url);
				$decode = json_decode($data);//print_r($decode);exit;
				if(isset($decode->status) && $decode->status!='ZERO_RESULTS') {
				for($jsondata_index=0;$jsondata_index<count($decode->predictions);$jsondata_index++){
				$place=explode(",", $decode->predictions[$jsondata_index]->description);
				$jsondata.='<li><a class="drop-down-places" place='.$place[0].' insert_to="'.$_REQUEST['insert_to'].'">'.$decode->predictions[$jsondata_index]->description.'</a></li><li class="divider"></li>';
				}
				echo $jsondata;
				}
				}
			else{
				$jsondata='false';
				echo $jsondata;
			}
		
		}

		public function getLatLng(){
		if(isset($_REQUEST['url'])) {
			$target_url=$_REQUEST['url'];
			$jsondata ='';
				$data=file_get_contents($target_url);
				$decode = json_decode($data);
				$jsondata['lat']=$decode->results[0]->geometry->location->lat;
				$jsondata['lng']=$decode->results[0]->geometry->location->lng;
				echo json_encode($jsondata);
				}else{
				$jsondata='false';
				echo $jsondata;
			}
		
		}
	
		
		public function session_check() {
	if(($this->session->userdata('isLoggedIn')==true ) && ($this->session->userdata('type')==FRONT_DESK)) {
		return true;
		} else {
		return false;
		}
	} 
}
