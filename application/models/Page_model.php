<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Page_model extends CI_Model {

        public function __construct()
        {
//                $this->load->database();
        }
        public function get_page($slug = FALSE)
{
//        if ($slug === FALSE)
//        {
//                $query = $this->db->get('page');
//                return $query->result_array();
//        }
//
//        $query = $this->db->get_where('page', array('slug' => $slug));
//        return $query->row_array();
}
public  function check_user(){
//       $this->load->helper('url');
//
//    $slug = url_title($this->input->post('title'), 'dash', TRUE);
//
//    $data = array(
//        'title' => $this->input->post('title'),
//        'slug' => $slug,
//        'text' => $this->input->post('text')
//    );
//
//    return $this->db->insert('page', $data);
}
}
