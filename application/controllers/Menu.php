<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('general_model');
    is_logged_in();
  }

  public function index()
  {
    $data['title'] = 'Menu Management';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $data['menu'] = $this->db->get('user_menu')->result_array();

    $this->form_validation->set_rules('menu', 'Menu', 'required');
    if ($this->form_validation->run() == FALSE) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('menu/index');
      $this->load->view('templates/footer');
    } else {
      $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">New menu added!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>');
      redirect('menu');
    }
  }

  public function delete()
  {
    $id = 'id';
    $id_menu = $this->uri->segment(3);
    $table = 'user_menu';
    $this->general_model->delete($id, $id_menu, $table);
    redirect('menu');
  }

  public function deleteSubMenu()
  {
    $id = 'id';
    $id_menu = $this->uri->segment(3);
    $table = 'user_sub_menu';
    $this->general_model->delete($id, $id_menu, $table);
    redirect('menu/submenu');
  }

  public function edit()
  {
    $id = $this->input->post('id');
    $name = $this->input->post('menu');

    $data = [
      'id' => $id,
      'menu' => $name
    ];
    $this->db->where('id', $id);
    $this->db->update('user_menu', $data);
    redirect('menu');
  }

  public function editSubmenu()
  {
    $id = $this->input->post('id');
    $title = $this->input->post('title');
    $menu_id = $this->input->post('menu_id');
    $url = $this->input->post('url');
    $icon = $this->input->post('icon');
    $is_active = $this->input->post('is_active');

    $data = [
      'id' => $id,
      'title' => $title,
      'menu_id' => $menu_id,
      'url' => $url,
      'icon' => $icon,
      'is_active' => $is_active
    ];
    $this->db->where('id', $id);
    $this->db->update('user_sub_menu', $data);
    redirect('menu/submenu');
  }

  public function submenu()
  {
    $data['title'] = 'Submenu Management';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    $data['submenu'] = $this->general_model->getSubmenu();
    $data['menu'] = $this->db->get('user_menu')->result_array();

    $this->form_validation->set_rules('title', 'Title', 'required');
    $this->form_validation->set_rules('menu_id', 'Menu', 'required');
    $this->form_validation->set_rules('url', 'URL', 'required');
    $this->form_validation->set_rules('icon', 'icon', 'required');

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('templates/topbar');
      $this->load->view('menu/submenu');
      $this->load->view('templates/footer');
    } else {
      $data = [
        'title' => $this->input->post('title'),
        'menu_id' => $this->input->post('menu_id'),
        'url' => $this->input->post('url'),
        'icon' => $this->input->post('icon'),
        'is_active' => $this->input->post('is_active')
      ];
      $this->db->insert('user_sub_menu', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">New sub menu added!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>');
      redirect('menu/submenu');
    }
  }
}

/* End of file Menu.php */
