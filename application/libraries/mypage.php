<?php 
class  Mypage{



function paging($tbl,$per_page,$offset='',$baseurl,$Uriseg,$custom='',$qry='',$parameters=''){
		$CI = & get_instance();
		$CI->load->model('page_model');
		$config['base_url'] = $baseurl; 
		$config['per_page']=$per_page;
		$config['uri_segment'] = $Uriseg;
		if($tbl!='' && $custom=='' && $qry=='' ){
			$count=$CI->page_model->getCount($tbl);
			$config['total_rows'] =$count;
			$data['values']=$CI->page_model->getDetails($tbl,$config['per_page'],$offset,$qry);

		}else if($tbl=='' && $custom=='yes' && $qry!='' ) { 
		
			$count=$CI->page_model->getCustomCount($qry); 
			$config['total_rows'] =$count;  //echo $offset;exit;
			$data['values']=$CI->page_model->getCustomDetails($config['per_page'],$offset,$qry);

			//print_r($data['values']); exit;
		}
		$CI->pagination->initialize($config);
		$data['page_links']=$CI->pagination->create_links($parameters);
		
		return $data;
		
}


/*function get_paging($page = 0, $per_page = 2){
		$this->load->helper('url');
        $this->load->library('table');
        $this->load->library('pagination');

        if ($this->input->get('per_page', TRUE)) {
            $per_page = $_GET['per_page'];            
            $config['per_page'] = $per_page;          
        }
        else {            
            $config['per_page'] = $per_page;            
        }
        
        $config['base_url'] = $baseurl;                
        $config['suffix'] = '?per_page='.$per_page;    
        $config['cur_page'] = 0;
        $config['total_rows'] = $this->db->get('entries')->num_rows();        
        $this->pagination->initialize($config);        
        
        $data['records'] = $this->db->get('entries', $per_page, $page);        
        $data['per_page'] = $per_page;        
        $data['page'] = $page;        
        
        
   } */
}
?>
