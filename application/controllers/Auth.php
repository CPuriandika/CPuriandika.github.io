<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = "KRR Futsal | Login";
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            // validasi sukses (masuk login)
            $this->_login();
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        //jika usernya ada
        if ($user) {
            if ($user['is_active'] == 1) { //jika user nya aktif
                if (password_verify($password, $user['password'])) { //jika password benar
                    $data = [
						'id' => $user['id'],
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    } else {
						$this->session->set_flashdata( 
							'message',
							'<div class="alert alert-info role="alert">Lengkapi Data Profile Sebelum Melakukan Pemesanan</div>'
						);
                        redirect('user');
                    }
                } else {
                    $this->session->set_flashdata( //jika password salah
                        'message',
                        '<div class="alert alert-danger role="alert">Wrong password</div>'
                    );
                    redirect('auth');
                }
            } else { //usernya belum diaktivasi
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger role="alert">This Email has not been Activated</div>'
                );
                redirect('auth');
            }
        } else { //user tidak ada
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger role="alert">Email is not Registered</div>'
            );
            redirect('auth');
        }
    }

    public function registration()
    {
        $data['title'] = "KRR Futsal | Daftar";
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|trim|valid_email|is_unique[user.email]',
            [
                'is_unique' => 'This email has already registered !'
            ]
        );
        $this->form_validation->set_rules(
            'password1',
            'password',
            'required|trim|min_length[3]|matches[password2]',
            [
                'matches' => 'password dont matches !',
                'min_length' => 'password too short !'
            ]
        );
        $this->form_validation->set_rules('password2', 'password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                'password' => password_hash(
                    $this->input->post('password1'),
                    PASSWORD_DEFAULT
                ),
                'role_id' => 2,
                'is_active' => 1,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success role="alert">Congratulation your account has been
                    created. Please Login</div>'
            );
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success role="alert">You have been logout.</div>'
        );
        redirect('auth');
    }

    public function block()
    {
        $data['title'] = "Forbidden";
        $this->load->view('auth/block', $data);
    }
}
