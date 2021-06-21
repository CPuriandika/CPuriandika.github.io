<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends CI_Controller
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
		$data['title'] = 'Pembayaran';
		$data['user'] = $this->db->get_where('user', ['email' =>
		$this->session->userdata('email')])->row_array();
		$id_user = $this->session->userdata('id');

		$no=$this->db->query("SELECT MAX(no_invoice) as noInvoice FROM pesanan")->row();
		$no_terakhir=$no->noInvoice;
		$no_urut= (int) substr($no_terakhir, 3, 4);
		$no_terbaru= $no_urut+1;
		$car= "INV";
		$no_invoice= $car.sprintf("%04s", $no_terbaru);

		$kd=$this->db->query("SELECT MAX(kd_pesanan) as kdPes FROM pesanan")->row();
		$kd_a=$kd->kdPes;
		$kd_urut= (int) substr($kd_a, 6, 4);
		$no_terbaru= $kd_urut+1;
		$car_kd= date('dmy');
		$kd_pes= $car_kd.sprintf("%04s", $no_terbaru);
		

		$d= $this->db->get_where('temp',['id_user' => $id_user])->row();
		$tgl_pesanan=date('d-m-Y');
		 $isi=[
			'kd_pesanan' => $kd_pes,
			'tgl_pesanan' => $tgl_pesanan,
			'id_lapangan' => $d->id_lapangan,
			'id_user' => $d->id_user,
			'tot_biaya' => $this->uri->segment(3),
			'no_invoice' => $no_invoice
		];

		$pes=[
			'no_invoice' => $no_invoice,
			'status' => '1'
		];

		$this->db->insert('pesanan',$isi);
		$this->db->insert('invoice',$pes);

		$this->db->select('*');
		$this->db->from('temp');
		$this->db->join('lapangan','temp.id_lapangan = lapangan.id');
		$this->db->where('id_user', $id_user);
		$dtl=$this->db->get()->result_array();

		// $dtemp=$this->db->get_where('temp',['id_user' => $id_user])->result_array();

		foreach( $dtl as $dt){
			$id='';
			$kd_pesanan=$kd_pes;
			$id_lapangan=$dt['id_lapangan'];

			$m=strtotime($dt['jm_mulai']);
			$a=strtotime($dt['jm_akhir']); 
			$diff=$a-$m; 
			$durasi=ceil($diff/(60*60)); 

			$jm_mulai=$dt['jm_mulai'];
			$jm_akhir=$dt['jm_akhir'];
			$durasi=$durasi;

			$biaya=$dt['tarif'];
			$biaya=$biaya*$durasi;
			$id_user=$id_user;

			
			$query= "INSERT INTO detail_pesanan(id,kd_pesanan,id_lapangan,jm_mulai,jm_akhir,durasi,biaya,id_user)
						VALUES('','$kd_pesanan',$id_lapangan,'$jm_mulai','$jm_akhir',$durasi,$biaya,$id_user)";

			$this->db->query($query);

		}

		$this->db->delete('temp',['id_user' => $id_user]);


	


		redirect('pembayaran/tampilData');
		

	}
	
	public function tampilData()
	{
		$data['title'] = 'Pembayaran';
		$data['user'] = $this->db->get_where('user', ['email' =>
		$this->session->userdata('email')])->row_array();
	
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('user/pembayaran', $data);
		$this->load->view('templates/footer');
		
	}

	public function up_bayar($id)
	{
		$data=$this->db->get_where('pesanan',['kd_pesanan' => $id])->row_array();
		$nm_rek=$this->input->post('nm_rek');
		$jml_tf=$this->input->post('jml_tf');
		$nm_bank=$this->input->post('nm_bank');
		$id='';
		$upload_image = $_FILES['image_tf']['name']; 
		
		if ($upload_image) {
			$config['upload_path'] = './assets/img/konf_bayar/';
			$config['max_width'] = '1024';
            $config['max_height'] = '1000';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['file_name'] = 'pro' . time();

			$this->load->library('upload', $config);
			// $this->upload->initialize($config);

			if ($this->upload->do_upload('image_tf')) {
				$image_tf = $this->upload->data('file_name');
				$this->db->set('image_tf', $image_tf);
			}else{
				echo $this->upload->display_errors();
			}
		}

		$isi=[
			'id_bayar' => '',
			'no_invoice' => $data['no_invoice'],
			'nm_rek' => $nm_rek,
			'jml_tf' => $jml_tf,
			'nm_bank' => $nm_bank,
			'image_tf' => $image_tf
		];
		$this->db->insert('konf_bayar',$isi);

		$this->session->set_flashdata( 
			'message',
			'<div class="alert alert-success role="alert">
			Bukti Transfer Berhasil Di Upload - '.'<b>Admin Akan Segera Melakukan Konfirmasi Pesanan Anda</b>
			</div>'
		);

		$this->db->set('no_invoice',$data['no_invoice']);
		$this->db->set('status',2);
		$this->db->where('no_invoice', $data['no_invoice']);
		$this->db->update('invoice');
		redirect('pembayaran/tampilData');
	}

	public function cetak($kd_pesanan)
	{
		
		$data['title'] = "Cetak Invoice";
		$user_email=$this->session->userdata('email');
		$this->db->select('*');
		$this->db->from('pesanan');
		$this->db->join('user','pesanan.id_user = user.id');
		$this->db->where('kd_pesanan', $kd_pesanan);
		$data['detail_m']=$this->db->get()->row_array();
		

		$this->db->select('*');
		$this->db->from('detail_pesanan');
		$this->db->join('lapangan','detail_pesanan.id_lapangan = lapangan.id');
		$this->db->where('kd_pesanan', $kd_pesanan);
		$data['detail']=$this->db->get()->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('user/cetak_invoice',$data);
	}

	public function konfirmasi($no_invoice)
	{
		$this->db->set('no_invoice',$no_invoice);
		$this->db->set('status',3);
		$this->db->where('no_invoice',$no_invoice);
		$this->db->update('invoice');
		redirect('admin');
	}

	public function bukti()
	{
		$no_inv=$this->input->post('inv');
		$data=$this->db->get_where('konf_bayar',['no_invoice' => $no_inv])->row();
		echo json_encode($data);
	}

	public function tampilPesanan()
	{
		$data['title'] = 'Daftar Pesanan';
		$data['user'] = $this->db->get_where('user', ['email' =>
		$this->session->userdata('email')])->row_array();
	
		$this->db->select('*');
		$this->db->from('pesanan');
		$this->db->join('invoice','pesanan.no_invoice = invoice.no_invoice');
		$this->db->where('status', 3);
		$data['psn']= $this->db->get()->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/pesanan', $data);
        $this->load->view('templates/footer');
		
	}

}
