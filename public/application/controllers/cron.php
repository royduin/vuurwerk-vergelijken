<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends Home_Controller {

	public function __construct()
	{
		parent::__construct();

		// No CLI request?
		if(!$this->input->is_cli_request()){
			show_404();
		}
	}

	public function index()
	{
		show_404();
	}

	public function latlng()
	{
		foreach($this->db->query('SELECT filiaal_id,adres,postcode,plaats FROM filialen WHERE lat=0 AND lng=0')->result() as $filiaal){
			
			// Create a url
			$url = 'http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($filiaal->adres.' '.$filiaal->postcode.' '.$filiaal->plaats).'&sensor=false&language=nl&region=nl';

			// Fetch results
			if($result = file_get_contents($url))
			{
				// Make it JSON
				$result = json_decode($result);

				// Status OK?
				if($result->status == 'OK')
				{
					// Fetch location
					$location = $result->results[0]->geometry->location;

					// Update in the database
					$this->db->update('filialen',array('lat' => $location->lat,'lng' => $location->lng),array('filiaal_id' => $filiaal->filiaal_id));
				}
			}
		}
	}

	public function average()
	{
		// Count average price per store
		$stores = $this->db->query('
			SELECT winkel_id, AVG(differenceForItemAndAmount) AS averageDifferenceForStore
			FROM(
				SELECT m.winkel_id, m.product_id, m.aantal, (100 * ((m.prijs - t.averagePriceForAmount) / t.averagePriceForAmount)) AS differenceForItemAndAmount
				FROM prijzen m
				JOIN(
					SELECT product_id, aantal, AVG(prijs) AS averagePriceForAmount
					FROM prijzen
					WHERE jaar='.config_item('jaar').'
					GROUP BY product_id, aantal) t ON t.product_id = m.product_id AND t.aantal = m.aantal
				WHERE jaar='.config_item('jaar').'
				GROUP BY m.winkel_id) t
			GROUP BY winkel_id;
		')->result();

		// Reset previous avarages
		$this->db->update('winkels',array('gemiddeld' => 0));

		// Update average prices
		foreach($stores as $store)
		{
			$this->db->update('winkels',array('gemiddeld' => round($store->averageDifferenceForStore)),array('winkel_id' => $store->winkel_id));
		}
	}

	public function sitemap()
	{
		$sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
		$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
		$sitemap .= '<url><loc>'.site_url().'</loc><changefreq>daily</changefreq><priority>1</priority></url>';

		// Soorten
		foreach($this->soorten as $soort)
		{
			$sitemap .= '<url><loc>'.site_url($soort->soort_slug).'</loc><changefreq>daily</changefreq><priority>0.8</priority></url>';
			
			// Merken
			if( $merken_by_soort = $this->db->query('SELECT GROUP_CONCAT(DISTINCT merk_id) as ids FROM producten WHERE soort_id = '.$soort->soort_id.'')->row()->ids )
			{
				foreach($this->db->query('SELECT merk_id,merk_slug FROM merken WHERE merk_id IN ('.$merken_by_soort.')')->result() as $merk)
				{
					$sitemap .= '<url><loc>'.site_url($soort->soort_slug.'/'.$merk->merk_slug).'</loc><changefreq>daily</changefreq><priority>0.6</priority></url>';

					// Producten
					foreach($this->db->get_where('producten',['soort_id' => $soort->soort_id,'merk_id' => $merk->merk_id,'gekeurd' => 1])->result() as $product){
						$sitemap .= '<url><loc>'.site_url($soort->soort_slug.'/'.$merk->merk_slug.'/'.$product->slug).'</loc><changefreq>always</changefreq><priority>0.4</priority></url>';
					}
				}
			}
		}

		// Winkels
		$sitemap .= '<url><loc>'.site_url('winkels').'</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>';
		foreach($this->db->get('winkels')->result() as $winkel)
		{
			$sitemap .= '<url><loc>'.site_url('winkels/'.$winkel->slug).'</loc><changefreq>daily</changefreq><priority>0.6</priority></url>';
		}

		// Importeurs
		$sitemap .= '<url><loc>'.site_url('importeurs').'</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>';
		foreach($this->db->get('importeurs')->result() as $importeur)
		{
			$sitemap .= '<url><loc>'.site_url('importeurs/'.$importeur->importeur_slug).'</loc><changefreq>daily</changefreq><priority>0.6</priority></url>';
		}

		// Verlanglijst pagina
		$sitemap .= '<url><loc>'.site_url('verlanglijst').'</loc><changefreq>weekly</changefreq><priority>0.2</priority></url>';

		// Top 10 pagina
		$sitemap .= '<url><loc>'.site_url('top-10').'</loc><changefreq>weekly</changefreq><priority>0.2</priority></url>';

		// Vuurwerkregels pagina
		$sitemap .= '<url><loc>'.site_url('vuurwerkregels').'</loc><changefreq>weekly</changefreq><priority>0.2</priority></url>';

		// Contact pagina
		$sitemap .= '<url><loc>'.site_url('contact').'</loc><changefreq>weekly</changefreq><priority>0.2</priority></url>';

		$sitemap .= '</urlset>';	

		file_put_contents(FCPATH.'/sitemap.xml', $sitemap);
	}

}

/* End of file cron.php */
/* Location: ./application/controllers/cron.php */
