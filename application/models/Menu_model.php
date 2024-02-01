<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function getSubMenu()
    {
        $query = "SELECT `user_sub_menu`.*, `user_menu`.`menu`
                  FROM `user_sub_menu` JOIN `user_menu`
                  ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                ";
        return $this->db->query($query)->result_array();
    }

    public function getRole()
    {
        $this->db->select('user.*, user_role.id AS id_role, user_role.role');
        $this->db->join('user_role','user.role_id = user_role.id');      
        $this->db->from('user');
        $query = $this->db->get();
        return $query->result();
    }
}
