<?php

class account_model extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
    
    function list_account(){
        $this->db->where('Flag',"1");
        $this->db->where('No >',"1");
        $this->db->order_by("Name");
        $query = $this->db->get('account'); 
        return $query->result();
    } 

    function select_where($where){
    	$this->db->where($where);
        $query = $this->db->get('account'); 
        return $query;
    } 

    function not_in_account($where){
        $this->db->where('No >',1);
        $this->db->where_not_in('No', $where);
        $query = $this->db->get('account'); 
        return $query->result();
    }
    
    function delete($no,$data){
        //$this->db->where('No', $no);
        //$this->db->delete('account'); 
        $this->db->where('No', $no);
        $this->db->update('account', $data); 
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
    function check_insert($rfid,$username){
        $this->db->where("Flag = '1' and ( RfidTag = '".$rfid."' OR UserName = '".$username."')");
        $query = $this->db->get('account');
        return $query->result();
    }
    /*function check_insert($rfid,$name,$sname,$username){
    	$this->db->where('Name',$name);
    	$this->db->where('Sname',$sname);
        $this->db->where('Flag',"1");
    	$this->db->or_where('RfidTag',$rfid);
    	$this->db->or_where('UserName',$username);
        $query = $this->db->get('accounts');
        return $query->result();
    }*/
}

?>