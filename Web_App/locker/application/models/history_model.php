<?php

class History_model extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }

    function list_year(){
        $this->db->group_by("Year"); 
        $this->db->order_by("Year","DESC");
        $query = $this->db->get('history');
        return $query->result();
    }

    public function get_count($field,$where){
        $this->db->select($field);
        $this->db->where($where);
        $query = $this->db->get('history'); 
        return $query;
    }

    function select_where($sql){
        $query = $this->db->query($sql);
        return $query;   
    }

    function sort($where){
        $this->db->select('No_account,Name,SName');
        $this->db->where($where);
        $this->db->join('account', 'account.No = No_account');
        $this->db->group_by('No_account');
        $this->db->order_by('count(No_account)','desc');
        $query = $this->db->get('history'); 
        return $query->result();
    }

    public function list_history($where,$st){
        if($st == "join"){
            $this->db->select('Name,SName,Begin,End,Room,Detail,Year,Term');
            $this->db->where($where);
            $this->db->join('overtime_room', 'overtime_room.No = No_overtime');
            $this->db->join('account', 'account.No = history.No_account');
        }else{
            $this->db->select('Begin,End,Name,SName,Number_Room,Year,Term,UserName,Status,No_account,No_timetable,history.No as ht_no');
            $this->db->where($where);
            $this->db->join('account', 'account.No = No_account');
            $this->db->join('number_locker', 'number_locker.No = No_numberlocker');
            $this->db->order_by("Begin","desc");
        }
        $query = $this->db->get('history'); 
        return $query->result();
    }

    function update($no,$detail){
        $this->db->where('No', $no);
        $this->db->update('history',$detail); 
    }


}

?>