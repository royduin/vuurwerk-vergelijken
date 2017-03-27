<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Exceptions extends CI_Exceptions {

	public function show_404($page = '', $log_error = true)
	{
		// Load the CI instance
		$CI =& get_instance();

		// Get all product types for the menu and set the ID as the key
		foreach($CI->db->get('soorten')->result() as $soort){
			$soorten[$soort->soort_id] = $soort;
		}

		// Set the data for the view
		$data['soorten'] = $soorten;
		$data['layout'] = '404';

		// Load as default view data
		$CI->load->vars($data);

		// Load the view
		$CI->load->view('layout');

		// Output it as 404
		$CI->output->set_status_header('404');
		echo $CI->output->get_output();
		exit;
	}
}

/* End of file MY_Exceptions.php */
/* Location: ./application/core/MY_Exceptions.php */
