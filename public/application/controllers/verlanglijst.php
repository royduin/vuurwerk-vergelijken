<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verlanglijst extends Home_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if($this->input->get('producten')){
			$products = explode(',',$this->input->get('producten'));
			$data['totalshared'] = count($products);
			foreach($products as $product){
				$product = explode('-',$product);
				if(count($product) == 2){
					if(is_numeric($product[0]) AND $product[0] > 0 AND is_numeric($product[1]) AND $product[1] > 0){
						$wishlist['products'][$product[0]] = $product[1];
					} else {
						show_404();
					}
				} else {
					show_404();
				}
			}
			$temp_wishlist = $this->session->userdata('wishlist');
			$this->session->set_userdata('wishlist',$wishlist);
			$data['shared'] = true;
		}

		if($this->session->userdata('wishlist') AND isset($this->session->userdata('wishlist')['products']) AND count($this->session->userdata('wishlist')['products']))
		{
			// Get all stores for the modal
			$data['modal_winkels'] = $this->db->select('winkel_id,winkel_naam')->order_by('winkel_naam','asc')->get('winkels')->result();
			
			// Get all products by store
			$producten = $this->db->query('
				SELECT
					producten.product_id,
					naam,
					aantal,
					gram,
					tube,
					schoten,
					duur,
					hoogte,
					lengte,
					inch,
					video,
					slug,
					buitenland,
					merk_naam,
					merk_slug,
					soort_naam,
					soort_slug,
					(
						SELECT 
							MIN(ROUND(prijs / aantal,2)) as prijs
						FROM
							prijzen 
						WHERE 
							prijzen.product_id = producten.product_id AND 
							jaar = '.config_item('jaar').' AND
							gekeurd = 1
					) as prijs,
					(
						SELECT 
							IF(AVG(beoordeling) IS NULL,0,ROUND(AVG(beoordeling)))
						FROM 
							beoordelingen 
						WHERE 
							beoordelingen.product_id = producten.product_id
					) as beoordeling
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
				WHERE
					producten.product_id IN ('.implode(',',array_keys($this->session->userdata('wishlist')['products'])).')
				AND
					producten.gekeurd = 1
				ORDER BY
					soort_naam ASC, '.(in_array($this->input->get('order'),$this->allowed_to_order) ? $this->input->get('order') : 'naam').' '.(in_array($this->input->get('dir'),['asc','desc']) ? $this->input->get('dir') : 'asc').'

			')->result();

			$data['totalfound'] = count($producten);

			// Create a multidimensional array by type and calculate/generate some info
			$data['totaal_prijs'] = 0;
			$data['geen_prijs'] = 0;
			$data['link'] = [];
			foreach($producten as $product)
			{
				// Add to a new array
				$data['producten'][$product->soort_naam][] = $product;

				// Calculate total price
				$data['totaal_prijs'] += $product->prijs * $this->session->userdata('wishlist')['products'][$product->product_id];

				// Count products without a price
				if(!$product->prijs){
					$data['geen_prijs']++;
				}

				// Generate share link
				$data['link'][] = $product->product_id.'-'.$this->session->userdata('wishlist')['products'][$product->product_id];

				// Add the amount
				$product->amount = $this->session->userdata('wishlist')['products'][$product->product_id];
			}

			// Generate share link
			$data['link'] = site_url('verlanglijst?producten='.implode(',',$data['link']));

			$this->load->helper('querystring');
			$data['clean_query'] = querystring(['order','dir']);

			// Restore the temp wishlist
			if($this->input->get('producten')){
				$this->session->set_userdata('wishlist',$temp_wishlist);
			}
		}

		// Load the view
		$data['layout'] = 'verlanglijst';
		$data['page_title'] = 'Vuurwerk verlanglijst maken?';
		$data['page_descr'] = 'Maak eenvoudig een verlanglijst voor je vuurwerk aankopen ✓ Eenvoudig delen ✓ Inclusief winkel prijzen';
		$this->load->view('layout',$data);
	}

}

/* End of file verlanglijst.php */
/* Location: ./application/controllers/verlanglijst.php */