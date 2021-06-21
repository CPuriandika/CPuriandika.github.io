<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // cek_login();
    }

    public function index()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
	}
	
	public function update($id)
	{
		$data= $this->db->get_where('user', ['id' => $id])->row_array();



		
		$this->db->set('id',$id);
		$this->db->set('name', $this->input->post('name'));
		$this->db->set('email', $data['email']);
		$this->db->set('image', $data['image']);
		$this->db->set('password', $data['password']);
		$this->db->set('telpon', $this->input->post('telpon'));
		$this->db->set('role_id', $data['role_id']);
		$this->db->set('is_active', $data['is_active']);
		$this->db->set('date_created', $data['date_created']);
		$this->db->where('id',$id);
		$this->db->update('user');

	
		$this->session->set_flashdata( 
			'message',
			'<div class="alert alert-success role="alert">Data Berhasil Di Ubah</div>'
		);
		redirect('user');
	}

	public function updateFoto($id)
	{
		$data= $this->db->get_where('user', ['id' => $id])->row_array();

		$this->db->set('id',$data['id']);
		$this->db->set('name',$data['name']);
		$this->db->set('email',$data['email']);

		$upload_image = $_FILES['image']['name']; 
		if ($upload_image) {
			$config['upload_path'] = './assets/img/profile/';
			$config['max_width'] = '1024';
            $config['max_height'] = '1000';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['file_name'] = 'pro' . time();

			$this->load->library('upload', $config);
			// $this->upload->initialize($config);

			if ($this->upload->do_upload('image')) {
				$gambar_lama = $data['image'];
				if ($gambar_lama != 'default.jpg') {
					unlink(FCPATH . 'assets/img/profile/' . $gambar_lama);
				}

				$gambar_baru = $this->upload->data('file_name');
				$this->db->set('image', $gambar_baru);
			}else{
				echo $this->upload->display_errors();
			}
		}
		
		$this->db->set('password',$data['password']);
		$this->db->set('telpon',$data['telpon']);
		$this->db->set('role_id',$data['role_id']);
		$this->db->set('is_active',$data['is_active']);
		$this->db->set('date_created',$data['date_created']);

		$this->db->where('id',$id);
		$this->db->update('user');

		$this->session->set_flashdata( 
			'message',
			'<div class="alert alert-success role="alert">Foto Profile Berhasil Di Ubah</div>'
		);
		redirect('user');
	}



}
