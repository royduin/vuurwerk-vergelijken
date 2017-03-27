<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Home_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// Set information for the view
		$data['layout'] 	= 'home';
		$data['page_descr'] = config_item('website_descr');

		// Load the view
		$this->load->view('layout',$data);
	}

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */