<?php

class overtime_room_model extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
     
     function list_overtime(){
        $this->db->select('Name,SName,Date,Time_Begin,Time_End,Room,Detail,overtime_room.No as otr_no');
        $this->db->join('account', 'account.No = No_account'); 
        $this->db->order_by("Date","desc");
        $query = $this->db->get('overtime_room');
        return $query->result();
     }

    function select_where($where){
    	$this->db->where($where);
        $query = $this->db->get('overtime_room'); 
        return $query;
    } 
    
    function delete($no){
        $this->db->where('No', $no);
        $this->db->delete('overtime_room'); 
    } 

    function insert($data){
    	$this->db->insert('overtime_room', $data);
    }

    function update($no,$data){
        $this->db->where('No', $no);
        $this->db->update('overtime_room', $data); 
    }
}

?>