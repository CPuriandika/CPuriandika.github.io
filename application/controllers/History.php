<?php
defined('BASEPATH') or exit('No direct script access allowed');

class History extends CI_Controller
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
		$data['title'] = 'History Pemesanan';
		$data['user'] = $this->db->get_where('user', ['email' =>
		$this->session->userdata('email')])->row_array();
		$id_user=$this->session->userdata('id');
		
		$this->db->select('*');
		$this->db->from('pesanan');
		$this->db->join('invoice','pesanan.no_invoice = invoice.no_invoice');
		$this->db->where('id_user', $id_user);
		$this->db->where('status', 3);
		$data['psn']= $this->db->get()->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/history', $data);
        $this->load->view('templates/footer');
	}


}
