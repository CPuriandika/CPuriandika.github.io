<?php

function cek_login()
{
    $ci = get_instance();
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);

        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $queryMenu['id'];

        $query_access = $ci->db->get_where(
            'user_access_menu',
            ['role_id' => $role_id, 'menu_id' => $menu_id]
        );

        if ($query_access->num_rows() < 1) {
            redirect('auth/block');
        }
    }
}

function checkAccess($role_id, $menu_id)
{
    $ci = get_instance();

    $data = [
        'role_id' => $role_id,
        'menu_id' => $menu_id
    ];
    $result = $ci->db->get_where('user_access_menu', $data);
    if ($result->num_rows() > 0) {
        return 'checked';
    }
}
