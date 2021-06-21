<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function index()
	{
		$this->load->view('auth/home');
		$this->load->view('templates/footer');
	}

	public function about()
	{
		$this->load->view('auth/about');
		$this->load->view('templates/footer');
	}
}
