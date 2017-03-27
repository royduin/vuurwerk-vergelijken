<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		// Load the form validation library
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');
	}

	public function index()
	{
		// Set information for the view
		$data['layout'] 	= 'admin/home';
		$data['page_title']	= 'Beheer';

		// Load the view
		$this->load->view('layout',$data);
	}

	public function addproduct()
	{
		// Set the validation rules
		$this->form_validation->set_rules('naam', 'naam', 'required|max_length[255]|trim');
		$this->form_validation->set_rules('slug', 'slug', 'required|max_length[255]|alpha_dash|trim');
		$this->form_validation->set_rules('artikelnummer', 'artikelnummer', 'required|max_length[255]|trim');
		$this->form_validation->set_rules('nieuw', 'nieuw in jaar', 'exact_length[4]|is_natural_no_zero|trim');
		$this->form_validation->set_rules('buitenland', 'buitenland', '');
		$this->form_validation->set_rules('soort_id', 'soort', 'required|is_natural_no_zero');
		$this->form_validation->set_rules('merk_id', 'merk', 'required|is_natural_no_zero');
		$this->form_validation->set_rules('importeur_id', 'importeur', 'required|is_natural_no_zero');

		if($this->input->post('soort_id') && isset($this->soorten[$this->input->post('soort_id')]))
		{
			$data['specs'] = explode(',',$this->soorten[$this->input->post('soort_id')]->soort_specificaties);
			foreach($data['specs'] as $spec)
			{
				switch($spec)
				{
					case 'aantal':
						$this->form_validation->set_rules('aantal', 'aantal', 'required|is_natural_no_zero|trim');
						break;
					case 'gram':
						$this->form_validation->set_rules('gram', 'gram', 'callback__numeric_or_decimal|trim');
						break;
					case 'tube':
						$this->form_validation->set_rules('tube', 'tube', 'callback__numeric_or_decimal|trim');
						break;
					case 'schoten':
						$this->form_validation->set_rules('schoten', 'schoten', 'required|is_natural_no_zero|trim');
						break;
					case 'duur':
						$this->form_validation->set_rules('duur', 'duur', 'is_natural_no_zero|trim');
						break;
					case 'hoogte':
						$this->form_validation->set_rules('hoogte', 'hoogte', 'is_natural_no_zero|trim');
						break;
					case 'lengte':
						$this->form_validation->set_rules('lengte', 'lengte', 'is_natural_no_zero|trim');
						break;
					case 'inch':
						$this->form_validation->set_rules('inch', 'inch', 'required|callback__numeric_or_decimal|trim');
						break;
				}
			}
		}

		$this->form_validation->set_rules('video', 'video', 'trim|callback__youtube_check');
		$this->form_validation->set_rules('omschrijving', 'omschrijving', 'trim');
		$this->form_validation->set_rules('afbeelding', 'afbeelding', 'trim|callback__image_downloadable');

		// Form submitted?
		if($this->form_validation->run() )
		{
			// Insert into the database
			$this->db->insert('producten',[
				'soort_id'			=> $this->input->post('soort_id'),
				'artikelnummer'		=> $this->input->post('artikelnummer'),
				'naam'				=> $this->input->post('naam'),
				'slug'				=> $this->input->post('slug'),
				'merk_id'			=> $this->input->post('merk_id'),
				'importeur_id'		=> $this->input->post('importeur_id'),
				'aantal'			=> $this->input->post('aantal') ?: NULL,
				'gram'				=> $this->input->post('gram') ? (float)number_format(str_replace(',','.',$this->input->post('gram')),2,'.','') : NULL,
				'tube'				=> $this->input->post('tube') ? (float)number_format(str_replace(',','.',$this->input->post('tube')),2,'.','') : NULL,
				'schoten'			=> $this->input->post('schoten') ?: NULL,
				'duur'				=> $this->input->post('duur') ?: NULL,
				'hoogte'			=> $this->input->post('hoogte') ?: NULL,
				'lengte'			=> $this->input->post('lengte') ?: NULL,
				'inch'				=> $this->input->post('inch') ? (float)number_format(str_replace(',','.',$this->input->post('inch')),2,'.','') : NULL,
				'nieuw'				=> $this->input->post('nieuw') ?: NULL,
				'buitenland'		=> $this->input->post('buitenland') ?: 0,
				'video'				=> $this->input->post('video') != 'http://www.youtube.com/watch?v=' ? str_replace('https','http',$this->input->post('video')) : '',
				'omschrijving'		=> $this->input->post('omschrijving'),
				'gebruiker_id'		=> $this->ion_auth->logged_in() ? $this->session->userdata('user_id') : 0,
				'gekeurd'			=> 1
			]);

			// Image given?
			if($this->input->post('afbeelding'))
			{
				// Load the image helper
				$this->load->helper('image_helper');

				// Download the image
				download_image($this->db->insert_id(),$this->input->post('slug'),$this->input->post('afbeelding'));
			}

			// Show the success message
			$this->session->set_flashdata('success',true);

			// Redirect
			redirect(current_url());
		}

		// Set information for the view
		$data['layout'] 		= 'admin/addproduct';
		$data['merken']			= $this->db->order_by('merk_naam','asc')->get('merken')->result();
		$data['importeurs']		= $this->db->order_by('importeur_naam','asc')->get('importeurs')->result();
		$data['page_title'] 	= 'Product toevoegen';

		// Load the view
		$this->load->view('layout',$data);
	}

	public function addimage()
	{
		$this->form_validation->set_rules('id', 'Product ID', 'required|is_natural_no_zero'); // TODO: Check if the product exists
		$this->form_validation->set_rules('afbeelding', 'Afbeelding', 'required|trim|callback__image_downloadable');

		// Form submitted?
		if($this->form_validation->run() )
		{
			// Load the image helper
			$this->load->helper('image_helper');

			// Download the image
			download_image($this->input->post('id'),$this->db->get_where('producten',['product_id' => $this->input->post('id')])->row()->slug,$this->input->post('afbeelding'));

			// Show the success message
			$this->session->set_flashdata('success',true);

			// Redirect
			redirect(current_url());
		}

		// Set information for the view
		$data['layout'] 	= 'admin/addimage';
		$data['page_title'] = 'Afbeelding toevoegen';

		// Load the view
		$this->load->view('layout',$data);
	}

	public function search($term = false)
	{
		if($term){
			$url = file_get_contents('https://www.google.nl/search?q='.$term);
			$url = str_replace('/url?q=','https://www.google.nl/url?q=',$url);
			$url = str_replace('target="_blank"','',$url);
			echo $url;
		} else {
			$this->load->view('admin/search');
		}
	}

	function _youtube_check($url)
	{
		if($url){
			$url = parse_url($url);
			if(!isset($url['host']) OR $url['host'] != 'www.youtube.com' OR !isset($url['path']) OR $url['path'] != '/watch' OR !isset($url['query']) OR strstr($url['query'],'v=') == FALSE OR str_replace('v=','',$url['query']) == ''){
				$this->form_validation->set_message('_youtube_check', 'Dit is geen geldige Youtube video link (http://www.youtube.com/watch?v=xxxxxx)');
				return false;
			}
		}
		return true;
	}

	function _image_downloadable($url)
	{
		if($url){
			$image = @file_get_contents($url);
			if(!$image){
				$this->form_validation->set_message('_image_downloadable', 'De afbeelding kan niet gedownload worden');
				return false;
			}
			$image = @imagecreatefromstring($image);
			if(!$image){
				@imagedestroy($image);
				$this->form_validation->set_message('_image_downloadable', 'Dit is geen afbeelding');
				return false;
			}
			@imagedestroy($image);
			$size = @getimagesize($url);
			if(!$size OR $size[0] < 300 OR $size[1] < 300){
				$this->form_validation->set_message('_image_downloadable', 'Deze afbeelding is te klein (onder de 300 pixels hoog of breed)');
				return false;
			}
		}
		return true;
	}

	function _numeric_or_decimal($string)
	{
		if($string != ''){
			$string = (float)str_replace(',','.',$string);
			if($string <= 0){
				$this->form_validation->set_message('_numeric_or_decimal', 'De waarde dient een nummer en hoger dan 0 te zijn.');
				return false;
			}
			if(strstr($string,'.') !== FALSE){
				$decimals = strlen(explode('.',$string)[1]);
				if($decimals > 2){
					$this->form_validation->set_message('_numeric_or_decimal', 'Er mogen maar 2 decimalen achter de komma');
					return false;	
				}
			}
		}
		return true;
	}

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */