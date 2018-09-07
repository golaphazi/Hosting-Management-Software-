<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class logout extends CI_Controller {


	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model(array('user_model'));
		$this->load->helper('url');
	}
	
	public function index(){
		$this->session->sess_destroy();
		redirect(SITE_URL.'login/');			
	}
	
}

?>