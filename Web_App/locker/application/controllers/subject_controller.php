<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subject_controller extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('subject_model');
    }

    public function index() {
        redirect('subject_table/add','refresh');
    }

    public function add(){
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $hours = $this->input->post('hours');
        $level = $this->input->post('level');

        $result = $this->subject_model->select_where_or(array('Id' => $id,'Name' => $name));
        
        if ($result->num_rows() == 0) {
            $arrayData = array(
                          'No' => '',
                          'Id' => $id,
                          'Name' => $name,
                          'Hours' => $hours,
                          'Level' => $level
                          );
            $this->subject_model->insert($arrayData);
            echo "บันทึกข้อมูลเรียบร้อย";
        }else{
            echo "error";
        } 

    }

    public function delete() {
        $no = $this->input->post('no');
        $this->subject_model->delete($no);
        redirect('subject_controller/view_showAll','refresh');
    }

    public function edit(){
        $id_before = $this->input->post('id_before');
        $name_before = $this->input->post('name_before');
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $hours = $this->input->post('hours');
        $level = $this->input->post('level');

        if( $id_before == $id && $name_before == $name ){
            $this->subject_model->update($id_before,array( 'Hours' => $hours,'Level' => $level));
        }else if( $id_before == $id || $name_before == $name ){            
            $arrayData = array(
                          'Id' => $id,
                          'Name' => $name,
                          'Hours' => $hours,
                          'Level' => $level
                          );
            $result_Id = $this->subject_model->select_where(array('Id' => $id));
            $result_Name = $this->subject_model->select_where(array('Name' => $name));

            if( $id_before == $id && $result_Name->num_rows() == 0 ){
                $this->subject_model->update($id_before,$arrayData);
                echo "pass";
            }else if( $name_before == $name && $result_Id->num_rows() == 0 ){
                $this->subject_model->update($id_before,$arrayData);
                echo "pass";
            }else{
                echo "คุณกรอกข้อมูลไม่ถูกต้องหรือมีในระบบอยู่แล้ว";
            }
        }else{
            $result = $this->subject_model->select_where_or(array('Id' => $id,'Name' => $name));

            if ($result->num_rows() == 0) {
                $arrayData = array(
                          'Id' => $id,
                          'Name' => $name,
                          'Hours' => $hours,
                          'Level' => $level
                          );
                $this->subject_model->update($id_before,$arrayData);
                echo "pass";
            }else{
                echo "คุณกรอกข้อมูลไม่ถูกต้องหรือมีในระบบอยู่แล้ว";
            }
        }
    }

    public function list_subject(){
        $result = $this->subject_model->list_subject("all"); 
        if(count($result)>0){
          foreach ($result as $row):
            echo $row->No.".".$row->Id."/".$row->Name.".".$row->Hours.",";
         endforeach;
        }else{
            echo "error";
        }
               
    }

    public function list_table($status) {
         
        if($status == "all"){
            $data['result'] = $this->subject_model->list_subject($status);
        }else{
            $data['result'] = $this->subject_model->list_subject($status);
        }
        $this->load->view('subject/list_table',$data);
    }


    /*                         view                                     */
    
    public function view_add() {
      if($this->session->userdata("sess_username") != null){

        $this->load->view('main/header');
        $this->load->view('subject/menu');
        $this->load->view('subject/add');
        $this->load->view('main/footer');
       }else{

        redirect('account_controller/view_login','refresh');
      }
    }

    public function view_edit() {
      if($this->session->userdata("sess_username") != null){
        
        $no =  base64_decode($this->input->get('id'));
        $detail = $this->input->get('detail');
        $result = $this->subject_model->select_where(array('No' => $no ));
        if( count($result->result()) > 0){
            $row = $result->row();
            $data['Id'] = $row->Id;
            $data['Name'] = $row->Name;
            $data['Hours'] = $row->Hours;
            $data['Level'] = $row->Level;
            $data['detail'] = $detail;

            $this->load->view('main/header');
            $this->load->view('subject/menu');
            $this->load->view('subject/edit',$data);
            $this->load->view('main/footer');
        }else{
            $this->load->view('main/header');
            $this->load->view('subject/menu');
            $this->load->view('main/found');
            $this->load->view('main/footer');
        }
      }else{

        redirect('account_controller/view_login','refresh');
      }
    }

    public function view_show(){
      if($this->session->userdata("sess_username") != null){

        if($this->input->post('st') == "front"){
            $data['status'] = "front";
        }else if($this->input->post('st') == "back"){
            $data['status'] = "back";
            $data['detail'] = $this->input->post('detail');
        }else{
            $data['status'] = "front";
        }
        $this->load->view('main/header');
        $this->load->view('subject/menu');
        $this->load->view('subject/show',$data);
        $this->load->view('main/footer');
      }else{

        redirect('account_controller/view_login','refresh');
      }  
    }

    public function view_showAll(){
      if($this->session->userdata("sess_username") != null){
        $data['status'] = "back";
        $data['detail'] = "total";
        $this->load->view('main/header');
        $this->load->view('subject/menu');
        $this->load->view('subject/show',$data);
        $this->load->view('main/footer');
      }else{

        redirect('account_controller/view_login','refresh');
      }  
    }

}
