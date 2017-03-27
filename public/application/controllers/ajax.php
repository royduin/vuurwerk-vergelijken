<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Home_Controller {

	public function __construct()
	{
		parent::__construct();

		// No ajax request?
		if(!$this->input->is_ajax_request()){
			show_404();
		}

		// Set json content type
		$this->output->set_content_type('application/json');

		// Load the email model
		$this->load->model('emailer');
	}

	public function index()
	{
		show_404();
	}

	public function addstore()
	{
		$data = ['errors' => []];

		// Name filled?
		if(!trim($this->input->post('name'))){
			$data['errors'][] = ['field' => 'name','error' => 'Er dient een naam opgegeven te worden'];
		}

		// Website filled?
		if(!trim($this->input->post('website'))){
			$data['errors'][] = ['field' => 'website','error' => 'Er dient een website opgegeven te worden'];
		}

		// No errors?
		if(empty($data['errors']))
		{
			// Send mail (will be send as "text" so no escaping)
			$this->emailer->adminMail('Nieuwe winkel toevoegen','Naam: '.$this->input->post('name')."\nWebsite: ".$this->input->post('website'));

			$data['success'] = true;
		}

		// Echo JSON
		echo json_encode($data);
	}

	public function addprice()
	{
		$data = ['errors' => []];

		// No product given or product doesn't exist?
		if(!$this->input->post('product_id') OR !$this->db->get_where('producten',['product_id' => $this->input->post('product_id')])->num_rows()){
			show_404();
		}

		// Year doesn't match
		if(!in_array($this->input->post('jaar'),config_item('jaren'))){
			show_404();
		}

		// Store selected?
		if(!$this->input->post('store')){
			$data['errors'][] = ['field' => 'store','error' => 'Er is geen winkel gekozen'];

		// Store doesn't exist?
		} elseif(!$this->db->get_where('winkels',['winkel_id' => $this->input->post('store')])->num_rows()){
			show_404();
		}

		// Amount filled?
		if(!$this->input->post('amount')){
			$data['errors'][] = ['field' => 'amount','error' => 'Er dient een aantal ingevuld te worden'];

		// Amount not numeric?
		} elseif(!is_numeric(trim($this->input->post('amount'))) OR trim($this->input->post('amount') <= 0)){
			$data['errors'][] = ['field' => 'amount','error' => 'Dit is geen aantal'];
		}

		// Price filled?
		if(!$this->input->post('price')){
			$data['errors'][] = ['field' => 'price','error' => 'Er dient een bedrag ingevuld te worden'];

		// Price not numeric?
		} elseif(!is_numeric(str_replace(',','.',trim($this->input->post('price'))))){
			$data['errors'][] = ['field' => 'price','error' => 'Dit is geen bedrag'];
		}

		// Source filled?
		if(!trim($this->input->post('source'))){
			$data['errors'][] = ['field' => 'source','error' => 'Er dient een bron opgegeven te worden'];
		}

		// Price already present?
		if($this->db->get_where('prijzen',['product_id' => (int)$this->input->post('product_id'),'jaar' => (int)$this->input->post('jaar'),'winkel_id' => (int)$this->input->post('store'),'aantal' => (int)$this->input->post('amount')])->num_rows()){
			$data['errors'][] = ['field' => 'store','error' => 'Er is al een prijs bekend voor dit product bij deze winkel. Klopt de prijs niet? <a href="'.site_url('contact').'">Laat het ons weten</a>.'];
		}

		// No errors?
		if(empty($data['errors']))
		{
			// Insert into the database
			$this->db->insert('prijzen',[
				'product_id' 	=> (int)$this->input->post('product_id'),
				'prijs'			=> (float)str_replace(',','.',trim($this->input->post('price'))),
				'jaar'			=> (int)$this->input->post('jaar'),
				'winkel_id'		=> (int)$this->input->post('store'),
				'aantal'		=> (int)$this->input->post('amount'),
				'gekeurd'		=> $this->ion_auth->is_admin() ? 1 : 0,
				'ip_adres'		=> $this->input->ip_address(),
				'bron'			=> $this->input->post('source'),
				'gebruiker_id'	=> $this->ion_auth->logged_in() ? $this->session->userdata('user_id') : 0
			]);

			// No admin?
			if(!$this->ion_auth->is_admin())
			{
				// Send mail (will be send as "text" so no escaping)
				$this->emailer->adminMail('Nieuwe prijs keuren',$this->db->last_query());
			}

			$data['success'] = true;
		}

		// Echo JSON
		echo json_encode($data);
	}

	public function addproduct()
	{
		$data = ['errors' => []];

		// "Naam" filled?
		if(!$this->input->post('naam')){
			$data['errors'][] = ['field' => 'naam','error' => 'Er dient een naam ingevuld te worden'];
		}

		// "Artikelnummer" filled?
		if(!$this->input->post('artikelnummer')){
			$data['errors'][] = ['field' => 'artikelnummer','error' => 'Er dient een artikelnummer ingevuld te worden'];
		}

		// "Nieuw" filled?
		if(!$this->input->post('nieuw')){
			$data['errors'][] = ['field' => 'nieuw','error' => 'Er dient een jaartal ingevuld te worden'];
		
		// Nummeric and 4 chars length?
		} elseif($this->input->post('nieuw') < 1990 OR $this->input->post('nieuw') > 2100){
			$data['errors'][] = ['field' => 'nieuw','error' => 'Er dient geldig jaartal ingevuld te worden'];
		}

		// "Soort" selected?
		if(!$this->input->post('soort')){
			$data['errors'][] = ['field' => 'soort','error' => 'Er is geen soort gekozen'];

		// "Soort" doesn't exist?
		} elseif(!$this->db->get_where('soorten',['soort_id' => $this->input->post('soort')])->num_rows()){
			show_404();
		}

		// "Importeur" selected?
		if(!$this->input->post('importeur')){
			$data['errors'][] = ['field' => 'importeur','error' => 'Er is geen importeur gekozen'];

		// "Importeur" doesn't exist?
		} elseif(!$this->db->get_where('importeurs',['importeur_id' => $this->input->post('importeur')])->num_rows()){
			show_404();
		}

		// "Merk / collectie" selected?
		if(!$this->input->post('merk')){
			$data['errors'][] = ['field' => 'merk','error' => 'Er is geen merk gekozen'];

		// "Merk / collectie" doesn't exist?
		} elseif(!$this->db->get_where('merken',['merk_id' => $this->input->post('merk')])->num_rows()){
			show_404();
		}

		if($this->input->post('soort') && isset($this->soorten[$this->input->post('soort')]))
		{
			$data['specs'] = explode(',',$this->soorten[$this->input->post('soort')]->soort_specificaties);
			foreach($data['specs'] as $spec)
			{
				switch($spec)
				{
					case 'aantal':
						// "Aantal" filled?
						if(!$this->input->post($spec)){
							$data['errors'][] = ['field' => $spec,'error' => 'Er dient een aantal ingevuld te worden'];

						// Valid "aantal"?
						} elseif($this->input->post($spec) <= 0 OR !ctype_digit($this->input->post($spec))){
							$data['errors'][] = ['field' => $spec,'error' => 'Er dient geldig aantal ingevuld te worden'];
						}
						break;
					case 'gram':
						// "Gram" filled?
						if(!$this->input->post($spec)){
							if(!$this->session->flashdata('posted')){
								$data['errors'][] = ['field' => $spec,'error' => 'Gram dient ingevuld te worden, is dit nog echt onbekend? Klik dan nogmaals op "Toevoegen"'];
							}

						// Valid "gram"?
						} elseif($this->_numeric_or_decimal($this->input->post($spec))){
							$data['errors'][] = ['field' => $spec,'error' => $this->_numeric_or_decimal($this->input->post($spec))];
						}
						break;
					case 'tube':
						// "Tube" filled?
						if(!$this->input->post($spec)){
							if(!$this->session->flashdata('posted')){
								$data['errors'][] = ['field' => $spec,'error' => 'Tube dient ingevuld te worden, dit mag een gemiddelde zijn (gram, delen door het aantal schoten). Is dit nog echt onbekend? Klik dan nogmaals op "Toevoegen"'];
							}

						// Valid "tube"?
						} elseif($this->_numeric_or_decimal($this->input->post($spec))){
							$data['errors'][] = ['field' => $spec,'error' => $this->_numeric_or_decimal($this->input->post($spec))];
						}
						break;
					case 'schoten':
						// "Schoten" filled?
						if(!$this->input->post($spec)){
							$data['errors'][] = ['field' => $spec,'error' => 'Schoten dient ingevuld te worden'];

						// Valid "schoten"?
						} elseif($this->input->post($spec) <= 0 OR !ctype_digit($this->input->post($spec))){
							$data['errors'][] = ['field' => $spec,'error' => 'Er dient geldig aantal schoten ingevuld te worden'];
						}
						break;
					case 'duur':
						// "Duur" filled?
						if(!$this->input->post($spec)){
							if(!$this->session->flashdata('posted')){
								$data['errors'][] = ['field' => $spec,'error' => 'Duur dient ingevuld te worden, is dit nog echt onbekend? Klik dan nogmaals op "Toevoegen"'];
							}

						// Valid "duur"?
						} elseif($this->input->post($spec) <= 0 OR !ctype_digit($this->input->post($spec))){
							$data['errors'][] = ['field' => $spec,'error' => 'Er dient geldig aantal seconden ingevuld te worden'];
						}
						break;
					case 'hoogte':
						// "Hoogte" filled?
						if(!$this->input->post($spec)){
							if(!$this->session->flashdata('posted')){
								$data['errors'][] = ['field' => $spec,'error' => 'Hoogte dient ingevuld te worden, is dit nog echt onbekend? Klik dan nogmaals op "Toevoegen"'];
							}

						// Valid "hoogte"?
						} elseif($this->input->post($spec) <= 0 OR !ctype_digit($this->input->post($spec))){
							$data['errors'][] = ['field' => $spec,'error' => 'Er dient geldig aantal meters ingevuld te worden'];
						}
						break;
					case 'lengte':
						// "Lengte" filled?
						if(!$this->input->post($spec)){
							if(!$this->session->flashdata('posted')){
								$data['errors'][] = ['field' => $spec,'error' => 'Lengte dient ingevuld te worden, is dit nog echt onbekend? Klik dan nogmaals op "Toevoegen"'];
							}

						// Valid "lengte"?
						} elseif($this->input->post($spec) <= 0 OR !ctype_digit($this->input->post($spec))){
							$data['errors'][] = ['field' => $spec,'error' => 'Er dient geldig aantal meters ingevuld te worden'];
						}
						break;
					case 'inch':
						// "Inch" filled?
						if(!$this->input->post($spec)){
							$data['errors'][] = ['field' => $spec,'error' => 'Inch dient ingevuld te worden'];

						// Valid "inch"?
						} elseif($this->_numeric_or_decimal($this->input->post($spec))){
							$data['errors'][] = ['field' => $spec,'error' => $this->_numeric_or_decimal($this->input->post($spec))];
						}
						break;
				}
			}
		}

		// Video filled?
		$url = parse_url($this->input->post('video'));
		if(!trim($this->input->post('video'))){
			if(!$this->session->flashdata('posted')){
				$data['errors'][] = ['field' => 'video','error' => 'Er dient een video opgegeven te worden, is er echt geen video te vinden van dit product op Youtube? Klik dan nogmaals op "Toevoegen"'];
			}
		
		// Is a valid Youtube video?
		} elseif(!isset($url['host']) OR $url['host'] != 'www.youtube.com' OR !isset($url['path']) OR $url['path'] != '/watch' OR !isset($url['query']) OR strstr($url['query'],'v=') == FALSE OR str_replace('v=','',$url['query']) == ''){
			$data['errors'][] = ['field' => 'video','error' => 'Dit is geen geldige Youtube video link (http://www.youtube.com/watch?v=xxxxxx)'];
		}

		// "Omschrijving" filled?
		if(!$this->input->post('omschrijving')){
			if(!$this->ion_auth->is_admin()){
				$data['errors'][] = ['field' => 'omschrijving','error' => 'Er dient een omschrijving ingevuld te worden, schrijf deze bij voorkeur zelf ipv ergens vandaan te kopieëren'];
			}
		}

		// "Afbeelding" filled?
		if(!$this->input->post('afbeelding')){
			if(!$this->session->flashdata('posted')){
				$data['errors'][] = ['field' => 'afbeelding','error' => 'Er dient een afbeeldings url opgegeven te worden, is deze echt niet te vinden? Klik dan nogmaals op "Toevoegen"'];
			}
		
		// Valid "afbeelding"?
		} elseif($this->_image_downloadable($this->input->post('afbeelding'))){
			$data['errors'][] = ['field' => 'afbeelding','error' => $this->_image_downloadable($this->input->post('afbeelding'))];
		}

		$this->session->set_flashdata('posted',true);

		// No errors?
		if(empty($data['errors']))
		{
			// Get the slug
			$slug = $this->input->post('slug') ?: url_title($this->input->post('naam'),'-',TRUE);

			// Insert into the database
			$this->db->insert('producten',[
				'soort_id'			=> $this->input->post('soort'),
				'artikelnummer'		=> trim($this->input->post('artikelnummer')),
				'naam'				=> trim($this->input->post('naam')),
				'slug'				=> trim($slug),
				'merk_id'			=> $this->input->post('merk'),
				'importeur_id'		=> $this->input->post('importeur'),
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
				'omschrijving'		=> trim($this->input->post('omschrijving')),
				'gebruiker_id'		=> $this->ion_auth->logged_in() ? $this->session->userdata('user_id') : 0,
				'gekeurd'			=> $this->ion_auth->is_admin() ? 1 : 0,
			]);

			// Image given?
			if($this->input->post('afbeelding'))
			{
				// Load the image helper
				$this->load->helper('image_helper');

				// Download the image
				download_image($this->db->insert_id(),$slug,$this->input->post('afbeelding'));
			}

			// No admin?
			if(!$this->ion_auth->is_admin())
			{
				// Send mail (will be send as "text" so no escaping)
				$this->emailer->adminMail('Nieuw product keuren',$this->db->last_query());
			}

			$data['success'] = true;
		}

		// Echo JSON
		echo json_encode($data);
	}

	public function rating()
	{
		// Product?
		if($this->input->post('product_id'))
		{
			// Product doesn't exist?
			if(!$this->db->get_where('producten',['product_id' => $this->input->post('product_id')])->num_rows()){
				show_404();
			}
			$type = 'product';
			$not = 'winkel';

		// Store
		} elseif($this->input->post('winkel_id')) 
		{
			// Store doesn't exist?
			if(!$this->db->get_where('winkels',['winkel_id' => $this->input->post('winkel_id')])->num_rows()){
				show_404();
			}
			$type = 'winkel';
			$not = 'product';

		// Nothing	
		} else 
		{
			show_404();
		}


		// Rating not is allowed?
		if(!in_array($this->input->post('rating'),[1,2,3,4,5])){
			show_404();
		}

		// Already voted?
		if($this->db->get_where('beoordelingen',[$type.'_id' => $this->input->post($type.'_id'),'ip_adres' => $this->input->ip_address()])->row())
		{
			$this->db->update('beoordelingen',['beoordeling' => $this->input->post('rating')],[
				$type.'_id'		=> $this->input->post($type.'_id'),
				$not.'_id'		=> 0,
				'ip_adres'		=> $this->input->ip_address()
			]);
			
			echo json_encode(['status' => 'changed']);
		} else 
		{
			$this->db->insert('beoordelingen',[
				$type.'_id'		=> $this->input->post($type.'_id'),
				$not.'_id'		=> 0,
				'beoordeling'	=> $this->input->post('rating'),
				'ip_adres'		=> $this->input->ip_address()
			]);

			echo json_encode(['status' => 'added']);
		}
	}

	public function addvideo()
	{
		$data = ['errors' => []];

		// No product given or product doesn't exist?
		if(!$this->input->post('product_id') OR !$this->db->get_where('producten',['product_id' => $this->input->post('product_id')])->num_rows()){
			show_404();
		}

		// Title filled?
		if(!trim($this->input->post('titel'))){
			$data['errors'][] = ['field' => 'titel','error' => 'Er dient een titel opgegeven te worden'];
		}

		// Source filled?
		$url = parse_url($this->input->post('video'));
		if(!trim($this->input->post('video'))){
			$data['errors'][] = ['field' => 'video','error' => 'Er dient een video opgegeven te worden'];
		
		// Is a valid Youtube video?
		} elseif(!isset($url['host']) OR $url['host'] != 'www.youtube.com' OR !isset($url['path']) OR $url['path'] != '/watch' OR !isset($url['query']) OR strstr($url['query'],'v=') == FALSE OR str_replace('v=','',$url['query']) == ''){
			$data['errors'][] = ['field' => 'video','error' => 'Dit is geen geldige Youtube video link (http://www.youtube.com/watch?v=xxxxxx)'];
		}

		// No errors?
		if(empty($data['errors']))
		{
			// Insert into the database
			$this->db->insert('videos',[
				'product_id' 	=> (int)$this->input->post('product_id'),
				'titel'			=> $this->input->post('titel'),
				'video'			=> $this->input->post('video'),
				'gekeurd'		=> $this->ion_auth->is_admin() ? 1 : 0,
				'ip_adres'		=> $this->input->ip_address()
			]);

			// No admin?
			if(!$this->ion_auth->is_admin())
			{
				// Send mail (will be send as "text" so no escaping)
				$this->emailer->adminMail('Nieuwe video keuren',$this->db->last_query());
			}

			$data['success'] = true;
		}

		// Echo JSON
		echo json_encode($data);
	}

	public function addtowishlist()
	{
		// Product exists?
		if(!$this->input->post('product_id') OR !$this->db->get_where('producten',['product_id' => $this->input->post('product_id')])->num_rows()){
			show_404();
		}

		// Add to session
		if($wishlist = $this->session->userdata('wishlist')){
			$wishlist['products'][$this->input->post('product_id')] = 1;
			$this->session->set_userdata('wishlist',$wishlist);
		} else {
			$this->session->set_userdata('wishlist',['products' => [$this->input->post('product_id') => 1]]);
		}

		// Echo JSON
		echo json_encode(['status' => 'added']);
	}

	public function removefromwishlist()
	{
		// Product exists?
		if(!$this->input->post('product_id') OR !$this->db->get_where('producten',['product_id' => $this->input->post('product_id')])->num_rows()){
			show_404();
		}

		// In wishlist?
		if($wishlist = $this->session->userdata('wishlist') AND isset($this->session->userdata('wishlist')['products'][$this->input->post('product_id')])){
			unset($wishlist['products'][$this->input->post('product_id')]);
			$this->session->set_userdata('wishlist',$wishlist);
		} else {
			show_404();
		}

		// Echo JSON
		echo json_encode(['status' => 'removed']);
	}

	public function clearwishlist()
	{
		$this->session->unset_userdata('wishlist');

		echo json_encode(['status' => 'removed']);
	}

	public function register()
	{
		$data = ['errors' => []];

		// Already logged in?
		if($this->ion_auth->logged_in()){
			show_404();
		}

		// Username filled?
		if(!trim($this->input->post('username'))){
			$data['errors'][] = ['field' => 'username','error' => 'Er dient een gebruikersnaam opgegeven te worden'];

		// Min length
		} elseif(strlen($this->input->post('username')) < 4){
			$data['errors'][] = ['field' => 'username','error' => 'De gebruikersnaam dient uit minimaal 4 karakters te bestaan'];
		
		// Username not already taken?
		} elseif($this->ion_auth->username_check($this->input->post('username'))){
			$data['errors'][] = ['field' => 'username','error' => 'Er is al een account met deze gebruikersnaam'];
		}

		// Email filled?
		if(!trim($this->input->post('email'))){
			$data['errors'][] = ['field' => 'email','error' => 'Er dient een e-mail adres opgegeven te worden'];

		// Valid email?
		} elseif(!filter_var($this->input->post('email'),FILTER_VALIDATE_EMAIL)){
			$data['errors'][] = ['field' => 'email','error' => 'Er dient geldig e-mail adres opgegeven te worden'];
		
		// Not already used email?
		} elseif($this->ion_auth->email_check($this->input->post('email'))){
			$data['errors'][] = ['field' => 'email','error' => 'Er is al een account met dit email adres'];
		}

		// Password filled?
		if(!trim($this->input->post('password'))){
			$data['errors'][] = ['field' => 'password','error' => 'Er dient een wachtwoord opgegeven te worden'];
		}

		// Password and repeat password the same?
		if(trim($this->input->post('password')) != trim($this->input->post('password2'))){
			$data['errors'][] = ['field' => 'password2','error' => 'Dit wachtwoord komt niet overeen met het eerder ingevulde wachtwoord'];
		}

		// No errors?
		if(empty($data['errors']))
		{
			if($this->ion_auth->register($this->input->post('username'), $this->input->post('password'), $this->input->post('email'))){
				$data['success'] = true;
				$this->emailer->adminMail('Nieuwe gebruiker geregistreerd','Gebruikersnaam: '.trim($this->input->post('username')));
			} else {
				$data['errors'][] = ['field' => 'username','error' => $this->ion_auth->errors()];
			}
		}

		// Echo JSON
		echo json_encode($data);
	}

	public function login()
	{
		$data = ['errors' => []];

		// Already logged in?
		if($this->ion_auth->logged_in()){
			show_404();
		}

		// Email filled?
		if(!trim($this->input->post('email'))){
			$data['errors'][] = ['field' => 'email','error' => 'Er dient een e-mail adres opgegeven te worden'];
		
		// Email adres found?
		} elseif(!$this->ion_auth->email_check($this->input->post('email'))){
			$data['errors'][] = ['field' => 'email','error' => 'Er is geen account met dit email adres'];
		}

		// Password filled?
		if(!trim($this->input->post('password'))){
			$data['errors'][] = ['field' => 'password','error' => 'Er dient een wachtwoord opgegeven te worden'];
		}

		// No errors?
		if(empty($data['errors']))
		{
			if($this->ion_auth->login($this->input->post('email'), $this->input->post('password'), $this->input->post('remember'))){
				$data['success'] = true;
			} else {
				$data['errors'][] = ['field' => 'password','error' => 'Het opgegeven wachtwoord komt niet overeen'];
			}
		}

		// Echo JSON
		echo json_encode($data);
	}

	function _numeric_or_decimal($string)
	{
		if($string != ''){
			$string = (float)str_replace(',','.',$string);
			if($string <= 0){
				return 'De waarde dient een nummer ingevuld te worden en deze dient hoger dan 0 te zijn.';
			}
			if(strstr($string,'.') !== FALSE){
				$decimals = strlen(explode('.',$string)[1]);
				if($decimals > 2){
					return 'Er mogen maar 2 decimalen achter de komma';	
				}
			}
		}
		return false;
	}

	function _image_downloadable($url)
	{
		if($url){
			$image = @file_get_contents($url);
			if(!$image){
				return 'De afbeelding kan niet gedownload worden';
			}
			$image = @imagecreatefromstring($image);
			if(!$image){
				@imagedestroy($image);
				return 'Dit is geen afbeelding';
			}
			@imagedestroy($image);
			$size = @getimagesize($url);
			if(!$size OR $size[0] < 300 OR $size[1] < 300){
				if(!$this->session->flashdata('posted')){
					return 'Deze afbeelding is vrij klein (onder de 300 pixels hoog of breed), kan je echt geen grotere afbeelding vinden? Klik dan nogmaals op "Toevoegen"';
				}
			}
		}
		return false;
	}

}

/* End of file ajax.php */
/* Location: ./application/controllers/ajax.php */