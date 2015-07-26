<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subject_table_controller extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('subject_model');
        $this->load->model('subject_table_model');
        $this->load->model('account_model');
    }

    public function add() {

      $no_account = $this->input->post('no_account');
      $no_subject = $this->input->post('no_subject');
      $year = $this->input->post('year');
      $term = $this->input->post('term');
      $day = $this->input->post('day');
      $time_b = $this->input->post('time_b');
      $time_e = $this->input->post('time_e');
      $group = $this->input->post('group');
      $town = $this->input->post('town');
      $room = $this->input->post('room');

      $arrayData = array(
                      'No' => '',
                      'No_account' => $no_account,
                      'No_subject' => $no_subject,
                      'Year' => $year,
                      'Term' => $term,
                      'Day' => $day,
                      'Time_Begin' => (float)$time_b,
                      'Time_End' => (float)$time_e,
                      'Group' => $group,
                      'Town' => $town,
                      'Room' => $room 
                      );

      $result = $this->subject_table_model->select_where(array('Year' => $year,'Term' => $term,'Day' => $day ));
        $time_db = "";
        $time_come = "";
        $status = 0;

        if(count($result) > 0){
          foreach ($result as $row) {
            if((intval($row->Time_Begin)) <= 11){
              $time_db = "เช้า";
            }else if((intval($row->Time_Begin)) <= 16){
              $time_db = "บ่าย";
            }else{
              $time_db = "เย็น";
            }

            if((intval($time_b)) <= 11){
              $time_come = "เช้า";
            }else if((intval($time_b)) <= 16){
              $time_come = "บ่าย";
            }else{
              $time_come = "เย็น";
            }
            
            if($time_db == $time_come){
              if( ((intval($time_b)) > (intval($row->Time_Begin)) || (intval($time_b)) == (intval($row->Time_Begin))) &&  ((intval($time_b)) < (intval($row->Time_End)) )  ){
                if( $row->Town == $town && $row->Room == $room && $row->No_account != $no_account){
                  if( $row->No_subject == $no_subject && $row->Group == $group ){
                    if( (intval($row->Time_Begin)) == (intval($time_b)) && (intval($row->Time_End)) == (intval($time_e)) ){
                      $status = "pass";
                    }else{
                      $status = "time";
                      break;
                    }                    
                  }else{
                    $status = "group or subject";
                    break;
                  }
                }else{
                  if( $row->No_subject == $no_subject && $row->Group == $group ){
                    if( intval($row->Time_Begin) == intval($time_b) && intval($row->Time_End) == intval($time_e) && intval($row->No_account) == intval($no_account) ){
                      $status = "error";
                      break;
                    }else if( (intval($row->Time_Begin)) == (intval($time_b)) && (intval($row->Time_End)) == (intval($time_e)) ){
                      $status = "pass";
                    }else{
                      if( intval($row->No_account) != intval($no_account)  ){
                         $status = "pass";
                      }else{
                        $status = "time";
                        break;
                      }
                    } 
                  }else{
                    if( intval($row->No_account) != intval($no_account) ){
                      $status = "pass";
                    }else{
                        $status = "error";
                        break;
                    }                 
                  }
                }
              }else{
                if( intval($row->Time_Begin) == intval($time_e) || intval($row->Time_End) == intval($time_b) ){
                  $status = "pass";
                }else{
                  if( $row->Town == $town && $row->Room == $room ){
                    $status = "error";
                    break;
                  }else{
                    $status = "pass";
                  }  
                }
              }
            }else{
              $status = "pass";
            }
          }
        }else{
          $status = "pass";
        }
        if( $status == "pass"){
          $this->subject_table_model->insert($arrayData);
          echo $status;
        }else{
          echo $status;
        }      
    }

    public function edit() {
      $no_edit = $this->input->post('no_edit');
      $no_account = $this->input->post('no_account');
      $no_subject = $this->input->post('no_subject');
      $year = $this->input->post('year');
      $term = $this->input->post('term');
      $day = $this->input->post('day');
      $time_b = $this->input->post('time_b');
      $time_e = $this->input->post('time_e');
      $group = $this->input->post('group');
      $town = $this->input->post('town');
      $room = $this->input->post('room');
      $b_no_account = $this->input->post('b_no_account');
      $b_no_subject = $this->input->post('b_no_subject');
      $b_year = $this->input->post('b_year');
      $b_term = $this->input->post('b_term');
      $b_day = $this->input->post('b_day');
      $b_time_b = $this->input->post('b_time_b');
      $b_time_e = $this->input->post('b_time_e');
      $b_group = $this->input->post('b_group');
      $b_town = $this->input->post('b_town');
      $b_room = $this->input->post('b_room');
      
      $arrayData = array(
                      'No_account' => $no_account,
                      'No_subject' => $no_subject,
                      'Year' => $year,
                      'Term' => $term,
                      'Day' => $day,
                      'Time_Begin' => (float)$time_b,
                      'Time_End' => (float)$time_e,
                      'Group' => $group,
                      'Town' => $town,
                      'Room' => $room 
                      );

      if( 
        $no_account == $b_no_account && $no_subject == $b_no_subject && $year == $b_year && $term == $b_term &&
        $day == $b_day && $time_b == $b_time_b && $time_e == $b_time_e && $group == $b_group && $town == $b_town && $room == $b_room
      ){
        echo "แก้ไขข้อมูลสำเร็จ";
      }else if( $no_account == $b_no_account ){
        $result = $this->subject_table_model->select_where(array('Year' => $year,'Term' => $term,'Day' => $day ));
        $time_db = "";
        $time_come = "";
        $status = 0;

        if(count($result) > 0){
          foreach ($result as $row) {
            if((intval($row->Time_Begin)) <= 11){
              $time_db = "เช้า";
            }else if((intval($row->Time_Begin)) <= 16){
              $time_db = "บ่าย";
            }else{
              $time_db = "เย็น";
            }

            if((intval($time_b)) <= 11){
              $time_come = "เช้า";
            }else if((intval($time_b)) <= 16){
              $time_come = "บ่าย";
            }else{
              $time_come = "เย็น";
            }

            if($time_db == $time_come){
              if( ((intval($time_b)) > (intval($row->Time_Begin)) || (intval($time_b)) == (intval($row->Time_Begin))) &&  ((intval($time_b)) < (intval($row->Time_End)) )  ){
                if( $row->Town == $town && $row->Room == $room && $row->No_account != $no_account){
                  if( $row->No_subject == $no_subject && $row->Group == $group ){
                    if( (intval($row->Time_Begin)) == (intval($time_b)) && (intval($row->Time_End)) == (intval($time_e)) ){
                      $status = "pass";
                    }else{
                      $status = "time";
                      break;
                    }                    
                  }else{
                    $status = "group or subject";
                    break;
                  }
                }else{
                  $result2 = $this->subject_table_model->select_where(array('Year' => $year,'Term' => $term,'Day' => $day,'No_account' => $no_account,'Time_Begin <=' => $time_b,'Time_End >' => $time_b ));
                  if(count($result2) == 0){
                    $status = "pass";
                  }else{
                    $status = "fail";
                  }
                }
              }else{
                $status = "pass";
              }
            }else{
              $status = "pass";
            }
          }
        }else{
          $status = "pass";
        }
        if( $status == "pass"){
          $this->subject_table_model->update($no_edit,$arrayData);
          echo "แก้ไขข้อมูลสำเร็จ";
        }else{
          echo $status;
        }
      }else{
        $result = $this->subject_table_model->select_where(array('Year' => $year,'Term' => $term,'Day' => $day ));
        $time_db = "";
        $time_come = "";
        $status = 0;

        if(count($result) > 0){
          foreach ($result as $row) {
            if((intval($row->Time_Begin)) <= 11){
              $time_db = "เช้า";
            }else if((intval($row->Time_Begin)) <= 16){
              $time_db = "บ่าย";
            }else{
              $time_db = "เย็น";
            }

            if((intval($time_b)) <= 11){
              $time_come = "เช้า";
            }else if((intval($time_b)) <= 16){
              $time_come = "บ่าย";
            }else{
              $time_come = "เย็น";
            }

            if($time_db == $time_come){
              if( ((intval($time_b)) > (intval($row->Time_Begin)) || (intval($time_b)) == (intval($row->Time_Begin))) &&  ((intval($time_b)) < (intval($row->Time_End)) )  ){
                if( $row->Town == $town && $row->Room == $room ){
                  if( $row->No_subject == $no_subject && $row->Group == $group ){
                    if( (intval($row->Time_Begin)) == (intval($time_b)) && (intval($row->Time_End)) == (intval($time_e)) && intval($row->No_account) != intval($no_account)){
                      $status = "pass";
                    }else{
                      $status = "time";
                      break;
                    }                     
                  }else{
                    if( $row->No_account == $no_account ){
                      $status = "user";
                      break;
                    }else{
                      $status = "group or subject";
                      break;
                    }
                  }
                }else{
                  $status = "pass";
                }
              }else{
                if( $row->No_account == $no_account ){
                  if( intval($row->Time_Begin) == intval($time_e) || intval($row->Time_End) == intval($time_b) ){
                    $status = "pass";
                  }else{
                    $status = "time";
                    break;
                  } 
                }else{
                  if( $row->Town == $town && $row->Room == $room ){
                    if( $row->No_subject == $no_subject && $row->Group == $group ){
                      if( (intval($row->Time_Begin)) == (intval($time_b)) && (intval($row->Time_End)) == (intval($time_e)) ){
                        $status = "pass";
                      }else{
                        if( intval($row->Time_Begin) == intval($time_e) || intval($row->Time_End) == intval($time_b) ){
                          $status = "pass";
                        }else{
                          $status = "time";
                          break;
                        }    
                      }                    
                    }else{
                      $status = "pass";
                    }
                  }else{
                    $status = "pass";
                  }
                }
              }
            }else{
              $status = "pass";
            }
          }
        }else{
          $status = "pass";
        }
        if( $status == "pass"){
          $this->subject_table_model->update($no_edit,$arrayData);
          echo "แก้ไขข้อมูลสำเร็จ";
        }else{
          echo $status;
        }
      }
    }

    public function delete() {
      $no = $this->input->post('no');
      $this->subject_table_model->delete($no);
    }


    public function list_year(){
      $no_account = $this->input->post('no_account');
      $result = $this->subject_table_model->list_year($no_account); 
      if(count($result)>0){
        foreach ($result as $row):
          echo $row->Year.",";
        endforeach;
      }else{
          echo "error";
      }               
    }

    public function list_term(){
      $year = $this->input->post('year');
      $no_account = $this->input->post('no_account');
      $result = $this->subject_table_model->list_term(array('No_account' => $no_account,'Year' => $year )); 
      if(count($result)>0){
        foreach ($result as $row):
          echo $row->Term.",";
        endforeach;
      }else{
          echo "error";
      }               
    }

    public function list_table() {
      $data['No_account'] = $this->input->post('no_account');
      $data['Year'] = $this->input->post('year');
      $data['Term'] = $this->input->post('term');
      $data['result'] = $this->subject_table_model->list_table($data,"จันทร์");
      $data['result2'] = $this->subject_table_model->list_table($data,"อังคาร");
      $data['result3'] = $this->subject_table_model->list_table($data,"พุธ");
      $data['result4'] = $this->subject_table_model->list_table($data,"พฤหัสบดี");
      $data['result5'] = $this->subject_table_model->list_table($data,"ศุกร์");
      $this->load->view('table_subject/list_table',$data);
    }

    /*                         view                                     */
    
    
    public function view_add() {
      if($this->session->userdata("sess_username") != null){

        $result = $this->subject_model->list_subject("all");
        $account = $this->account_model->list_account();

        if(count($result) > 0){
            if(count($account) > 0){
              $data['user'] = $this->account_model->list_account();
              $this->load->view('main/header');
              $this->load->view('table_subject/menu');
              $this->load->view('table_subject/add',$data);
              $this->load->view('main/footer');
            }else{
              $data['data'] = "ต้องทำการเพิ่มบัญชีผู้ใช้งานก่อน";
              $this->load->view('main/header');
              $this->load->view('table_subject/menu');
              $this->load->view('main/found',$data);
              $this->load->view('main/footer');
            }
          
        }else{
          $data['data'] = "ต้องทำการเพิ่มรายวิชาก่อน";
          $this->load->view('main/header');
          $this->load->view('table_subject/menu');
          $this->load->view('main/found',$data);
          $this->load->view('main/footer');
        }

      }else{

        redirect('account_controller/view_login','refresh');
      }
    }
    public function view_edit() {
      if($this->session->userdata("sess_username") != null){
        
        $no =  base64_decode($this->input->get('id'));
        $rs = $this->subject_table_model->select_where(array('No' => $no ));
        if( count($rs) > 0){
          $data['user'] = $this->account_model->list_account();
          $data['result'] = $this->subject_table_model->select_where_join(array('subject_timetable.No' => $no));
          $this->load->view('main/header');
          $this->load->view('table_subject/menu');
          $this->load->view('table_subject/edit',$data);
          $this->load->view('main/footer');
        }else{
          $this->load->view('main/header');
          $this->load->view('table_subject/menu');
          $this->load->view('main/found');
          $this->load->view('main/footer');
        }
      }else{

        redirect('account_controller/view_login','refresh');
      }
    }

    public function view_show(){
      if($this->session->userdata("sess_username") != null){

        $result = $this->subject_model->list_subject("all");
        $account = $this->account_model->list_account();

        if(count($result) > 0){
          if(count($account) > 0){
            if($this->input->post('st') == "back"){
               $data['b_user'] = $this->input->post('fback-user');
               $data['b_no_account'] = $this->input->post('fback-no_account');
               $data['b_year'] = $this->input->post('fback-year');
               $data['b_term'] = $this->input->post('fback-term');
            }
            $data['status'] = $this->input->post('st');
            $data['user'] = $this->account_model->list_account();
            $this->load->view('main/header');
            if( $this->session->userdata("sess_type") == "ผู้ดูแลระบบ" ){
              $this->load->view('table_subject/menu');
            }
            $this->load->view('table_subject/show',$data);
            $this->load->view('main/footer');
          }else{
            $data['data'] = "ต้องทำการเพิ่มบัญชีผู้ใช้งานก่อน";
            $this->load->view('main/header');
            $this->load->view('table_subject/menu');
            $this->load->view('main/found',$data);
            $this->load->view('main/footer');
          }
        }else{
          $data['data'] = "ต้องทำการเพิ่มรายวิชาก่อน";
          $this->load->view('main/header');
          $this->load->view('table_subject/menu');
          $this->load->view('main/found',$data);
          $this->load->view('main/footer');
        }
      }else{

        redirect('account_controller/view_login','refresh');
      }
    }
}
