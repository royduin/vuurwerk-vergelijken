<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Old crawl testing, didn't work out that well so everything is added manually.
 */
class Crawler extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		exit;
	}

	public function index($id = false)
	{
		// echo $this->crawl($id,TRUE);
		// exit;

		// $producten[] = $this->crawl($id);
		// $producten[] = $this->crawl('12345');
		// $producten[] = $this->crawl('33052');
		
		for ($i = 33040; $i <= 33100; $i++) {
			if($temp = $this->crawl($i)){
				$producten[] = $temp;
			}
		}
		
		// $p = [18084];
		// foreach($p as $p2){
		// 	if($temp = $this->crawl($p2))
		// 	{
		// 		$producten[] = $temp;
		// 	}
		// }

		// foreach($producten as $product){
			// echo '<pre>'.print_r($product,TRUE).'</pre>';
			// $this->db->insert('producten',[
			// 	'soort_id' 				=> 1,
			// 	'artikelnummer'			=> $product['nummer'],
			// 	'naam'					=> $product['naam'],
			// 	'merk_id'				=> 1,
			// 	'gram'					=> $product['gram_netto'],
			// 	'schoten'				=> $product['schoten'],
			// 	'nieuw'					=> NULL,
			// 	'afbeelding'			=> '',
			// 	'video'					=> '',
			// 	'omschrijving'			=> ''
			// ]);
		// }

		// exit;






		$keys = array_flip(array_unique($this->array_keys_multi($producten)));
		// echo '<pre>'.print_r($keys,TRUE).'</pre>';

		foreach($producten as $product_temp_id=>$product)
		{
			foreach($product as $product_key=>$product_value)
			{
				if(!is_array($keys[$product_key]))
				{
					$keys[$product_key] = [];
				}
				$keys[$product_key][$product_temp_id] = $product_value;
			}
		}

		// echo '<pre>'.print_r($keys,TRUE).'</pre>';
		?>
		<table>
			<?php foreach($keys as $key=>$row) {
				echo('<tr>');
					foreach($row as $cell) {
						echo('<td>' . $cell . '</td>');
					}
				echo('</tr>');
			} ?>
		</table>
		<?





		exit;

		echo '<table><tr>';
		foreach($keys as $value)
		{
			echo '<th>'.$value.'</th>';
		}
		echo '</tr>';
		foreach($producten as $product)
		{
			echo '<pre>'.print_r($product,TRUE).'</pre>';
		}
		echo '</table>';
	}

	public function crawl($id,$debug = FALSE)
	{
		libxml_use_internal_errors(true);
		$html = file_get_contents('http://forum.vuurwerkcrew.nl/showthread.php?'.(int)$id);
		$doc = new DOMDocument();
		$doc->loadHTML($html);
		$test = $doc->getElementsByTagName('blockquote');

		foreach($test as $t)
		{
			$test2 = $t->ownerDocument->saveHTML($t);
			break;
		}

		if(isset($test2)){
			$doc->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$test2);
			$test = $doc->getElementsByTagName('b');
			$string = '';
			foreach($test as $t)
			{
				$string .= $t->ownerDocument->saveHTML($t);
			}

			$test = explode('</b><b>',$string);
			$test[0] = str_replace('<b>','',$test[0]);

			end($test);
			$key = key($test);
			$test[$key] = str_replace('</b>','',$test[$key]);

			if($debug){
				echo '<pre>'.print_r($test,TRUE).'</pre>';	
			}
			
			$product = [];
			foreach($test as $key=>$spec)
			{
				if(stristr($spec,'Artikelnummer')){
					$product['nummer'] = trim($test[$key+1]);
				} elseif(stristr($spec,'Artikelnaam')){
					$product['naam'] = $test[$key+1];
				} elseif(stristr($spec,'Bruto')){
					$product['gram_bruto'] = (int)$test[$key+1];
				} elseif(stristr($spec,'Netto') OR stristr($spec,'Gewicht')){
					$product['gram_netto'] = (int)$test[$key+1];
				} elseif(stristr($spec,'Schoten')){
					$product['schoten'] = !isset($product['schoten']) ? preg_replace('/\D/', '',$test[$key+1]) : $product['schoten'];
				} elseif(stristr($spec,'Aantal')){
					$product['aantal'] = (int)$test[$key+1];
				// } elseif(stristr($spec,'Omschrijving')){
				// 	$product['omschrijving'] = $test[$key+1];
				// } elseif(stristr($spec,'Duur')){
				// 	$product['duur'] = $test[$key+1];
				// } elseif(stristr($spec,'Hoogte')){
				// 	$product['hoogte'] = $test[$key+1];
				} elseif(stristr($spec,'Fabrikant') OR stristr($spec,'Importeur')){
					$product['fabrikant'] = $test[$key+1];
				} elseif(stristr($spec,'Prijs')){
					$product['prijs'] = isset($test[$key+1]) ? preg_replace("/[^0-9,.]/", "", $test[$key+1]) : 0;
				}
			}

			if(!empty($product)){
				$return = $product;
				$return['crew_id'] = $id;
			}

			if($debug){
				echo '<pre>'.print_r($return,TRUE).'</pre>';
			}

			return isset($return) ? $return : FALSE;
		}
	}

	private function array_keys_multi(array $array)
	{
		$keys = array();

		foreach ($array as $key => $value) {
		    
		    if(!is_numeric($key)){
		    	$keys[] = $key;
		    }

		    if (is_array($array[$key])) {
		        $keys = array_merge($keys, $this->array_keys_multi($array[$key]));
		    }
		}

		return $keys;
	}

}

/* End of file crawler.php */
/* Location: ./application/controllers/crawler.php */