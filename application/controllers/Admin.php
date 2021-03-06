<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('general_model');
    is_logged_in();
  }

  public function index()
  {
    $data['title'] = 'Dashboard';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('admin/index');
    $this->load->view('templates/footer');
  }

  public function role()
  {
    $data['title'] = 'Role';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $data['role'] = $this->db->get('user_role')->result_array();

    $this->form_validation->set_rules('role', 'Role', 'required');
    if ($this->form_validation->run() == FALSE) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('admin/role');
      $this->load->view('templates/footer');
    } else {
      $this->db->insert('user_role', ['role' => $this->input->post('role')]);
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">New role added!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>');
      redirect('admin/role');
    }
  }

  public function deleteRole()
  {
    $id = 'id';
    $id_menu = $this->uri->segment(3);
    $table = 'user_role';
    $this->general_model->delete($id, $id_menu, $table);
    redirect('admin/role');
  }

  public function editRole()
  {
    $id = $this->input->post('id');
    $name = $this->input->post('role');

    $data = [
      'id' => $id,
      'role' => $name
    ];
    $this->db->where('id', $id);
    $this->db->update('user_role', $data);
    redirect('admin/role');
  }

  public function roleAccess($role_id)
  {
    $data['title'] = 'Role Access';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();
    $this->db->where('id !=', 1);
    $data['menu'] = $this->db->get('user_menu')->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('admin/role-access');
    $this->load->view('templates/footer');
  }

  public function changeAccess()
  {
    $menu_id = $this->input->post('menuId');
    $role_id = $this->input->post('roleId');
    $data = [
      'role_id' => $role_id,
      'menu_id' => $menu_id
    ];

    $result = $this->db->get_where('user_access_menu', $data);

    if ($result->num_rows() < 1) {
      $this->db->insert('user_access_menu', $data);
    } else {
      $this->db->delete('user_access_menu', $data);
    }

    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Access Changed!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>');
  }
}

/* End of file Admin.php */
