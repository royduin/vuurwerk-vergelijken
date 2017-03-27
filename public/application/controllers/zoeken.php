<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zoeken extends Home_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index($q = false)
	{
		if($this->input->post('q')){
			redirect(site_url('zoeken/'.url_title($this->input->post('q'),'-',TRUE)),'location',301);
		}

		if($q){
			$q = str_replace('-',' ',$q);
			$data['producten'] = $this->db->query('
				SELECT
					producten.product_id,
					producten.naam,
					producten.slug,
					merk_naam,
					merk_slug,
					soort_slug
				FROM
					producten
				JOIN
					soorten
				ON
					producten.soort_id = soorten.soort_id
				JOIN
					merken
				ON
					producten.merk_id = merken.merk_id
				JOIN
					importeurs
				ON
					producten.importeur_id = importeurs.importeur_id
				WHERE
					gekeurd = 1 
				AND (
					product_id='.$this->db->escape($q).' OR
					artikelnummer LIKE "%'.$this->db->escape_like_str($q).'%" OR
					naam LIKE "%'.$this->db->escape_like_str($q).'%" OR
					slug LIKE "%'.$this->db->escape_like_str($q).'%" OR
					nieuw='.$this->db->escape($q).' OR
					omschrijving LIKE "%'.$this->db->escape_like_str($q).'%" OR
					soort_naam LIKE "%'.$this->db->escape_like_str($q).'%" OR
					soort_naam_enkel LIKE "%'.$this->db->escape_like_str($q).'%" OR
					soort_slug LIKE "%'.$this->db->escape_like_str($q).'%" OR
					soort_omschrijving_kort LIKE "%'.$this->db->escape_like_str($q).'%" OR
					soort_omschrijving_lang LIKE "%'.$this->db->escape_like_str($q).'%" OR
					merk_naam LIKE "%'.$this->db->escape_like_str($q).'%" OR
					merk_slug LIKE "%'.$this->db->escape_like_str($q).'%" OR
					merk_omschrijving LIKE "%'.$this->db->escape_like_str($q).'%" OR
					importeur_naam LIKE "%'.$this->db->escape_like_str($q).'%" OR
					importeur_slug LIKE "%'.$this->db->escape_like_str($q).'%"
				)
			')->result();

			$data['importeurs'] = $this->db->query('
				SELECT
					importeur_naam,
					importeur_slug
				FROM
					importeurs
				WHERE
					importeur_naam LIKE "%'.$this->db->escape_like_str($q).'%" OR
					importeur_slug LIKE "%'.$this->db->escape_like_str($q).'%"
			')->result();

			$data['winkels'] = $this->db->query('
				SELECT
					winkel_naam,
					slug
				FROM
					winkels
				WHERE
					winkel_naam LIKE "%'.$this->db->escape_like_str($q).'%" OR
					slug LIKE "%'.$this->db->escape_like_str($q).'%" OR
					website LIKE "%'.$this->db->escape_like_str($q).'%" OR
					omschrijving LIKE "%'.$this->db->escape_like_str($q).'%"
			')->result();
		}

		// Set information for the view
		$data['layout'] 	= 'zoeken';
		$data['page_title'] = 'Vuurwerk zoeken';
		$data['page_descr'] = '';
		$data['noindex']	= true;

		// Load the view
		$this->load->view('layout',$data);
	}

}

/* End of file zoeken.php */
/* Location: ./application/controllers/zoeken.php */