<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class overtime_room_controller extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('account_model');
        $this->load->model('overtime_room_model');
        $this->load->model('config_model');
        $this->load->model('subject_table_model');
    }

    public function getday($date){
        $day = date("l",strtotime($date));
        if($day == "Monday"){
            $day = "จันทร์";
        }else if($day == "Tuesday"){
            $day = "อังคาร";
        }else if($day == "Wednesday"){
            $day = "พุธ";
        }else if($day == "Thursday"){
            $day = "พฤหัสบดี";
        }else if($day == "Friday") {
            $day = "ศุกร์";
        }
        return $day;
    }

    public function add(){
        $user = $this->input->post('no_account');
        $date = $this->input->post('date');
        $time_f = $this->input->post('time_f');
        $time_e = $this->input->post('time_e');
        $room = $this->input->post('room');
        $detail = $this->input->post('detail');

        $arrayData = array(
                            'No' =>'',
                            'No_account' => $user,
                            'Date' => $date,
                            'Time_Begin' => $time_f,
                            'Time_End' => $time_e,
                            'Room' => $room,
                            'Detail' => $detail
                          );

        $result = $this->overtime_room_model->select_where(array('No_account' => $user,'Date' => $date,'Time_Begin' => $time_f,'Time_End' => $time_e,'Room' => $room));
        
        if( $result->num_rows() == 0 ){
            $rs_date = $this->config_model->list_date(array('sDate <= '=> $date,'eDate >=' => $date ));
            if($rs_date->num_rows() > 0){
                $rs_date = $rs_date->row();
                $year = $rs_date->Year;
                $term = $rs_date->Term;
                $s_time = explode(":",$time_f);
                $e_time = explode(":",$time_e);
                $stime = $s_time[0].".".$s_time[1]; 
                $etime = $e_time[0].".".$e_time[1];
                $day = $this->getday($date);
                $sql = "Year = ".$year." and Term = ".$term." and Day = '".$day."' and Room = ".$room." and ( (Time_Begin <= ".$stime." and Time_End > ".$stime.") or (Time_Begin < ".$etime." and Time_End >= ".$etime.") or (Time_Begin >= ".$stime." and Time_End <= ".$etime.") )";
                $rs_st = $this->subject_table_model->select_where($sql); 
                if(count($rs_st) == 0){ // เช็คห้องซ้อนกับตารางสอนไหม 
                    $sql = "Date = '".$date."' and Room = '".$room."' and ( (Time_Begin <= '".$time_f."' and Time_End > '".$time_f."' ) or (Time_Begin < '".$time_e."' and Time_End >= '".$time_e."' ) )";
                    $rs_ot = $this->overtime_room_model->select_where($sql);
                    if(count($rs_ot->result()) == 0){ // เช็คขอใช้ห้อง
                        $this->overtime_room_model->insert($arrayData);
                        echo "บันทึกข้อมูลเรียบร้อย";
                    }else{
                        echo "มีอาจารย์ท่านอื่นขอใช้ห้องนี้แล้ว";
                    }
                }else{
                    echo "ห้องไม่ว่าง มีอาจารย์ท่านอื่นใช้อยู่";
                }
            }else{
                $this->overtime_room_model->insert($arrayData);
                echo "บันทึกข้อมูลเรียบร้อย";
            }

        }else{
            echo "คุณกรอกข้อมูลซ้ำ กรุญากรอกใหม่";
        }
    }

    public function delete() {
        $no = $this->input->post('no');
        $this->overtime_room_model->delete($no);
    }

    public function edit(){
        $no = $this->input->post('no');
        $user = $this->input->post('no_account');
        $date = $this->input->post('date');
        $time_f = $this->input->post('time_f');
        $time_e = $this->input->post('time_e');
        $room = $this->input->post('room');
        $detail = $this->input->post('detail');
        $b_user = $this->input->post('b_no_account');
        $b_date = $this->input->post('b_date');
        $b_time_f = $this->input->post('b_time_f');
        $b_time_e = $this->input->post('b_time_e');
        $b_room = $this->input->post('b_room');

        $arrayData = array(
                            'No_account' => $user,
                            'Date' => $date,
                            'Time_Begin' => $time_f,
                            'Time_End' => $time_e,
                            'Room' => $room,
                            'Detail' => $detail
                          );

        if( $b_user == $user && $b_date == $date && $b_time_f == $time_f && $b_time_e == $time_e && $b_room == $room ){
            $this->overtime_room_model->update($no,$arrayData);
            echo "บันทึกข้อมูลเรียบร้อย";
        }else{
            $rs_date = $this->config_model->list_date(array('sDate <= '=> $date,'eDate >=' => $date ));
            if($rs_date->num_rows() > 0){
                $rs_date = $rs_date->row();
                $year = $rs_date->Year;
                $term = $rs_date->Term;
                $s_time = explode(":",$time_f);
                $e_time = explode(":",$time_e);
                $stime = $s_time[0].".".$s_time[1]; 
                $etime = $e_time[0].".".$e_time[1];
                $day = $this->getday($date);
                $sql = "Year = ".$year." and Term = ".$term." and Day = '".$day."' and Room = ".$room." and ( (Time_Begin <= ".$stime." and Time_End > ".$stime.") or (Time_Begin < ".$etime." and Time_End >= ".$etime.") or (Time_Begin >= ".$stime." and Time_End <= ".$etime.") )";
                $rs_st = $this->subject_table_model->select_where($sql); 
                if(count($rs_st) == 0){ // เช็คห้องซ้อนกับตารางสอนไหม 
                    $sql = "No_account != ".$b_user." and No_account != ".$user." and Date = '".$date."' and Room = '".$room."' and ( (Time_Begin <= '".$time_f."' and Time_End > '".$time_f."' ) or (Time_Begin < '".$time_e."' and Time_End >= '".$time_e."' ) )";
                    $rs_ot = $this->overtime_room_model->select_where($sql);
                    if(count($rs_ot->result()) == 0){ // เช็คขอใช้ห้อง
                        $this->overtime_room_model->update($no,$arrayData);
                        echo "บันทึกข้อมูลเรียบร้อย";
                    }else{
                        echo "มีอาจารย์ท่านอื่นขอใช้ห้องนี้แล้ว";
                    }
                }else{
                    echo "ห้องไม่ว่าง มีอาจารย์ท่านอื่นใช้อยู่";
                }
            }else{
                $this->overtime_room_model->update($no,$arrayData);
                echo "บันทึกข้อมูลเรียบร้อย";
            }

        }
    }

    /*                         view                                     */
    
    public function view_add() {
      if($this->session->userdata("sess_username") != null){

        $data['user'] = $this->account_model->list_account();
        $this->load->view('main/header');
        $this->load->view('overtimeroom/menu');
        $this->load->view('overtimeroom/add',$data);
        $this->load->view('main/footer');
       }else{

        redirect('account_controller/view_login','refresh');
      }
    }

    public function view_edit() {
      if($this->session->userdata("sess_username") != null){

        $no =  base64_decode($this->input->get('id'));
        $data['result'] = $this->overtime_room_model->select_where(array('No' => $no));
        if( count($data['result']->result()) > 0){
            $data['user'] = $this->account_model->list_account();

            $this->load->view('main/header');
            $this->load->view('overtimeroom/menu');
            $this->load->view('overtimeroom/edit',$data);
            $this->load->view('main/footer');
        }else{
            $this->load->view('main/header');
            $this->load->view('overtimeroom/menu');
            $this->load->view('main/found');
            $this->load->view('main/footer');
        }
      }else{

        redirect('account_controller/view_login','refresh');
      }
    }

    public function view_show(){
      if($this->session->userdata("sess_username") != null){

        $data['result'] = $this->overtime_room_model->list_overtime();
        $this->load->view('main/header');
        $this->load->view('overtimeroom/menu');
        $this->load->view('overtimeroom/show',$data);
        $this->load->view('main/footer');
      }else{

        redirect('account_controller/view_login','refresh');
      }  
    }

}
