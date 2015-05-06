<?php

class numberlocker_model extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
    
    function list_number(){
        $this->db->order_by("No","ASC");
        $query = $this->db->get('number_locker');
        return $query->result();
    }

    function update($no,$data){       
        $this->db->where('No', $no);
        $this->db->update('number_locker', $data);  
    }   

}

?>