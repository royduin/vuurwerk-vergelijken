<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Embed extends Home_Controller {

	public function __construct()
	{
		parent::__construct();

		// Load image helper
		$this->load->helper('image');

		// Set the memory limit
		ini_set('memory_limit','512M');
	}

	public function index()
	{
		show_404();
	}

	public function product($soort = FALSE,$merk = FALSE,$product = FALSE)
	{
		if(!$merk OR !$product OR !$soort OR $this->uri->segment(6)){
			show_404();
		}

		$product = $this->db->query('
			SELECT
				naam,
				merk_naam,
				nieuw,
				artikelnummer,
				soort_naam,
				importeur_naam,
				soort_specificaties,
				producten.soort_id,
				producten.aantal,
				inch,
				gram,
				tube,
				schoten,
				duur,
				hoogte,
				lengte,
				producten.product_id,
				slug,
				omschrijving,
				MIN(ROUND(prijzen.prijs / prijzen.aantal,2)) as prijs,
				IF(AVG(beoordeling) IS NULL,0,ROUND(AVG(beoordeling),1)) as beoordeling,
				buitenland
			FROM
				producten
			JOIN
				soorten
			ON
				soorten.soort_id = producten.soort_id
			JOIN
				merken
			ON
				merken.merk_id = producten.merk_id
			JOIN
				importeurs
			ON
				importeurs.importeur_id = producten.importeur_id
			LEFT JOIN
				prijzen
			ON
				prijzen.product_id = producten.product_id
			AND
				prijzen.jaar = '.config_item('jaar').'
			LEFT JOIN
				beoordelingen
			ON
				beoordelingen.product_id = producten.product_id
			WHERE
				soort_slug = '.$this->db->escape($soort).'
			AND
				merk_slug = '.$this->db->escape($merk).'
			AND
				slug = '.$this->db->escape($product).'
		')->row();

		if(!$product){
			show_404();
		}

		// Set dimensions
		$width = 600;
		$h_counter = 30;

		// Set image header
		header("Content-Type: image/jpeg");

		// No cache
		header("Expires: Mon, 26 Jul 1990 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		// Create new image
		$image = imagecreatetruecolor($width,3000);

		// Background color
		$background = imagecolorallocate($image, 255, 255, 255);
		imagefill($image, 0, 0, $background);

		// Name
		$h_counter += image_text($image,$width,20,5,$h_counter,(!stristr($product->naam,$product->merk_naam) ? $product->merk_naam.' ' : '').$product->naam.($product->nieuw == config_item('jaar') ? ' - NIEUW' : ''),TRUE);

		// Description
		if($product->omschrijving){
			$h_counter += image_text($image,$width,12,5,$h_counter,$product->omschrijving);
			$h_counter += 10;
		}

		// Info
		$h_counter += 10;
		image_text($image,$width,12,5,$h_counter,'Artikelnummer',TRUE);
		$h_counter += image_text($image,$width,12,220,$h_counter,$product->artikelnummer);
		$h_counter += 10;
		image_text($image,$width,12,5,$h_counter,'Categorie',TRUE);
		$h_counter += image_text($image,$width,12,220,$h_counter,$product->soort_naam);
		$h_counter += 10;
		image_text($image,$width,12,5,$h_counter,'Importeur / fabrikant',TRUE);
		$h_counter += image_text($image,$width,12,220,$h_counter,$product->importeur_naam);
		$h_counter += 10;
		image_text($image,$width,12,5,$h_counter,'Merk / collectie',TRUE);
		$h_counter += image_text($image,$width,12,220,$h_counter,$product->merk_naam);
		$h_counter += 10;
		if($product->nieuw){
			image_text($image,$width,12,5,$h_counter,'Nieuw in',TRUE);
			$h_counter += image_text($image,$width,12,220,$h_counter,$product->nieuw);
			$h_counter += 10;
		}

		// Specs
		foreach(explode(',',$product->soort_specificaties) as $spec){
			if($spec == 'aantal' AND $product->aantal){
				image_text($image,$width,12,5,$h_counter,'Aantal'.($product->soort_id == 11 ? ' cakes' : ''),TRUE);
				$h_counter += image_text($image,$width,12,220,$h_counter,$product->aantal);
				$h_counter += 10;
			} elseif($spec == 'inch' AND $product->inch){
				image_text($image,$width,12,5,$h_counter,'Inch',TRUE);
				$h_counter += image_text($image,$width,12,220,$h_counter,price($product->inch));
				$h_counter += 10;
			} elseif($spec == 'gram' AND $product->gram){
				image_text($image,$width,12,5,$h_counter,'Gram',TRUE);
				$h_counter += image_text($image,$width,12,220,$h_counter,price($product->gram));
				$h_counter += 10;
			} elseif($spec == 'tube' AND $product->tube){
				image_text($image,$width,12,5,$h_counter,'Gemiddelde gram per tube',TRUE);
				$h_counter += image_text($image,$width,12,220,$h_counter,price($product->tube));
				$h_counter += 10;
			} elseif($spec == 'schoten' AND $product->schoten){
				image_text($image,$width,12,5,$h_counter,'Schoten',TRUE);
				$h_counter += image_text($image,$width,12,220,$h_counter,price($product->schoten));
				$h_counter += 10;
			} elseif($spec == 'duur' AND $product->duur){
				image_text($image,$width,12,5,$h_counter,'Duur',TRUE);
				$h_counter += image_text($image,$width,12,220,$h_counter,$product->duur.'s');
				$h_counter += 10;
			} elseif($spec == 'hoogte' AND $product->hoogte){
				image_text($image,$width,12,5,$h_counter,'Hoogte',TRUE);
				$h_counter += image_text($image,$width,12,220,$h_counter,$product->hoogte.'m');
				$h_counter += 10;
			} elseif($spec == 'lengte' AND $product->lengte){
				image_text($image,$width,12,5,$h_counter,'Lengte',TRUE);
				$h_counter += image_text($image,$width,12,220,$h_counter,$product->lengte.'m');
				$h_counter += 10;
			}
		}

		// Image
		if(file_exists('img/producten/'.$product->product_id.'/'.$product->slug.'.png')){
			$h_counter 	+= 10;
			$merge_image = 'img/producten/'.$product->product_id.'/thumb260/'.$product->slug.'.png';
			$merge_image = imagecreatefromstring(file_get_contents($merge_image));
			imagecopy($image,$merge_image,5,$h_counter,0,0,imagesx($merge_image),imagesy($merge_image));
			$h_counter += 290;
		}

		// Rating
		if($product->beoordeling){
			$h_counter += image_text($image,$width,12,5,$h_counter,'Beoordeling: '.str_replace('.',',',$product->beoordeling).' van de 5 sterren');
			$h_counter += 15;
		}

		// For sale and price?
		if($product->buitenland){
			$h_counter += image_text($image,$width,12,5,$h_counter,'Dit product is niet te koop bij Nederlandse vuurwerk winkels');
		} else {
			if($product->prijs){
				image_text($image,$width,12,5,$h_counter,'In '.config_item('jaar').' te koop vanaf ');
				$h_counter += image_text($image,$width,18,160,$h_counter,'€'.price($product->prijs),TRUE);
			} else {
				$h_counter += image_text($image,$width,12,5,$h_counter,'Nog geen prijs bekend voor '.config_item('jaar').' of niet meer te koop');
			}
		}

		// Link
		$merge_image = imagecreatefromstring(file_get_contents('favicon-16x16.png'));
		imagecopy($image,$merge_image,5,$h_counter - 12,0,0,imagesx($merge_image),imagesy($merge_image));
		$h_counter += image_text($image,$width,8,25,$h_counter,'Vuurwerk prijzen vergelijken? Vuurwerk-vergelijken.nl');

		// Create image again with the right height
		$result = imagecreatetruecolor($width,$h_counter);
		imagecopy($result,$image,0,0,0,0,imagesx($image),imagesy($image));

		// Create jpeg
		if(!imagejpeg($result,NULL,100)){
			log_message('error','Images embed error with product '.$product->product_id);
		}

		// Destroy image
		imagedestroy($image);
		imagedestroy($result);
	}
}

/* End of file embed.php */
/* Location: ./application/controllers/embed.php */