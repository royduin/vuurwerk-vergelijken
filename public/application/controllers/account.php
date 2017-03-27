<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends Home_Controller {

	public function __construct()
	{
		parent::__construct();

		// Not logged in?
		if(!$this->ion_auth->logged_in()){
			redirect(site_url(),'location',301);
		}
	}

	public function index()
	{
		$data['user'] = $this->ion_auth->user()->row();

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');

		$this->form_validation->set_rules('email', 'e-mail adres', 'required|valid_email|callback__email_is_free');
		$this->form_validation->set_rules('weergave-naam', 'weergave naam', 'max_length[20]|strtolower|ucwords');
		$this->form_validation->set_rules('website-url', 'website url', 'prep_url|callback__valid_url');
		$this->form_validation->set_rules('password-current', 'huidig wachtwoord', 'required|callback__check_password');
		$this->form_validation->set_rules('password-new', 'nieuw wachtwoord', 'matches[password-new2]');
		$this->form_validation->set_rules('password-new2', 'herhaal wachtwoord', 'matches[password-new]');

		if($this->form_validation->run()){

			$save = [
				'email' 		=> $this->input->post('email'),
				'weergave_naam' => $this->input->post('weergave-naam'),
				'website_url' 	=> $this->input->post('website-url')
			];
			if(trim($this->input->post('password-new'))){
				$save['password'] = $this->input->post('password-new');
			}
			if($this->ion_auth->update($data['user']->id, $save)){
				$this->session->set_flashdata('success','Je account is succesvol gewijzigd');
			} else {
				$this->session->set_flashdata('error',$this->ion_auth->errors());
			}

			if($this->input->post('weergave-naam')){
				// Send mail (will be send as "text" so no escaping)
				$this->emailer->adminMail('Nieuwe weergave naam toegevoegd','Naam: '.$this->input->post('weergave-naam')."\nURL: ".$this->input->post('website-url'));
			}

			redirect('account');

		} else {

			// Set information for the view
			$data['layout'] 	= 'account/home';
			$data['page_title'] = 'Mijn account';

			// Load the view
			$this->load->view('layout',$data);

		}
	}

	public function uitloggen()
	{
		$this->ion_auth->logout();
		redirect(site_url(),'location',301);
	}

	function _email_is_free($email)
	{
		if($email) {
			if($this->ion_auth->user()->row()->email == $email) {
				return true;
			} elseif($this->ion_auth->email_check($email)) {
				$this->form_validation->set_message('_email_is_free', 'Er is al een account met dit email adres');
				return false;
			} else {
				return true;
			}
		}
		return true;
	}

	function _check_password($password)
	{
		if(!$this->ion_auth->hash_password_db($this->ion_auth->user()->row()->id, $password)){
			$this->form_validation->set_message('_check_password', 'Het opgegeven wachtwoord komt niet overeen');
			return false;
		}
		return true;
	}

	function _valid_url($url)
	{
		if($url) {
			if(!filter_var($url,FILTER_VALIDATE_URL)) {
				$this->form_validation->set_message('_valid_url', 'Dit is geen geldige url');
				return false;
			}
		}
		return true;
	}

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */