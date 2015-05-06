<?php

class config_model extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
    
    /*            table setdate               */

    function list_date($where){
        $this->db->where($where); 
        $this->db->order_by("Year","desc");
        $this->db->order_by("Term","desc");
        $query = $this->db->get('setdate');
        return $query;
    }
    function update_setdate($where,$data){
        $this->db->where($where);
        $this->db->update('setdate', $data);
    }

    function insert_setdate($data){
        $this->db->insert('setdate', $data);
    }

    function delete_setdate($no){
        $this->db->where('No', $no);
        $this->db->delete('setdate'); 
    } 

    /*            table config               */

    function update($where,$data){
        $this->db->where($where);
        $this->db->update('config', $data);
    }

    function list_config(){
        $query = $this->db->get('config'); 
        return $query;
    }
}

?>