<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Booking extends CI_Controller
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
		
        $id_lap = $this->input->post('id');

        //memilih data lap yang untuk dimasukan ke tabel temp/keranjang melalui variabel $isi
		$d = $this->db->get_where('lapangan',['id'=> $id_lap])->row();
		



        // berupa data-data yang akan disimpan ke dalam tabel temp/keranjang
        $isi = [
            'id_lapangan' => $id_lap,
			'kd_lapangan' => $d->kd_lapangan,
			'jns_lapangan' => $d->jns_lapangan,
            'image' => $d->image,
			'tarif' => $d->tarif,
			'jm_mulai' => $this->input->post('jm_mulai'),
			'jm_akhir' => $this->input->post('jm_akhir'),
            'id_user' => $this->session->userdata('id'),
            'email_user' => $this->session->userdata('email')
        ];

        
        $this->db->insert('temp',$isi);

        //pesan ketika berhasil memasukkan buku ke keranjang
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-message" role="alert">Buku berhasil ditambahkan ke keranjang .</div>');
            redirect(base_url('pesanan'));
	}


}
