<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emailer extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function adminMail($subject,$message = '')
	{
		$this->load->library('email');
		$this->email->from(config_item('email'),config_item('email_sender'));
		$this->email->to(config_item('email_to'));
		$this->email->subject('VV: '.$subject);
		$this->email->message($message);
		$this->email->send();
	}

}

/* End of file email.php */
/* Location: ./application/models/email.php */
