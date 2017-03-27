<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function querystring($remove)
{
	parse_str($_SERVER['QUERY_STRING'],$string);
	foreach($remove as $rm){
		unset($string[$rm]);
	}
	return http_build_query($string);
}


/* End of file querystring_helper.php */
/* Location: ./application/helpers/querystring_helper.php */