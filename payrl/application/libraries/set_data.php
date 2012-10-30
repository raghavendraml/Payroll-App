<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Set_data
{
	public function __construct()	
	{
		$this->CI =& get_instance();	
	}
	public function is_logged_in()
	{
		$user = $this->CI->session->userdata('logged_in',true);
		$res = (!empty($user))?1:0;
		//error_log("USER: ".$res);
		// if(!empty($user))
		// {
		// 	error_log("NOT EMPTY");
		// }
		// else
		// {
		// 	error_log("EMPTY");
		// }
		//error_log("TYPE USER: ".gettype($user));
		//error_log("USER: ".($user));
		return $res;
	}
	public function is_logout()
	{
		$this->CI->session->unset_userdata('logged_in');
		$this->CI->session->sess_destroy();
		redirect('user/login');
	}
}