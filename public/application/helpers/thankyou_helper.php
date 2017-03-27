<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function thankyou_product($user_id)
{
	$CI =& get_instance();
	$user = $CI->ion_auth->user($user_id)->row();

	if($user_id AND $user->weergave_naam) {

		$html = $user->website_url ? '<a href="'.html_escape($user->website_url).'" target="_blank" class="alert-link">' : '<strong>';
		$html .= html_escape($user->weergave_naam);
		$html .= $user->website_url ? '</a>' : '</strong>';
		return $html;

	} else {

		return false;

	}
}

function thankyou_price($user_ids)
{
	if(!empty($user_ids)) {

		foreach($user_ids as $user_id) {
			if($thanks = thankyou_product($user_id)) {
				$users[] = $thanks;
			}
		}

		if(isset($users)) {
			return join(' en ', array_filter(array_merge(array(join(', ', array_slice($users, 0, -1))), array_slice($users, -1))));
		} else {
			return false;
		}

	} else {

		return false;

	}
}


/* End of file thankyou_helper.php */
/* Location: ./application/helpers/thankyou_helper.php */