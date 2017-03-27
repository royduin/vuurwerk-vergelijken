<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function get_video_id($url)
{
	parse_str( parse_url( $url, PHP_URL_QUERY ), $arr );
	return $arr['v']; 
}


/* End of file youtube_helper.php */
/* Location: ./application/helpers/youtube_helper.php */