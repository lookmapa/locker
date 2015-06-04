<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class account_controller extends CI_Controller {

    public function __construct(){
      parent::__construct();
      $this->load->model('account_model');
      $this->load->model('numberlocker_model');
      $this->load->model('historynumber_model');
      $this->load->model('config_model');
    }

    public function index(){
       redirect('account_controller/view_login','refresh');
    }

    public function add(){
      $rfid = $this->input->post('rfid');
      $name = $this->input->post('name');
      $sname = $this->input->post('sname');
      $username = $this->input->post('username');
      $password = $this->input->post('password');
      $privileges = $this->input->post('privileges');
      $license = $this->input->post('license');
      $level = $this->input->post('level');

      if( strlen($password) % 2 == 0 ){
        $password .= "pass";
      }else{
        $password .= "fail";
      }
      $password = base64_encode($password);
      
      $result = $this->account_model->check_insert($rfid,$name,$sname,$username);

      if(count($result) == 0){
        $arrayData  = array(
                            'No' => '',  
                            'RfidTag' => $rfid,
                            'Name' => $name,
                            'SName' => $sname,
                            'UserName' => $username,
                            'PassWord' => $password,
                            'Privileges' => $privileges,
                            'Level' => $level
                            );
        $this->account_model->insert($arrayData);
        $result = $this->account_model->getuser_number();
        $row = $result->row();

        for($i = 0; $i <= 11; $i++){
            if( substr($license, $i,1) == 1){
              $this->historynumber_model->insert(array('No_account' => $row->No,'No_number' => ($i+1),'Number' => ($i+1)));
            }
          }
        echo "pass";
      }else{
        $result = $this->account_model->select_where(array('RfidTag' => $rfid));
        if( $result->num_rows() == 1 ){
          echo "1";
        }
        $result = $this->account_model->select_where(array('Name' => $name,'SName' => $sname));
        if( $result->num_rows() == 1 ){
          echo "2";
        }
        $result = $this->account_model->select_where(array('UserName' => $username));
        if( $result->num_rows() == 1 ){
          echo "3";
        }
      } 
    }

    public function edit(){
      $no = $this->input->post('no');
      $rfid = $this->input->post('rfid');
      $name = $this->input->post('name');
      $sname = $this->input->post('sname');
      $username = $this->input->post('username');
      $password = $this->input->post('password');
      $privileges = $this->input->post('privileges');
      $level = $this->input->post('level');
      $license = $this->input->post('license');
      $before_rfid = $this->input->post('before_rfid');
      $before_name = $this->input->post('before_name');
      $before_sname = $this->input->post('before_sname');
      $before_username = $this->input->post('before_username');

      if( strlen($password) % 2 == 0 ){
        $password .= "pass";
      }else{
        $password .= "fail";
      }
      $password = base64_encode($password);

      $result = $this->account_model->select_where(array('RfidTag' => $rfid));

      if($result->num_rows() == 0){

        $arrayData  = array( 
                            'RfidTag' => $rfid,
                            'Name' => $name,
                            'SName' => $sname,
                            'UserName' => $username,
                            'PassWord' => $password,
                            'Privileges' => $privileges,
                            'Level' => $level
                            );         
        if( $before_username == $username && $before_name == $name && $before_sname == $sname ){            
            
            $this->historynumber_model->delete($no);
            $this->account_model->update($no,$arrayData);
            for($i = 0; $i <= 11; $i++){
              if( substr($license, $i,1) == 1){
                $this->historynumber_model->insert(array('No_account' => $no,'No_number' => ($i+1)));
              }
            }
            echo "pass";
       
        }else if( $before_username == $username ){

          $result = $this->account_model->select_where(array('Name' => $name,'SName' => $sname));
          if($result->num_rows() == 0){
            $this->historynumber_model->delete($no);
            $this->account_model->update($no,$arrayData);
            for($i = 0; $i <= 11; $i++){
              if( substr($license, $i,1) == 1){
                $this->historynumber_model->insert(array('No_account' => $no,'No_number' => ($i+1)));
              }
            }
            echo "pass";
          }else{
            echo "1";
          }

        }else if( $before_name == $name && $before_sname == $sname ){          

          $result = $this->account_model->select_where(array('UserName' => $username));
          if($result->num_rows() == 0){
            $this->historynumber_model->delete($no);
            $this->account_model->update($no,$arrayData);
            for($i = 0; $i <= 11; $i++){
              if( substr($license, $i,1) == 1){
                $this->historynumber_model->insert(array('No_account' => $no,'No_number' => ($i+1)));
              }
            }
            echo "pass";
          }else{
            echo "2";
          }
        }

      }else{
          
          $arrayData  = array( 
                            'Name' => $name,
                            'SName' => $sname,
                            'UserName' => $username,
                            'PassWord' => $password,
                            'Privileges' => $privileges,
                            'Level' => $level
                            );          
          if( $before_rfid == $rfid && $before_username == $username && $before_name == $name && $before_sname == $sname ){
            
            $this->historynumber_model->delete($no);
            $this->account_model->update($no,$arrayData);
            for($i = 0; $i <= 11; $i++){
              if( substr($license, $i,1) == 1){
                $this->historynumber_model->insert(array('No_account' => $no,'No_number' => ($i+1)));
              }
            }
            echo "pass";

          }else if( $before_rfid == $rfid && $before_username == $username ){
                      
            $result = $this->account_model->select_where(array('Name' => $name,'SName' => $sname));
            if( $result->num_rows() == 0 ){ 
              $this->historynumber_model->delete($no);             
              $this->account_model->update($no,$arrayData);
              for($i = 0; $i <= 11; $i++){
                if( substr($license, $i,1) == 1){
                  $this->historynumber_model->insert(array('No_account' => $no,'No_number' => ($i+1)));
                }
              }
              echo "pass";
            }else{
              echo "1";
            }

          }else if( $before_rfid == $rfid && $before_name == $name && $before_sname == $sname ){
                     
            $result = $this->account_model->select_where(array('UserName' => $username));
            if( $result->num_rows() == 0 ){    
              $this->historynumber_model->delete($no);           
              $this->account_model->update($no,$arrayData);
              for($i = 0; $i <= 11; $i++){
                if( substr($license, $i,1) == 1){
                  $this->historynumber_model->insert(array('No_account' => $no,'No_number' => ($i+1)));
                }
              }
              echo "pass";
            }else{
              echo "2";
            }

          }else if( $before_rfid == $rfid ){
            
            $result = $this->account_model->select_where(array('Name' => $name,'SName' => $sname));
            if( $result->num_rows() == 0 ){
              $result = $this->account_model->select_where(array('UserName' => $username));   
              if( $result->num_rows() == 0 ){
                $this->historynumber_model->delete($no);           
                $this->account_model->update($no,$arrayData);
                for($i = 0; $i <= 11; $i++){
                  if( substr($license, $i,1) == 1){
                    $this->historynumber_model->insert(array('No_account' => $no,'No_number' => ($i+1)));
                  }
                }
                echo "pass";  
              }else{
                echo "2";
              }
            }          
          }
      }
    }
    
    public function detail($no){
      $arrayData = array('No' => $no);
      $result = $this->account_model->select_where($arrayData);
      $room = $this->numberlocker_model->list_number();
      $number = $this->historynumber_model->list_number($no);
      $row = $result->row();
      $arr_number = array("0-","0-","0-","0-","0-","0-","0-","0-","0-","0-","0-","0-");

      echo $row->RfidTag."/";
      echo $row->Name."/";
      echo $row->SName."/";
      echo $row->UserName."/";
      echo substr(base64_decode($row->PassWord),0,(strlen(base64_decode($row->PassWord))-4))."/";
      echo $row->Privileges."/";
      echo $row->Level."/";
      foreach ($room as $row):
        echo $row->Number_Room."-"; 
      endforeach;
      echo "/";
      foreach ($number as $row):
        for($i = 1; $i <= 12; $i++){
            if( $row->No_number == $i){
                $arr_number[$i-1] = "1-";
            }
        }
      endforeach;
      for($i = 0; $i < 12; $i++){
         echo $arr_number[$i];
      }
      echo "/";
    }

    public function delete($no){
      $this->account_model->delete($no);
    }

    public function login(){
      $username = $this->input->post('txt-username');
      $password = $this->input->post('txt-password');
      $count_user = 0;
      $count_pass = 0;

      if( strlen($password) % 2 == 0 ){
        $password .= "pass";
      }else{
        $password .= "fail";
      }
      $password = base64_encode($password);

      $result = $this->account_model->select_where(array('UserName' => $username,'PassWord' => $password ));
        if( $result->num_rows() > 0 ){
          $row = $result->row();
          $result1 = $this->config_model->list_config();
          $row1 = $result1->row();
          $arr_session = array(
                                'sess_id' => $row->No,
                                'sess_username' => $row->UserName,
                                'sess_name' => $row->Name,
                                'sess_sname' => $row->SName,
                                'sess_type' =>$row->Privileges,
                                'sess_town' => $row1->Town
                              );
          $this->session->set_userdata($arr_session);
          redirect('history_controller/view_add','refresh');
        }else{
          $result = $this->account_model->list_account();
          foreach ($result as $row ) {
            if( $row->UserName == $username ){
              $count_user = 1;
            }
            if( $row->PassWord == $password ){
              $count_pass = 1;
            }
          }

          if( $count_user == 1 && $count_pass == 0 ){
            $arr_data = array('st_username' => "",'st_password' => "กรุณากรอก password ให้ถูกต้อง",'t_username' => $username,'t_password' => $password );
            $this->load->view('account/login',$arr_data);
          }else if( $count_user == 0 && $count_pass == 1 ){
            $arr_data = array('st_username' => "username ไม่มีในระบบ",'st_password' => "",'t_username' => $username,'t_password' => $password );
            $this->load->view('account/login',$arr_data);
          }else{
            $arr_data = array('st_username' => "username ไม่มีในระบบ",'st_password' => "password ไม่มีในระบบ",'t_username' => $username,'t_password' => $password );
            $this->load->view('account/login',$arr_data);
          }
        }  
    }

    public function logout(){
      $this->session->sess_destroy();
      redirect('account_controller/view_login','refresh');
    }

    public function list_account(){
      $result = $this->account_model->list_account();
      foreach ($result as $row ) {
        echo $row->No."/".$row->Name." ".$row->SName.",";
      }
    }

    /*                         view                                     */
    
    public function view_show(){
      if($this->session->userdata("sess_username") != null){

        $data['result'] = $this->account_model->list_account();
        $this->load->view('main/header');
        $this->load->view('account/show',$data);
        $this->load->view('main/footer');
      }else{

        redirect('account_controller/view_login','refresh');
      }  
    }

    public function view_add(){
      if($this->session->userdata("sess_username") != null){

        $arrayData = array('Status' => "ready",'Data' => "");
        $this->config_model->update("Status = 'wait'",$arrayData);
        $data['number'] = $this->numberlocker_model->list_number();
        $this->load->view('main/header');
        $this->load->view('account/add',$data);
        $this->load->view('main/footer');
      }else{

        redirect('account_controller/view_login','refresh');
      }
    }

    public function view_edit(){
      if($this->session->userdata("sess_username") != null){

        $no =  base64_decode($this->input->get('id'));
        $result = $this->account_model->select_where(array('No' => $no ));
        if( count($result->result()) > 0){
          $arrayData = array('Status' => "ready",'Data' => "");
          $this->config_model->update("Status = 'wait'",$arrayData);

          $row = $result->row();
          
          $data['no'] = $row->No;
          $data['rfid'] = $row->RfidTag;
          $data['name'] = $row->Name;
          $data['sname'] = $row->SName;
          $data['username'] = $row->UserName;
          $data['password'] = $row->PassWord;
          $data['privileges'] = $row->Privileges;
          $data['level'] = $row->Level;
          $data['number'] = $this->numberlocker_model->list_number();
          $data['result'] = $this->historynumber_model->list_number($no);
          $this->load->view('main/header');
          $this->load->view('account/edit',$data);
          $this->load->view('main/footer');
        }else{
          $this->load->view('main/header');
          $this->load->view('main/found');
          $this->load->view('main/footer');
        }
      }else{

        redirect('account_controller/view_login','refresh');
      }
    }

    public function view_login(){
      if($this->session->userdata("sess_username") == null){

        $arr_data = array('t_username' => "",'t_password' => "",'st_username' => "",'st_password' => "" );  
        $this->load->view('account/login',$arr_data);
      }else{

        redirect('subject_table_controller/view_add','refresh');
      }
    }

    public function view_error(){
      if($this->session->userdata("sess_username") != null){

        $this->load->view('main/page_not_found');
      }else{

        redirect('account_controller/view_login','refresh');
      }
    }

}
