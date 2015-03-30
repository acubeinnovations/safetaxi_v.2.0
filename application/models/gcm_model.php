<?php

class Gcm_model extends CI_Model {
    

  public function addGcmUser($data){


	$this->db->set('created', 'NOW()', FALSE);
	$this->db->insert('gcm_users',$data);
	return $this->db->insert_id();

	}

    /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $result = mysql_query("SELECT email from gcm_users WHERE email = '$email'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed
            return true;
        } else {
            // user not existed
            return false;
        }
    }

}
?>
