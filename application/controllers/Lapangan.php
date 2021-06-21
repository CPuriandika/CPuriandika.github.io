<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lapangan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		function rupiah($data)
		{
			echo "Rp " . number_format($data,0,',','.');
		}

	}
	
	public function index()
	{
		$data['title'] = 'Lapangan';
		$data['user'] = $this->db->get_where('user', ['email' =>
		$this->session->userdata('email')])->row_array();
		$data['lapangan'] = $this->db->get('lapangan')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/lapangan', $data);
        $this->load->view('templates/footer'); 
	}

	public function master()
	{
		$data['title'] = 'Master Lapangan';
		$data['user'] = $this->db->get_where('user', ['email' =>
		$this->session->userdata('email')])->row_array();
		$data['lapangan'] = $this->db->get('lapangan')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/lapangan', $data);
        $this->load->view('templates/footer'); 
	}


}
