<?php

class historynumber_model extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
    
    function list_number($no){
        $this->db->where("No_account",$no);
        $this->db->group_by("No_number"); 
        $this->db->order_by("No_number","ASC");
        $query = $this->db->get('history_numberlocker');
        return $query->result();
    }

    function insert($data){       
        $this->db->insert('history_numberlocker', $data); 
    }   

    function delete($no){
        $this->db->where('No_account', $no);
        $this->db->delete('history_numberlocker'); 
    }
}

?>