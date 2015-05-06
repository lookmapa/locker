<?php

class Subject_model extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
    
    function select_where($where){
        $this->db->where($where);
        $query = $this->db->get('subject');
        return $query;
    }

    function select_where_or($data){
        $this->db->or_where($data);
        $query = $this->db->get('subject');
        return $query;
    }

    function list_subject($data){
    	if($data == "all"){
       		$query = $this->db->get('subject');
    	}else{
    		$this->db->or_like('Id',$data,'both');
    		$this->db->or_like('Name',$data,'both');
    		$this->db->or_like('Hours',$data,'both');
        	$query = $this->db->get('subject');
    	}
        return $query->result();
    }
    
    function insert($data){       
        $this->db->insert('subject', $data); 
    } 

    function delete($no){
        $this->db->where('No', $no);
        $this->db->delete('subject'); 
    }
    
    function update($id,$data){
    	$this->db->where('Id', $id);
		$this->db->update('subject', $data); 
    }
    
}

?>