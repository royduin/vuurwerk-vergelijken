<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_Controller extends CI_Controller {

	protected $soorten;

	protected $allowed_to_order = ['naam','aantal','gram','tube','schoten','duur','hoogte','lengte','inch','prijs','beoordeling'];

    public function __construct()
    {
        parent::__construct();

        // Get all product types for the menu and set the ID as the key
		foreach($this->db->order_by('soort_volgorde','asc')->get('soorten')->result() as $soort){
			$soorten[$soort->soort_id] = $soort;
		}
		$data['soorten'] = $this->soorten = $soorten;

		// Get all importers for the footer
		$data['footer_importeurs'] = $this->db->order_by('importeur_naam','random')->get('importeurs',10,0)->result();

		// Get all provinces
		$data['footer_provincies'] = $this->db->distinct()->select('provincie')->order_by('provincie','asc')->get('filialen')->result();

		// Load as default view data
		$this->load->vars($data);

		// Load the ion auth library
		$this->load->library('ion_auth');
    }
}

class Admin_Controller extends Home_Controller {

	public function __construct()
	{
		parent::__construct();

		// Not a admin?
		if(!$this->ion_auth->is_admin()){
			show_404();
		}
	}
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */