<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanan extends CI_Controller
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
		$data['title'] = 'Pesanan';
		$data['user'] = $this->db->get_where('user', ['email' =>
		$this->session->userdata('email')])->row_array();
		$id_user=$this->session->userdata('id');
		$data['temp'] = $this->db->get_where('temp',['id_user' => $id_user])->result_array();
		$data['isi_temp']=$this->db->get('temp')->num_rows();
		

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/pesanan', $data);
        $this->load->view('templates/footer');
	}

	public function delBooking($id)
	{
		$this->db->where(['id' => $id ]);
		$this->db->delete('temp');
		redirect('pesanan');
		
	}
	




	
}
