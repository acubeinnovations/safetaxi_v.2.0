<?php 
class Send_email{

	function emailMe($email,$subject,$message){
	$CI = & get_instance();
	$config['protocol'] = 'sendmail';
    $config['charset'] = 'iso-8859-1';
	$config['mailpath'] = '/usr/sbin/sendmail';
    $config['wordwrap'] = TRUE;
    $config['mailtype'] = 'html';
	
	$CI->email->initialize($config);
	$CI->email->from(SYSTEM_EMAIL, PRODUCT_NAME);
	$CI->email->to($email);
	$CI->email->subject($subject);
	$CI->email->message($message);
	//echo $message;
	$CI->email->send();
	 //echo $CI->email->print_debugger();
	return true;

	}

}
?>
