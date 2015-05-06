<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class numberlocker_controller extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('numberlocker_model');
    }

    public function edit(){
      $str = $this->input->post('data');
      $keywords = explode('/', $str);

      for($i = 0; $i < (count($keywords)-1); $i++){
        $this->numberlocker_model->update(($i+1),array('Number_Room' => $keywords[$i] ));
      }

      echo "บันทึกข้อมูลเรีบยร้อย";
    }

    /*                         view                                     */
    
    public function view_editnumber(){
      if($this->session->userdata("sess_username") != null){

        $data['result'] = $this->numberlocker_model->list_number();
        $this->load->view('main/header');
        $this->load->view('numberlocker/menu');
        $this->load->view('numberlocker/edit_number_room',$data);
        $this->load->view('main/footer');
      }else{

        redirect('account_controller/view_login','refresh');
      }
    }

}
