<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captcha extends CI_Controller {
function index(){

$code = $this->captchaimage->generateCaptcha();
$this->session->set_userdata(array('captcha_code'=> $code));
}
}
