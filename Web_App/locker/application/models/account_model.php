<?php

class account_model extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
    
    function list_account(){
        $query = $this->db->get('account'); 
        return $query->result();
    } 

    function select_where($where){
    	$this->db->where($where);
        $query = $this->db->get('account'); 
        return $query;
    } 

    function not_in_account($where){
        $this->db->where_not_in('No', $where);
        $query = $this->db->get('account'); 
        return $query->result();
    }
    
    function delete($no){
        $this->db->where('No', $no);
        $this->db->delete('account'); 
    } 

    function insert($data){
    	$this->db->insert('account', $data);
    }

    function update($no,$data){
        $this->db->where('No', $no);
        $this->db->update('account', $data); 
    }

    function getuser_number(){
    	$this->db->select_max('No');
		$query = $this->db->get('account');
		return $query;
    }
    
    function check_insert($rfid,$name,$sname,$username){
    	$this->db->where('Name',$name);
    	$this->db->where('Sname',$sname);
    	$this->db->or_where('RfidTag',$rfid);
    	$this->db->or_where('UserName',$username);
        $query = $this->db->get('account');
        return $query->result();
    }
}

?>