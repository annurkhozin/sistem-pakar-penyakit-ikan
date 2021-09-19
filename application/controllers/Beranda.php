<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends CI_Controller {

	public function index(){
		$response = array(
			"title" => "Beranda",
			"html" => $this->load->view('beranda', '', TRUE)
		);
		$this->output->set_status_header(200)
					->set_content_type('application/json')
					->set_output(json_encode($response));
	}
}
