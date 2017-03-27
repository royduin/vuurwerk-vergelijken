<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Producten extends Home_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index($soort_filter,$merk_filter = FALSE,$product_filter = FALSE)
	{
		// To much uri segments?
		if($this->uri->segment(4)){
			show_404();
		}

		// Get all stores for the modal
		$data['modal_winkels'] = $this->db->select('winkel_id,winkel_naam')->order_by('winkel_naam','asc')->get('winkels')->result();

		// Loop through all the types
		foreach($this->soorten as $soort)
		{
			// Check for the url slug
			if($soort->soort_slug == $soort_filter)
			{
				// Set the current type
				$data['soort'] = $soort;
			}
		}

		// Type doesn't exists?
		if(!isset($data['soort']))
		{
			// Show 404
			show_404();
		}

		// Get all brand id's by type
		if( $merken_by_soort = $this->db->query('SELECT GROUP_CONCAT(DISTINCT merk_id) as ids FROM producten WHERE soort_id = '.$data['soort']->soort_id.' AND gekeurd=1')->row()->ids )
		{
			// Get all brands by type
			$data['merken'] = $this->db->query('
				SELECT 
					merken.merk_id,
					merk_naam,
					merk_slug,
					merk_omschrijving,
					merk_omschrijving_meta,
					COUNT(product_id) as aantal_producten
				FROM 
					merken 
				JOIN
					producten
				ON
					merken.merk_id = producten.merk_id
				AND
					producten.soort_id = '.$data['soort']->soort_id.'
				AND
					producten.gekeurd = 1
				WHERE 
					merken.merk_id IN (
						'.$merken_by_soort.'
					)
				GROUP BY
					merken.merk_id
				ORDER BY
					merk_naam ASC
			')->result();
		}

		// Brand in the url?
		if($merk_filter)
		{
			// Not a number?
			if(!is_numeric($merk_filter))
			{
				// Loop through all the brands
				foreach($data['merken'] as $merk)
				{
					// Check for the url slug
					if($merk->merk_slug == $merk_filter)
					{
						// Set the current brand
						$data['merk'] = $merk;
					}
				}

				// Brand doesn't exist?
				if(!isset($data['merk']))
				{
					// Show 404
					show_404();
				}

			} else 
			{
				// Pagination
				$merk_filter = FALSE;
			}
		}

		// Product is nummeric?
		if(is_numeric($product_filter))
		{
			// Pagination
			$product_filter = FALSE;
		}

		// Product in the url?
		if($product_filter)
		{
			// Get the product
			$data['product'] = $this->db->query('
				SELECT
					*
				FROM
					producten
				JOIN
					importeurs
				ON
					importeurs.importeur_id = producten.importeur_id
				WHERE
					slug = '.$this->db->escape($product_filter).'
				AND
					soort_id = '.$data['soort']->soort_id.'
				AND
					gekeurd = 1
			')->row();

			// Product doesn't exist?
			if(!$data['product'])
			{
				// Show 404
				show_404();
			}
			
			// Loop through all the years to generate the sql for the store prices
			foreach(config_item('jaren') as $jaar)
			{
				$sql_select[] = 'SUM(IF(prijzen.jaar = '.$jaar.',prijzen.prijs,"")) as prijs'.$jaar;
				$sql_select[] = 'SUM(IF(prijzen.jaar = '.$jaar.',ROUND(prijzen.prijs / prijzen.aantal,2),"")) as staffelprijs'.$jaar;
			}

			// Get all the store prices
			$data['winkels'] = $this->db->query('
				SELECT
					winkels.winkel_id,
					winkel_naam,
					slug,
					prijzen.aantal,
					'.implode(',',$sql_select).',
					gebruiker_id,
					(
						SELECT 
							COUNT(filiaal_id)
						FROM
							filialen
						WHERE
							winkel_id = winkels.winkel_id
					) as filialen,
					affiliate,
					IF(prijzen.jaar = '.$jaar.',bron,"") as affiliate_url
				FROM 
					winkels
				JOIN
					prijzen
				ON
					prijzen.product_id = '.$data['product']->product_id.'
				AND
					prijzen.winkel_id = winkels.winkel_id
				AND
					prijzen.jaar IN ('.implode(',',config_item('jaren')).')	
				AND
					prijzen.gekeurd = 1
				GROUP BY
					winkels.winkel_id, prijzen.aantal
				ORDER BY 
					'.(in_array($this->input->get('order'),config_item('jaren')) ? 'prijs'.$this->input->get('order') : ($this->input->get('order') == 'aantal' ? 'aantal' : 'winkel_naam')).' '.(in_array($this->input->get('dir'),['asc','desc']) ? $this->input->get('dir') : 'asc').'
			')->result();

			// Get lowest and highest price
			foreach($data['winkels'] as $winkel){
				if($winkel->{'staffelprijs'.config_item('jaar')}){
					if(!isset($data['prijs_hoogste']) OR $data['prijs_hoogste'] < $winkel->{'staffelprijs'.config_item('jaar')}){
						$data['prijs_hoogste'] = $winkel->{'staffelprijs'.config_item('jaar')};
					}
					if(!isset($data['prijs_laagste']) OR $data['prijs_laagste'] > $winkel->{'staffelprijs'.config_item('jaar')}){
						$data['prijs_laagste'] = $winkel->{'staffelprijs'.config_item('jaar')};
					}
				}
			}

			// Get the rating			
			$data = array_merge($data,(array)$this->db->query('SELECT IF(AVG(beoordeling) IS NULL,0,ROUND(AVG(beoordeling),1)) as score,COUNT(beoordeling_id) as stemmen FROM beoordelingen WHERE product_id="'.$data['product']->product_id.'"')->row());

			// Load the youtube helper
			$this->load->helper('youtube');

			// Get user videos
			$data['videos'] = $this->db->query('
				SELECT
					titel,
					video
				FROM
					videos
				WHERE
					product_id='.$data['product']->product_id.'
				AND
					gekeurd=1
				ORDER BY
					titel ASC
			')->result();

			// Find similar products
			if(isset($data['prijs_laagste'])){
				$data['similars'] = $this->db->query('
					SELECT
						producten.product_id,
						naam,
						slug,
						MIN(ROUND(prijs / prijzen.aantal,2)) as prijs,
						merk_slug,
						merk_naam,
						soort_slug,
						ABS('.$data['prijs_laagste'].' - MIN(prijs / prijzen.aantal)) as nearest
					FROM 
						producten 
					JOIN
						merken
					ON
						merken.merk_id = producten.merk_id
					JOIN
						soorten
					ON
						soorten.soort_id = producten.soort_id
					JOIN
						prijzen
					ON
						producten.product_id = prijzen.product_id
					AND
						prijzen.gekeurd = 1
					WHERE
						jaar = '.config_item('jaar').'
					AND
						producten.soort_id = '.$data['soort']->soort_id.'
					AND
						producten.product_id != '.$data['product']->product_id.'
					AND
						producten.gekeurd = 1
					GROUP BY
						producten.product_id
					ORDER BY
						nearest ASC
					LIMIT
						0,4
				')->result();
			}

			// Load the thankyou helper
			$this->load->helper('thankyou');

			// Get the users who've added prices and the product
			$data['product_added'] = thankyou_product($data['product']->gebruiker_id);
			$data['prices_added'] = thankyou_price(array_unique(array_map(function($item) { return $item->gebruiker_id; }, $data['winkels']),SORT_NUMERIC));

			// Set the layout data
			$data['layout'] 		= 'product';
			$data['page_title'] 	= (!stristr($data['product']->naam,$data['merk']->merk_naam) ? html_escape($data['merk']->merk_naam).' ' : '').html_escape($data['product']->naam).($data['product']->naam == $data['product']->artikelnummer ? '' : ' - '.html_escape($data['product']->artikelnummer));
			$data['page_descr']		= 'Vergelijk de '.($data['product']->buitenland ? 'specificaties' : 'prijzen').' van de '.(!stristr($data['product']->naam,$data['merk']->merk_naam) ? html_escape($data['merk']->merk_naam).' ' : '').html_escape($data['product']->naam).(!stristr($data['product']->naam,$data['soort']->soort_naam_enkel) ? ' '.html_escape($data['soort']->soort_naam_enkel) : '').($data['product']->importeur_naam != $data['merk']->merk_naam ? ' ('.$data['product']->importeur_naam.')' : '').'.';
			$data['product_descr'][]= '<a href="'.site_url($data['soort']->soort_slug).'" title="'.ucfirst(html_escape($data['soort']->soort_naam)).'">'.ucfirst(html_escape($data['soort']->soort_naam_enkel)).'</a> van <a href="'.site_url('importeurs/'.$data['product']->importeur_slug).'" title="'.html_escape($data['product']->importeur_naam).'">'.html_escape($data['product']->importeur_naam).'</a>'.($data['product']->nieuw ? ' uit '.$data['product']->nieuw : '');
			if(isset($data['prijs_laagste'])){
				$data['page_descr']	.= ' Te koop vanaf €'.price($data['prijs_laagste']);
			}
			foreach(explode(',',$data['soort']->soort_specificaties) as $spec){
				if($data['product']->{$spec}){
					if($spec == 'aantal' AND $data['product']->{$spec} != 1){
						$data['page_descr'] 	.= ' ✓ '.$data['product']->{$spec}.' '.($data['soort']->soort_naam == 'Matten' ? 'klapper' : ($data['soort']->soort_id == 11 ? 'cakes' : 'stuks'));
						$data['product_descr'][] = $data['product']->{$spec}.' '.($data['soort']->soort_naam == 'Matten' ? 'klapper' : ($data['soort']->soort_id == 11 ? 'cakes' : 'stuks'));
					} elseif($spec == 'inch'){
						$data['page_descr'] 	.= ' ✓ '.price($data['product']->{$spec}).' inch';
						$data['product_descr'][] = price($data['product']->{$spec}).' inch';
					} elseif($spec == 'gram'){
						$data['page_descr'] 	.= ' ✓ '.price($data['product']->{$spec}).' gram';
						$data['product_descr'][] = 'totaal '.price($data['product']->{$spec}).' gram';
					} elseif($spec == 'tube'){
						$data['page_descr'] 	.= ' ✓ '.price($data['product']->{$spec}).' gram per tube';
						$data['product_descr'][] = 'gemiddeld '.price($data['product']->{$spec}).' gram per tube';
					} elseif($spec == 'schoten'){
						$data['page_descr'] 	.= ' ✓ '.$data['product']->{$spec}.' schoten';
						$data['product_descr'][] = 'met '.$data['product']->{$spec}.' schoten';
					} elseif($spec == 'duur'){
						$data['page_descr'] 	.= ' ✓ '.$data['product']->{$spec}.' seconden';
						$data['product_descr'][] = 'duurt '.$data['product']->{$spec}.' seconden';
					} elseif($spec == 'hoogte'){
						$data['page_descr'] 	.= ' ✓ '.$data['product']->{$spec}.' meter hoog';
						$data['product_descr'][] = 'de effecten komen ongeveer '.$data['product']->{$spec}.' meter hoog';
					} elseif($spec == 'lengte'){
						$data['page_descr'] 	.= ' ✓ '.$data['product']->{$spec}.' meter lang';
						$data['product_descr'][] = 'is '.$data['product']->{$spec}.' meter lang';
					}
				}
			}

		} 
		else
		{
			// Load the pagination library
			$this->load->library('pagination');

			// Load the querystring helper
			$this->load->helper('querystring');

			// Configure pagination
			if($merk_filter){
				$config['base_url'] = site_url($this->uri->segment(1).'/'.$this->uri->segment(2));
				$config['uri_segment'] = 3;
			} else {
				$config['base_url'] = site_url($this->uri->segment(1));
				$config['uri_segment'] = 2;
			}
			$config['per_page'] 	= 25;
			$config['suffix'] 		= ($_SERVER['QUERY_STRING'] ? '?'.$_SERVER['QUERY_STRING'] : '').'#producten';
			$config['first_url'] 	= $config['base_url'].$config['suffix'];

			// Page number is 0 or 1
			if($this->uri->segment($config['uri_segment']) === '0' OR $this->uri->segment($config['uri_segment']) == '1'){
				redirect($config['first_url'],'location',301);
			}

			// Calculate the offset
			$offset = (int)($this->uri->segment($config['uri_segment']) ? ($this->uri->segment($config['uri_segment']) - 1) : 0) * $config['per_page'];

			// Negative number?
			if($offset < 0){
				show_404();
			}

			// Get the min/max for the specification sliders
			$data['slider'] = $this->db->query('
				SELECT
					FLOOR(MIN(producten.aantal)) as min_aantal,
					CEIL(MAX(producten.aantal)) as max_aantal,
					FLOOR(MIN(gram)) as min_gram,
					CEIL(MAX(gram)) as max_gram,
					FLOOR(MIN(tube)) as min_tube,
					CEIL(MAX(tube)) as max_tube,
					FLOOR(MIN(schoten)) as min_schoten,
					CEIL(MAX(schoten)) as max_schoten,
					FLOOR(MIN(duur)) as min_duur,
					CEIL(MAX(duur)) as max_duur,
					FLOOR(MIN(hoogte)) as min_hoogte,
					CEIL(MAX(hoogte)) as max_hoogte,
					FLOOR(MIN(lengte)) as min_lengte,
					CEIL(MAX(lengte)) as max_lengte,
					FLOOR(MIN(inch)) as min_inch,
					CEIL(MAX(inch)) as max_inch,
					FLOOR(MIN(prijs / prijzen.aantal)) as min_prijs,
					CEIL(MAX(prijs / prijzen.aantal)) as max_prijs
				FROM
					producten
				LEFT JOIN
					prijzen
				ON
					prijzen.product_id = producten.product_id
				AND
					prijzen.gekeurd = 1
				WHERE
					soort_id = '.(int)$data['soort']->soort_id.'
				AND
					producten.gekeurd = 1
			')->row();

			// Check for specification filters
			$sql_add = [];
			foreach(explode(',',$data['soort']->soort_specificaties.',prijs') as $spec){
				if($this->input->get($spec)){
					${$spec} = explode('-',$this->input->get($spec));
					if(!isset(${$spec}[1]) || !(int)${$spec}[1] || (int)${$spec}[0] === '' || ${$spec}[0] < 0 || ${$spec}[1] > $data['slider']->{'max_'.$spec}){
						show_404();
					} else {
						$sql_add[] = 'AND IF('.$spec.' IS NULL,0,'.$spec.') BETWEEN '.$this->db->escape(${$spec}[0]).' AND '.$this->db->escape(${$spec}[1]);
					}
				}
			}

			// Get the products by type or brand
			$data['producten'] = $this->db->query('
				SELECT SQL_CALC_FOUND_ROWS
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
					/*
					(
						SELECT 
							MIN(prijs) 
						FROM
							prijzen 
						WHERE 
							prijzen.product_id = producten.product_id AND 
							jaar = '.config_item('jaar').' AND
							gekeurd = 1
					) as prijs,
					*/
					IF(prijs IS NULL,0,prijs) as prijs,
					merk_slug,
					merk_naam,
					(
						SELECT 
							IF(AVG(beoordeling) IS NULL,0,ROUND(AVG(beoordeling),1))
						FROM 
							beoordelingen 
						WHERE 
							beoordelingen.product_id = producten.product_id
					) as beoordeling
				FROM 
					producten
				JOIN
					merken
				ON
					merken.merk_id = producten.merk_id
				JOIN
					importeurs
				ON
					importeurs.importeur_id = producten.importeur_id
				LEFT JOIN
					(
						SELECT 
							product_id,
							MIN(ROUND(prijs / aantal,2)) as prijs
						FROM
							prijzen 
						WHERE 
							jaar = '.config_item('jaar').' AND
							gekeurd = 1
						GROUP BY
							product_id
					) as prijzen
				ON
					prijzen.product_id = producten.product_id
				WHERE
					soort_id = '.$data['soort']->soort_id.'
				AND
					producten.gekeurd = 1
					'.($merk_filter ? 'AND producten.merk_id = '.$data['merk']->merk_id : '').'
					'.($this->input->get('importeur') ? 'AND importeur_slug = '.$this->db->escape($this->input->get('importeur')) : '').'
					'.($this->input->get('jaar') ? 'AND nieuw = '.$this->db->escape($this->input->get('jaar')) : '').'
					'.implode(' ',$sql_add).'
				ORDER BY 
					'.(in_array($this->input->get('order'),$this->allowed_to_order) ? $this->input->get('order') : 'beoordeling').' '.(in_array($this->input->get('dir'),['asc','desc']) ? $this->input->get('dir') : 'desc').'
				LIMIT
					'.$offset.','.$config['per_page'].'
			')->result();

			// Initialize pagination
			$config['total_rows'] = $this->db->query('SELECT FOUND_ROWS() as total')->row()->total;
			$this->pagination->initialize($config);

			// Page number present but no results?
			if($offset AND $this->uri->segment($config['uri_segment']) AND empty($data['producten'])){
				redirect($soort_filter.'/'.(is_numeric($merk_filter) ? '' : $merk_filter));
			}

			// Prev and next links for the canonical
			if(!$this->uri->segment($config['uri_segment']) AND ceil($config['total_rows'] / $config['per_page']) == 1){
				// No links, just one page
			} elseif(!$this->uri->segment($config['uri_segment'])){
				$data['page_next']  = current_url().'/2';
			} elseif(ceil($config['total_rows'] / $config['per_page']) == $this->uri->segment($config['uri_segment'])) {
				$data['page_prev']  = str_replace('/'.$this->uri->segment($config['uri_segment']),'',current_url());
			} else {
				$data['page_next']  = str_replace($this->uri->segment($config['uri_segment']),$this->uri->segment($config['uri_segment'])+1,current_url());
				$data['page_prev']  = str_replace($this->uri->segment($config['uri_segment']),($this->uri->segment($config['uri_segment']) == 2 ? '' : $this->uri->segment($config['uri_segment'])-1),current_url());
			}

			// Get the importers
			$data['importeurs']	= $this->db->query('
				SELECT DISTINCT
					importeur_naam,
					importeur_slug
				FROM
					importeurs
				JOIN
					producten
				ON
					producten.importeur_id = importeurs.importeur_id
				AND
					gekeurd = 1
				WHERE
					soort_id = '.$data['soort']->soort_id.'
				ORDER BY
					importeur_naam ASC
			')->result();

			// Get the years
			$data['jaren'] = $this->db->query('
				SELECT DISTINCT
					nieuw
				FROM
					producten
				WHERE
					soort_id = '.$data['soort']->soort_id.'
				AND
					nieuw IS NOT NULL
				AND
					gekeurd = 1
				ORDER BY
					nieuw ASC
			')->result();

			// Get information for the add product modal
			$data['modal_importeurs'] 	= $this->db->order_by('importeur_naam','asc')->get('importeurs')->result();
			$data['modal_merken']		= $this->db->order_by('merk_naam','asc')->get('merken')->result();

			// Set the layout data
			$data['layout'] 		= 'producten';
			$data['pagination'] 	= $this->pagination->create_links();
			$data['base_url']		= $config['base_url'];
			$data['clean_query']	= querystring(['order','dir']);
			$data['total']			= $config['total_rows'];
			$data['cur_page']		= $this->uri->segment($config['uri_segment']) ?: 1;
			$data['total_pages']	= ceil($config['total_rows'] / $config['per_page']);
			$data['page_title'] 	= ($data['soort']->soort_vuurwerktitel ? ' '.$data['soort']->soort_naam : 'Vuurwerk '.strtolower($data['soort']->soort_naam)).(isset($data['merk']->merk_naam) ? ' van '.$data['merk']->merk_naam : '').' vergelijken';
			// $data['page_descr']	= isset($data['merk']->merk_omschrijving_meta) ? $data['merk']->merk_omschrijving_meta : $data['soort']->soort_omschrijving_meta;
			$data['page_descr']		= $merk_filter ? str_replace('eenvoudig','van '.$data['merk']->merk_naam.' eenvoudig',$data['soort']->soort_omschrijving_meta) : $data['soort']->soort_omschrijving_meta;
		}

		// Load the layout
		$this->load->view('layout',$data);
	}

}

/* End of file producten.php */
/* Location: ./application/controllers/producten.php */