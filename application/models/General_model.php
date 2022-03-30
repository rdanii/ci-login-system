<?php


defined('BASEPATH') or exit('No direct script access allowed');

class General_model extends CI_Model
{
  public function delete($id, $where_id, $table)
  {
    $this->db->where($id, $where_id);
    $this->db->delete($table);
  }

  public function getSubmenu()
  {
    $query = "SELECT `user_sub_menu`.*, `user_menu`.`menu`
            From `user_sub_menu` Join `user_menu`
            On `user_sub_menu`.`menu_id` = `user_menu`.`id`";
    return $this->db->query($query)->result_array();
  }
}

/* End of file General_model.php */
