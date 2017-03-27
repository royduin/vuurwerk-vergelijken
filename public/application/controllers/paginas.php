<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paginas extends Home_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// Get populair products
		$data['populair'] = $this->db->query('
			SELECT
				product_id,
				naam,
				slug,
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
				merk_slug,
				merk_naam,
				soort_slug,
				(
					SELECT 
						IF(AVG(beoordeling) IS NULL,0,AVG(beoordeling))
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
			AND
				producten.gekeurd = 1
			JOIN
				soorten
			ON
				soorten.soort_id = producten.soort_id
			ORDER BY
				beoordeling DESC
			LIMIT
				0,4
		')->result();

		// Set information for the view
		$data['layout'] 	= 'home';
		$data['page_descr'] = config_item('website_descr');

		// Load the view
		$this->load->view('layout',$data);
	}

	public function contact()
	{
		// Set information for the view
		$data['layout'] 	= 'contact';
		$data['page_title'] = 'Contact opnemen met vuurwerk-vergelijken.nl';
		$data['page_descr'] = 'Contact opnemen met vuurwerk-vergelijken.nl';
		$data['noindex']	= true;

		// Load the view
		$this->load->view('layout',$data);
	}

	public function disclaimer()
	{
		// Set information for the view
		$data['layout'] 	= 'disclaimer';
		$data['page_title'] = 'Disclaimer van vuurwerk-vergelijken.nl';
		$data['page_descr'] = 'Disclaimer van vuurwerk-vergelijken.nl';
		$data['noindex']	= true;

		// Load the view
		$this->load->view('layout',$data);
	}

	public function winkels($winkel = false)
	{
		// No store in the url?
		if(!$winkel)
		{
			// Set information for the view
			$data['layout'] 	= 'winkels';
			$data['maps']		= true;
			$data['winkels']	= [];
			$data['page_title']	= 'Alle vuurwerk winkels in Nederland';
			$data['page_descr'] = 'Al het vuurwerk van alle vuurwerk winkels in Nederland? ✓ Met de prijzen en eenvoudig te vergelijken';

			// Get all stores and create a multidimensional array from it
			$winkels = $this->db->query('
				SELECT
					filiaal_id,
					filialen.winkel_id,
					winkel_naam,
					slug,
					website,
					adres,
					postcode,
					plaats,
					provincie,
					telefoon,
					lat,
					lng,
					(
						SELECT 
							IF(AVG(beoordeling) IS NULL,0,ROUND(AVG(beoordeling),1))
						FROM 
							beoordelingen 
						WHERE 
							beoordelingen.winkel_id = winkels.winkel_id
					) as beoordeling,
					affiliate,
					gemiddeld
				FROM
					filialen
				JOIN
					winkels
				ON
					filialen.winkel_id = winkels.winkel_id
				ORDER BY
					provincie ASC, plaats ASC
			')->result();

			foreach($winkels as $winkel){
				$data['winkels'][$winkel->provincie][$winkel->filiaal_id] = $winkel;
			}
		}
		else
		{
			// Get the store data and check if it exists
			if(!$data['winkel'] = $this->db->get_where('winkels',['slug' => $winkel])->row()){
				show_404();
			}

			// Set information for the view
			$data['layout'] 	= 'winkel';
			$data['page_title']	= 'Vuurwerk bij '.$data['winkel']->winkel_naam;
			$data['page_descr'] = 'Het vuurwerk van '.$data['winkel']->winkel_naam.' in '.config_item('jaar').'? ✓ Eenvoudig vergelijken met andere vuurwerk winkels'.($data['winkel']->gemiddeld ? ' ✓ '.($data['winkel']->gemiddeld < 0 ? str_replace('-','',$data['winkel']->gemiddeld).'% goedkoper' : $data['winkel']->gemiddeld.'% duurder').' dan andere winkels' : '');

			// Get all products by store
			$producten = $this->db->query('
				SELECT
					producten.product_id,
					naam,
					slug,
					merk_naam,
					merk_slug,
					soort_naam,
					soort_slug,
					MIN(ROUND(prijs / prijzen.aantal,2)) as prijs,
					MAX(prijzen.aantal) as aantal,
					importeur_naam,
					importeur_slug
				FROM
					producten
				JOIN
					importeurs
				ON
					importeurs.importeur_id = producten.importeur_id
				JOIN
					soorten
				ON
					producten.soort_id = soorten.soort_id
				JOIN
					merken
				ON
					producten.merk_id = merken.merk_id
				JOIN
					prijzen
				ON
					producten.product_id = prijzen.product_id
				AND
					prijzen.winkel_id = '.$data['winkel']->winkel_id.'
				AND
					prijzen.gekeurd = 1
				WHERE
					jaar = '.config_item('jaar').'
				AND
					producten.gekeurd = 1
				GROUP BY
					producten.product_id
				ORDER BY
					soort_naam ASC, merk_naam ASC, naam ASC
			')->result();

			// Create a multidimensional array by type
			foreach($producten as $product)
			{
				// Add to a new array
				$data['producten'][$product->soort_naam][] = $product;
				$data['importeurs'][$product->importeur_slug] = $product->importeur_naam;
			}

			// Sort the importers
			if(isset($data['importeurs']) AND !empty($data['importeurs'])){
				asort($data['importeurs']);
			}

			// Get the rating			
			$data = array_merge($data,(array)$this->db->query('SELECT IF(AVG(beoordeling) IS NULL,0,ROUND(AVG(beoordeling),1)) as score,COUNT(beoordeling_id) as stemmen FROM beoordelingen WHERE winkel_id="'.$data['winkel']->winkel_id.'"')->row());

			// Get the stores
			$data['filialen'] = $this->db->order_by('plaats','asc')->get_where('filialen',['winkel_id' => $data['winkel']->winkel_id])->result();

		}

		// Load the view
		$this->load->view('layout',$data);
	}

	public function importeurs($importeur = false)
	{
		// No importer in the url?
		if(!$importeur)
		{
			// Set information for the view
			$data['layout'] 	= 'importeurs';
			$data['importeurs'] = $this->db->order_by('importeur_naam asc')->get('importeurs')->result();
			$data['page_title']	= 'Alle vuurwerk importeurs';
			$data['page_descr'] = 'Al het vuurwerk van alle vuurwerk importeurs? ✓ Met de prijzen van vuurwerk winkels erbij';
		}
		else
		{
			// Numeric?
			if(is_numeric($importeur)){

				// Importer exists?
				if($importeur = $this->db->get_where('importeurs',['importeur_id' => $importeur])->row()){

					// Redirect
					redirect('importeurs/'.$importeur->importeur_slug,'location',301);
				}

			// Get the importer data and check if it exists
			} elseif(!$data['importeur'] = $this->db->get_where('importeurs',['importeur_slug' => $importeur])->row()){

				// Show 404
				show_404();
			}

			// Set information for the view
			$data['layout'] 	= 'importeur';
			$data['page_title']	= $data['importeur']->importeur_naam;
			$data['page_descr'] = 'Al het vuurwerk van '.$data['importeur']->importeur_naam.' vergelijken ✓ Alle producten ✓ Prijzen van vuurwerk winkels';

			// Get all products by importer
			$producten = $this->db->query('
				SELECT
					producten.product_id,
					naam,
					slug,
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
							producten.product_id = prijzen.product_id
						AND
							prijzen.gekeurd = 1
						AND
							prijzen.jaar = '.config_item('jaar').'
					) as prijs,
					buitenland
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
					importeur_id = '.$data['importeur']->importeur_id.'
				AND
					producten.gekeurd = 1
				ORDER BY
					merk_naam ASC, naam ASC
			')->result();

			// Create a multidimensional array by brand
			foreach($producten as $product)
			{
				// Add to a new array
				$data['producten'][$product->merk_naam][] = $product;
			}
		}

		// Load the view
		$this->load->view('layout',$data);
	}

	public function top_10()
	{
		// Get all types
		$soorten = array_map(function($item) { return strtolower($item->soort_naam); }, $this->soorten);
		$soorten = join(' en ', array_filter(array_merge(array(join(', ', array_slice($soorten, 0, -1))), array_slice($soorten, -1))));

		// Set data for the view
		$data['layout'] = 'top-10';
		$data['page_title'] = 'Vuurwerk top 10';
		$data['page_descr'] = 'Opzoek naar het beste vuurwerk? Bekijk de top 10 '.$soorten;

		// Loop trough all the types
		$producten = $this->db->query('
			SELECT
				producten.product_id,
				naam,
				slug,
				merk_naam,
				merk_slug,
				soort_naam,
				soort_slug,
				(
					SELECT 
						IF(AVG(beoordeling) IS NULL,0,ROUND(AVG(beoordeling),1))
					FROM 
						beoordelingen 
					WHERE 
						beoordelingen.product_id = producten.product_id
				) as beoordeling,
				(
					SELECT 
						MIN(ROUND(prijs / aantal,2)) as prijs
					FROM
						prijzen
					WHERE
						producten.product_id = prijzen.product_id
					AND
						prijzen.gekeurd = 1
					AND
						prijzen.jaar = '.config_item('jaar').'
				) as prijs
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
				producten.gekeurd = 1
			GROUP BY
				producten.product_id
			ORDER BY
				beoordeling DESC, merk_naam ASC, naam ASC
		')->result();

		// Create a multidimensional array by type
		foreach($producten as $product)
		{
			// Add to a new array (max 10)
			if(isset($data['producten'][$product->soort_naam]) && count($data['producten'][$product->soort_naam]) == 10){
				continue;
			}
			$data['producten'][$product->soort_naam][] = $product;
		}
		
		// Load the view
		$this->load->view('layout',$data);
	}

	public function vuurwerkregels()
	{
		// Set data for the view
		$data['layout'] = 'vuurwerkregels';
		$data['page_title'] = 'Vuurwerk regels in '.config_item('jaar').'? Hier staat alles uitgelegd!';
		$data['page_descr'] = 'De vuurwerk regels voor '.config_item('jaar').' zijn gewijzigd! Lees hier waar je rekening mee moet houden!';

		// Load the view
		$this->load->view('layout',$data);
	}

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */