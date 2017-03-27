<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function price($price)
{
	return str_replace(',00','',number_format($price,2,',',''));
}


/* End of file price_helper.php */
/* Location: ./application/helpers/price_helper.php */