<?php

class subject_table_model extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
    
    function select_where($where){
        $this->db->where($where);
        $query = $this->db->get('subject_timetable');
        return $query->result();

    }

    function select_where_join($where){
        $this->db->select('*,subject.Name as Sj_Name,subject_timetable.No as Sjt_No,subject.Level as s_level');
        $this->db->where($where);
        $this->db->join('subject', 'subject.No = No_subject');
        $this->db->join ('account','account.No = No_account');
        $query = $this->db->get('subject_timetable'); 
        return $query;
    }
    
    function get_count($field,$where){
        $this->db->select($field);
        $this->db->where($where);
        $query = $this->db->get('subject_timetable'); 
        return $query;
    }

    function insert($data){       
        $this->db->insert('subject_timetable', $data); 
    }  

    function update($id,$data){
        $this->db->where('No', $id);
        $this->db->update('subject_timetable', $data); 
    }

    function delete($id,$data){
        $this->db->where('No', $id);
        $this->db->delete('subject_timetable'); 
    }

    function list_table($data,$day){
        $this->db->select('*,subject_timetable.No as etc');
        $this->db->where("No_account",$data['No_account']);
        $this->db->where("Year",$data['Year']);
        $this->db->where("Term",$data['Term']);
        $this->db->where("Day",$day);
        $this->db->order_by("Time_Begin","asc");
        $this->db->join('subject', 'subject.No = No_subject');        
        $query = $this->db->get('subject_timetable');
        return $query->result();
    }

    function list_tablesubject($user,$year,$term){
        $this->db->select('*,account.Name as a_name,subject.Name as s_name,subject_timetable.No as st_no,subject.Level as s_level');
        $this->db->where($user);
        $this->db->where($year);
        $this->db->where($term);
        $this->db->order_by("No_account","asc");
        $this->db->order_by("Year","desc");
        $this->db->order_by("Term","desc");
        $this->db->join('subject', 'subject.No = No_subject');  
        $this->db->join('account', 'account.No = No_account');       
        $query = $this->db->get('subject_timetable');
        return $query->result();
    }

    function list_year($no_account){
        if( $no_account > 0 ){
            $this->db->where('No_account',$no_account);
        }
        $this->db->group_by("Year"); 
        $this->db->order_by("Year","DESC");
        $query = $this->db->get('subject_timetable');
        return $query->result();
    }

    function list_term($data){
        $this->db->where($data);
        $this->db->group_by("Term"); 
        $this->db->order_by("Term","DESC");
        $query = $this->db->get('subject_timetable');
        return $query->result();
    }
    
}

?>