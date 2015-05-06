<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class config_controller extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('config_model');
    }

    public function add_setdate(){
      $year = $this->input->post('year');
      $term = $this->input->post('term');
      $sdate = $this->input->post('sdate');
      $edate = $this->input->post('edate');

      $result = $this->config_model->list_date(array('Year' => $year,'Term' => $term));
      if(count($result->result()) > 0){
        echo "ปีการศึกษา ".$term."/".$year." มีอยู่แล้ว กรุณาป้อนปีการศึกษาอื่น";
      }else{
        $this->config_model->insert_setdate(array('Year' => $year,'Term' => $term,'sDate' => $sdate,'eDate' => $edate ));
        echo "บันทึกข้อมูลเรียบร้อย";
      }
    }

    public function edit_setdate(){
      $no = $this->input->post('no');
      $year = $this->input->post('year');
      $term = $this->input->post('term');
      $sdate = $this->input->post('sdate');
      $edate = $this->input->post('edate');
      $b_year = $this->input->post('b_year');
      $b_term = $this->input->post('b_term');

      if( $year == $b_year && $term == $b_term){
        $this->config_model->update_setdate(array('No' => $no ),array('sDate' => $sdate,'eDate' => $edate ));
        echo "บันทึกข้อมูลเรียบร้อย";
      }else{
        $result = $this->config_model->list_date(array('Year' => $year,'Term' => $term));
        if(count($result->result()) > 0){
          echo "ปีการศึกษา ".$term."/".$year." มีอยู่แล้ว กรุณาป้อนปีการศึกษาอื่น";
        }else{
          $this->config_model->update_setdate(array('No' => $no),array('Year' => $year,'Term' => $term,'sDate' => $sdate,'eDate' => $edate ));
          echo "บันทึกข้อมูลเรียบร้อย";
        }
      }
    }

    public function edit_wait(){
      $this->config_model->update("Status = 'ready'",array('Status' => "wait"));
    }

    public function edit_ready(){
      $this->config_model->update("Status = 'wait' or Status = 'ready'",array('Status' => "ready",'Data' => ""));
    }
    
    public function edit_town(){
      $town = $this->input->post('town');
      $this->config_model->update("Status = 'ready' or Status = 'wait'",array('Town' => $town));
      $this->session->set_userdata(array('sess_town' => $town));
      echo "บันทึกข้อมูลเรียบร้อย";
    }

    public function delete($no){
      $this->config_model->delete_setdate($no);
    }

    public function list_config(){
      $result = $this->config_model->list_config();
      $row = $result->row();

      if($row->Data != ""){
        echo $row->Data;
      }else{
        echo "error";
      }
    }

    /*                                            view                                                  */
    public function view_add(){
      if($this->session->userdata("sess_username") != null){

        $this->load->view('main/header');
        $this->load->view('config/menu');
        $this->load->view('config/add');
        $this->load->view('main/footer');
      }else{

        redirect('account_controller/view_login','refresh');
      }
    }

    public function view_show(){
      if($this->session->userdata("sess_username") != null){

        $data['result'] = $this->config_model->list_date(array('No >' => 0 ));
        $this->load->view('main/header');
        $this->load->view('config/menu');
        $this->load->view('config/show',$data);
        $this->load->view('main/footer');
      }else{

        redirect('account_controller/view_login','refresh');
      }
    }

    public function view_edittown(){
      if($this->session->userdata("sess_username") != null){

        $data['result'] = $this->config_model->list_config();
        $this->load->view('main/header');
        $this->load->view('config/menu');
        $this->load->view('config/edit_town',$data);
        $this->load->view('main/footer');
      }else{

        redirect('account_controller/view_login','refresh');
      }
    }

    public function view_editdate(){
      if($this->session->userdata("sess_username") != null){

        $no =  base64_decode($this->input->get('id'));
        $data['result'] = $this->config_model->list_date(array('No' => $no));
        $this->load->view('main/header');
        $this->load->view('config/menu');
        $this->load->view('config/edit_date',$data);
        $this->load->view('main/footer');
      }else{

        redirect('account_controller/view_login','refresh');
      }
    }
}
