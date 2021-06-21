<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
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
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' =>
		$this->session->userdata('email')])->row_array();
		$id_user=$this->session->userdata('id');

		$this->db->select('*');
		$this->db->from('invoice');
		$this->db->join('pesanan','pesanan.no_invoice = invoice.no_invoice');
		$this->db->where('status', 3);
		$data['psn_tot']=$this->db->get()->num_rows();

		$this->db->select_sum('tot_biaya');
		$this->db->from('pesanan');
		$this->db->join('invoice','pesanan.no_invoice = invoice.no_invoice');
		$this->db->where('status', 3);
		$data['psn_ba']=$this->db->get()->row();

		$this->db->select('*');
		$this->db->from('invoice');
		$this->db->join('pesanan','pesanan.no_invoice = invoice.no_invoice');
		$this->db->where('status', 2);
		$data['psn_kon']=$this->db->get()->num_rows();



		$this->db->select('*');
		$this->db->from('pesanan');
		$this->db->join('invoice','pesanan.no_invoice = invoice.no_invoice');
		$this->db->where('status', 2);
		$data['psn']= $this->db->get()->result_array();

		

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    // public function role()
    // {
    //     $data['role'] = $this->db->get('user_role')->result_array();
    //     $data['title'] = 'Role';
    //     $data['user'] = $this->db->get_where('user', ['email' =>
    //     $this->session->userdata('email')])->row_array();

    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/sidebar', $data);
    //     $this->load->view('templates/topbar', $data);
    //     $this->load->view('admin/role', $data);
    //     $this->load->view('templates/footer');
    // }

    // public function roleAccess($role_id)
    // {

    //     $data['title'] = 'Role Acces';
    //     $data['user'] = $this->db->get_where('user', ['email' =>
    //     $this->session->userdata('email')])->row_array();

    //     $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();
    //     $data['menu'] = $this->db->get_where('user_menu', ['id !=' => '1'])->result_array();

    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/sidebar', $data);
    //     $this->load->view('templates/topbar', $data);
    //     $this->load->view('admin/role-access', $data);
    //     $this->load->view('templates/footer');
    // }

    // public function changeAccess()
    // {
    //     $roleId = $this->input->post('roleId');
    //     $menuId = $this->input->post('menuId');

    //     $result = $this->db->get_where('user_access_menu', ['role_id' => $roleId, 'menu_id' => $menuId]);
    //     if ($result->num_rows() > 0) {
    //         $this->db->where('role_id', $roleId);
    //         $this->db->where('menu_id', $menuId);
    //         $this->db->delete('user_access_menu');
    //     } else {
    //         $this->db->insert('user_access_menu', ['role_id' => $roleId, 'menu_id' => $menuId]);
    //     }
    // }
}
