<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class History_controller extends CI_Controller {

    public function __construct(){
        parent::__construct(); 
        $this->load->model('account_model');
        $this->load->model('history_model');
        $this->load->model('overtime_room_model');
        $this->load->model('subject_table_model');
        $this->load->model('config_model');
    }

    public function getcountday($sDate,$eDate,$Day,$sDateExam){
        
        $sdate = $sDate;
        $edate = $eDate;
        $count = 0;
        $day = $Day;
       
       while($sdate <= $edate){

            if($day == date("l",strtotime($sdate)) && $sdate < $sDateExam ){
                $count += 1;   
            }
            $sdate = date("Y-m-d",strtotime("+1 day".$sdate));
        }

        return $count;
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
    
    public function list_year(){
        $st = $this->input->get('st');
        if( $st == "history"){
            $count = $this->history_model->get_count("max(`Year`) as max,min(`Year`) as min","Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' ");
        }else{
            $count = $this->subject_table_model->get_count("max(`Year`) as max,min(`Year`) as min",array('No_account >' => 0));
        }
        $row = $count->row();
        echo $row->max."/".$row->min;
    }

    public function edit(){
        $user = $this->input->post('user');
        $no = $this->input->post('no');
        $status = $this->input->post('status');
        $detail = $this->input->post('detail');
        $arr_no = explode('/', $no);
        $arr_st = explode('/', $status);
        $arr_detail = explode('/', $detail);
        $st = "";
        for($i = 0; $i < sizeof($arr_no)-1; $i++){
            if( $arr_st[$i] == "own" ){
                if( $arr_detail[$i] != ""){
                    $this->history_model->update($arr_no[$i],array('Status' => $arr_detail[$i]));
                    $st .= "1-";
                }else{
                    $st .= "0-";
                }
            }else{
                $result = $this->history_model->list_history(array('history.No' => $no ),"all");
                foreach ($result as $row) {
                    $date = new DateTime($row->Begin);
                    $day =  $this->getday($date->format("Y-m-d"));
                    $year = $row->Year;
                    $term = $row->Term;
                    $time = $date->format("H:i:s");
                    $room = $row->Number_Room;
                    $clock = explode(":",$time);
                }
                $result = $this->subject_table_model->select_where("`Year` = ".$year." and `Term` = ".$term." and `Room` = ".$room." and `Day` = '".$day."' and `Time_Begin` >= '".floatval($clock[0].".".$clock[1])."' and `Time_End` > '".floatval($clock[0].".".$clock[1])."' order by `Time_Begin`asc limit 0,1");
                if(count($result) > 0){
                    foreach ($result as $row ) {
                        if( $row->No_account == $arr_detail[$i]){
                            $this->history_model->update($arr_no[$i],array('Status' => "เข้าสอนตรงเวลา",'No_account' => $arr_detail[$i],'No_timetable' => $row->No,'Replace' => $user));
                            $st .= "1-";
                        }else{
                            $st .= "0-";
                        }
                    }
                }else{
                    $st .= "0-";
                }
            }
        }
        echo $st;
    }

    public function list_addhistory(){
        $user = $this->input->get('user');
        $data['result'] = $this->history_model->list_history(array('No_account' => $user,'Status' => "empty" ),"all");
        $this->load->view('history/list_tableadd',$data);
    }

    public function list_report(){   // รายงาการสอน
        $user = $this->input->post('user');
        $year = $this->input->post('year');
        $term = $this->input->post('term');
        $str = "";

        if($year == "all" && $term == "all"){
            $rs_y = $this->subject_table_model->select_where("No > 0 GROUP BY Year ORDER BY Year DESC");
            foreach ($rs_y as $row) {
                $rs_t = $this->subject_table_model->select_where("Year = ".$row->Year." GROUP BY Term ORDER BY Term DESC");
                foreach ($rs_t as $row2) {
                    $rs_s = $this->config_model->list_date(array('Year' => $row->Year,'Term' => $row2->Term ));
                    if(count($rs_s->result()) == 0){
                        $str .= "ปีการศึกษา ".$row->Year." เทอม ".$row2->Term."\n";
                    }
                }
            }
        }else if($year != "all" && $term == "all"){
            $rs_t = $this->subject_table_model->select_where("Year = ".$year." GROUP BY Term ORDER BY Term DESC");
            foreach ($rs_t as $row2) {
                $rs_s = $this->config_model->list_date(array('Year' => $year,'Term' => $row2->Term ));
                if(count($rs_s->result()) == 0){
                    $str .= "ปีการศึกษา ".$year." เทอม ".$row2->Term."\n";
                }
            }
        }else if($year == "all" && $term != "all" ){
            $rs_y = $this->subject_table_model->select_where("No > 0 GROUP BY Year ORDER BY Year DESC");
            foreach ($rs_y as $row) {
                $rs_s = $this->config_model->list_date(array('Year' => $row->Year,'Term' => $term ));
                if(count($rs_s->result()) == 0){
                    $str .= "ปีการศึกษา ".$row->Year." เทอม ".$term."\n";
                }
            }
        }else if( $year != "all" && $term != "all"  ){
            $rs_s = $this->config_model->list_date(array('Year' => $year,'Term' => $term ));
            if(count($rs_s->result()) == 0){
                $str .= "ปีการศึกษา ".$year." เทอม ".$term."\n";
            }
        }

        if( $str == "" ){
            if( $user == "all" && $year != "all" && $term != "all"){ 
                $tablesubject = $this->subject_table_model->list_tablesubject(array('No_account >' => 0),array('Year' => $year),array('Term' => $term)); 
            }else if( $user == "all" && $year == "all" && $term != "all" ){
                $tablesubject = $this->subject_table_model->list_tablesubject(array('No_account >' => 0),array('Year >' => 0),array('Term ' => $term)); 
            }else if( $user == "all" && $year == "all" && $term == "all" ){
                $tablesubject = $this->subject_table_model->list_tablesubject(array('No_account >' => 0),array('Year >' => 0),array('Term >' => 0)); 
            }else if( $user != "all" && $year == "all" && $term == "all" ){
                $tablesubject = $this->subject_table_model->list_tablesubject(array('No_account ' => $user),array('Year >' => 0),array('Term >' => 0)); 
            }else if( $user != "all" && $year == "all" && $term != "all" ){
                $tablesubject = $this->subject_table_model->list_tablesubject(array('No_account ' => $user),array('Year >' => 0),array('Term ' => $term)); 
            }else if( $user == "all" && $year != "all" && $term == "all" ){
                $tablesubject = $this->subject_table_model->list_tablesubject(array('No_account >' => 0),array('Year ' => $year),array('Term >' => 0)); 
            }else if( $user != "all" && $year != "all" && $term == "all" ){
                $tablesubject = $this->subject_table_model->list_tablesubject(array('No_account ' => $user),array('Year ' => $year),array('Term >' => 0)); 
            }else if( $user != "all" && $year != "all" && $term != "all" ){
                $tablesubject = $this->subject_table_model->list_tablesubject(array('No_account ' => $user),array('Year ' => $year),array('Term ' => $term)); 
            }   

            if(count($tablesubject) > 0){
                $history = $this->history_model->list_history("(Status = 'เข้าสอนตรงเวลา' or Status = 'เข้าสอนสาย')","all");
                $count = 1;
                foreach ($tablesubject as $row) {
                    if( $row->Day == "จันทร์"){
                        $day = "Monday";
                    }else if( $row->Day == "อังคาร" ){
                        $day = "Tuesday";
                    }else if( $row->Day == "พุธ" ){
                        $day = "Wednesday";
                    }else if( $row->Day == "พฤหัสบดี" ){
                        $day = "Thursday";
                    }else if( $row->Day == "ศุกร์" ){
                        $day = "Friday";
                    }

                    $date = $this->config_model->list_date(array('Year' => $row->Year,'Term' => $row->Term ));
                    $d = $date->row();
                    $sdate = $d->sDate;
                    $edate = $d->eDate;
                    $num = 1;

                    while($sdate <= $edate){
                        $status = "ขาดสอน";
                       
                        if($day == date("l",strtotime($edate)) ){
                            $num = 7;
                            foreach ($history as $his) {
                                $bDate = new DateTime($his->Begin);
                                if( $bDate->format("Y-m-d") == $edate && $his->No_account == $row->No_account && $his->No_timetable == $row->st_no){
                                    $status = $his->Status;
                                    break;
                                }else{
                                    if($row->s_level == 1){
                                        $status = "เข้าสอนตรงเวลา";
                                    }else{
                                        if( $edate >= $d->sDateExam ){
                                            $status = "สอบ";
                                        }else{
                                            $status = "ขาดสอน";
                                        }
                                    }
                                }
                            }
                            $data['user'][$count] = $row->a_name." ".$row->SName;
                            $data['year'][$count] = $row->Term."/".$row->Year;
                            $data['subject'][$count] = $row->s_name."(".$row->Group.")";
                            $data['date'][$count] = $edate;
                            $data['status'][$count] = $status;
                            $count += 1;
                        }
                        $edate = date("Y-m-d",strtotime("-".$num."day".$edate));
                    }
                }
                $data['max'] = $count;
            }else{
                $data['max'] = 0;
            } 
            echo "pass!";
            $this->load->view('history/list_tablereport',$data);
        }else{
            echo "error!".$str;
        }
    }

    public function list_overtime(){  // รายงานการใช้ห้องนอกเวลา
        $user = $this->input->post('user');
        $year = $this->input->post('year');
        $term = $this->input->post('term');

        if( $user == "all" && $year != "all" && $term != "all"){ 
            $result1 = $this->history_model->list_history("Year = '".$year."' and Term = '".$term."' and Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' and Status != 'แจ้ง' ","all");
            $result2 = $this->history_model->list_history(array('Year' => $year,'Term' => $term ,'Status' => 'แจ้ง' ),"join");
        }else if( $user == "all" && $year == "all" && $term != "all" ){
            $result1 = $this->history_model->list_history("Term = '".$term."' and  Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' and Status != 'แจ้ง'","all");
            $result2 = $this->history_model->list_history(array('Term' => $term ,'Status' => 'แจ้ง' ),"join");    
        }else if( $user == "all" && $year == "all" && $term == "all" ){
            $result1 = $this->history_model->list_history("Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' and Status != 'แจ้ง' ","all");
            $result2 = $this->history_model->list_history(array('Status' => 'แจ้ง' ),"join"); 
        }else if( $user != "all" && $year == "all" && $term == "all" ){
            $result1 = $this->history_model->list_history("history.No_account = '".$user."' and Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' and Status != 'แจ้ง' ","all");
            $result2 = $this->history_model->list_history(array('history.No_account ' => $user,'Status' => 'แจ้ง' ),"join");
        }else if( $user != "all" && $year == "all" && $term != "all" ){
            $result1 = $this->history_model->list_history("history.No_account = '".$user."' and Term = '".$term."' and Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' and Status != 'แจ้ง' ","all");
            $result2 = $this->history_model->list_history(array('history.No_account ' => $user,'Term' => $term,'Status' => 'แจ้ง' ),"join");
        }else if( $user == "all" && $year != "all" && $term == "all" ){
            $result1 = $this->history_model->list_history("Year = '".$year."' and  Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' and Status != 'แจ้ง'","all");
            $result2 = $this->history_model->list_history(array('Year' => $year,'Status' => 'แจ้ง' ),"join");
        }else if( $user != "all" && $year != "all" && $term == "all" ){
            $result1 = $this->history_model->list_history("history.No_account = '".$user."' and Year = '".$year."' and Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' and Status != 'แจ้ง' ","all");
            $result2 = $this->history_model->list_history(array('history.No_account ' => $user,'Year' => $year,'Status' => 'แจ้ง' ),"join");     
        }else if( $user != "all" && $year != "all" && $term != "all" ){
            $result1 = $this->history_model->list_history("history.No_account = '".$user."' and Year = '".$year."' and Term = '".$term."' and Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' and Status != 'แจ้ง' ","all");
            $result2 = $this->history_model->list_history(array('history.No_account ' => $user,'Year ' => $year,'Term ' => $term ,'Status' => 'แจ้ง' ),"join");           
        }

        $c_user = 1;
        if(count($result1) > 0){
            foreach ($result1 as $rs1 ) {
                $bDate = new DateTime($rs1->Begin);
                $eDate = new DateTime($rs1->End);

                $data['name'][$c_user] = $rs1->Name." ".$rs1->SName;
                $data['year'][$c_user] = $rs1->Term."/".$rs1->Year;
                $data['date'][$c_user] = $bDate->format("Y-m-d");
                $data['begin'][$c_user] = $bDate->format("H:i:s");
                $data['end'][$c_user] = $eDate->format("H:i:s");
                $data['room'][$c_user] = $rs1->Number_Room;
                if( $rs1->Status == "empty" ){
                    $data['detail'][$c_user] = "ยังไม่ได้กรอกเหตุผลการใช้ห้องนอกเวลา";
                }else{
                    $data['detail'][$c_user] = $rs1->Status;
                }

                $c_user += 1;
            }
        }    
        if(count($result2) > 0){
            foreach ($result2 as $rs2) {
                $bDate = new DateTime($rs2->Begin);
                $eDate = new DateTime($rs2->End);

                $data['name'][$c_user] = $rs2->Name." ".$rs2->SName;
                $data['year'][$c_user] = $rs2->Term."/".$rs2->Year;
                $data['date'][$c_user] = $bDate->format("Y-m-d");
                $data['begin'][$c_user] = $bDate->format("H:i:s");
                $data['end'][$c_user] = $eDate->format("H:i:s");
                $data['room'][$c_user] = $rs2->Room;
                $data['detail'][$c_user] = $rs2->Detail;
                $c_user += 1;
            }
        }

        for ($i=1; $i < $c_user; $i++) { 
            $ck_pointer = $i;
            $ck_date = $i;
            for ($j=$i; $j < $c_user; $j++) { 
                if($i == $j){
                    $ck_date = $data['date'][$j];
                }else{
                    if( $data['date'][$j] >= $ck_date){
                        $ck_pointer = $j;
                        $ck_date = $data['date'][$j];
                    }
                }
            }
            $sname = $data['name'][$i];
            $syear = $data['year'][$i];
            $sdate = $data['date'][$i];
            $sbegin = $data['begin'][$i];
            $send = $data['end'][$i];
            $sroom = $data['room'][$i];
            $sdetail = $data['detail'][$i];

            $data['name'][$i] = $data['name'][$ck_pointer];
            $data['year'][$i] = $data['year'][$ck_pointer];
            $data['date'][$i] = $data['date'][$ck_pointer];
            $data['begin'][$i] = $data['begin'][$ck_pointer];
            $data['end'][$i] = $data['end'][$ck_pointer];
            $data['room'][$i] = $data['room'][$ck_pointer];
            $data['detail'][$i] = $data['detail'][$ck_pointer];

            $data['name'][$ck_pointer] = $sname;
            $data['year'][$ck_pointer] = $syear;
            $data['date'][$ck_pointer] = $sdate;
            $data['begin'][$ck_pointer] = $sbegin;
            $data['end'][$ck_pointer] = $send;
            $data['room'][$ck_pointer] = $sroom;
            $data['detail'][$ck_pointer] = $sdetail;
        }

        $data['max'] = $c_user;
        $this->load->view('history/list_tableovertime',$data);
    }

    public function list_comepeople(){ // รายงานการมาสอนบุคคล
        $user = $this->input->post('user');
        $year = $this->input->post('year');
        $term =$this->input->post('term');

        $str = "";

        if($year == "all" && $term == "all"){
            $rs_y = $this->subject_table_model->select_where("No > 0 GROUP BY Year ORDER BY Year DESC");
            foreach ($rs_y as $row) {
                $rs_t = $this->subject_table_model->select_where("Year = ".$row->Year." GROUP BY Term ORDER BY Term DESC");
                foreach ($rs_t as $row2) {
                    $rs_s = $this->config_model->list_date(array('Year' => $row->Year,'Term' => $row2->Term ));
                    if(count($rs_s->result()) == 0){
                        $str .= "ปีการศึกษา ".$row->Year." เทอม ".$row2->Term."\n";
                    }
                }
            }
        }else if($year != "all" && $term == "all"){
            $rs_t = $this->subject_table_model->select_where("Year = ".$year." GROUP BY Term ORDER BY Term DESC");
            foreach ($rs_t as $row2) {
                $rs_s = $this->config_model->list_date(array('Year' => $year,'Term' => $row2->Term ));
                if(count($rs_s->result()) == 0){
                    $str .= "ปีการศึกษา ".$year." เทอม ".$row2->Term."\n";
                }
            }
        }else if($year == "all" && $term != "all" ){
            $rs_y = $this->subject_table_model->select_where("No > 0 GROUP BY Year ORDER BY Year DESC");
            foreach ($rs_y as $row) {
                $rs_s = $this->config_model->list_date(array('Year' => $row->Year,'Term' => $term ));
                if(count($rs_s->result()) == 0){
                    $str .= "ปีการศึกษา ".$row->Year." เทอม ".$term."\n";
                }
            }
        }else if( $year != "all" && $term != "all"  ){
            $rs_s = $this->config_model->list_date(array('Year' => $year,'Term' => $term ));
            if(count($rs_s->result()) == 0){
                $str .= "ปีการศึกษา ".$year." เทอม ".$term."\n";
            }
        }

        if( $str == ""){
            if( $year == "all" && $term == "all"){
                $count = $this->subject_table_model->get_count("max(`Year`) as max,min(`Year`) as min",array('No_account >' => 0));
                $table_subject = $this->subject_table_model->select_where_join(array('No_account' => $user));
                $arrData1 = array('No_account' => $user,'Status' => "เข้าสอนตรงเวลา");
                $arrData2 = array('No_account' => $user,'Status' => "เข้าสอนสาย");
                $row = $count->row();
                $data['header'] = "ปีการศึกษา ( ".$row->min." - ".$row->max." )"; 
            }else if( $year == "all" && $term != "all" ){
                $count = $this->subject_table_model->get_count("max(`Year`) as max,min(`Year`) as min",array('No_account >' => 0));
                $table_subject = $this->subject_table_model->select_where_join(array('No_account' => $user,'Term' => $term));
                $arrData1 = array('No_account' => $user,'Status' => "เข้าสอนตรงเวลา",'Term' => $term);
                $arrData2 = array('No_account' => $user,'Status' => "เข้าสอนสาย",'Term' => $term);
                $row = $count->row();
                $data['header'] = "ปีการศึกษา ".$term."/( ".$row->min." - ".$row->max." )"; 
            }else if( $year != "all" && $term == "all" ){
                $table_subject = $this->subject_table_model->select_where_join(array('No_account' => $user,'Year' => $year));
                $arrData1 = array('No_account' => $user,'Status' => "เข้าสอนตรงเวลา",'Year' => $year);
                $arrData2 = array('No_account' => $user,'Status' => "เข้าสอนสาย",'Year' => $year);
                $data['header'] = "ปีการศึกษา ".$year; 
            }else if($year != "all" && $term != "all"){
                $table_subject = $this->subject_table_model->select_where_join(array('No_account' => $user,'Year' => $year,'Term' => $term));
                $arrData1 = array('No_account' => $user,'Status' => "เข้าสอนตรงเวลา",'Year' => $year,'Term' => $term);
                $arrData2 = array('No_account' => $user,'Status' => "เข้าสอนสาย",'Year' => $year,'Term' => $term);
                $data['header'] = "ปีการศึกษา ".$term."/".$year; 
            }

            $data['sum'] = 0;
            $users = $this->account_model->select_where(array('No' => $user));
            $history_own = $this->history_model->select_where("select * from history where Status like 'ชดเฉย:%'");
            $u = $users->row();
            if( count($table_subject->result()) > 0){ 
                $c_max = 0;
                $c_level = 0;
                $c_come = 0;
                $data['sum'] += 1;
                foreach ($table_subject->result() as $row) {
                    if( $row->Day == "จันทร์"){
                        $day = "Monday";
                    }else if( $row->Day == "อังคาร" ){
                        $day = "Tuesday";
                    }else if( $row->Day == "พุธ" ){
                        $day = "Wednesday";
                    }else if( $row->Day == "พฤหัสบดี" ){
                        $day = "Thursday";
                    }else if( $row->Day == "ศุกร์" ){
                        $day = "Friday";
                    }

                    $date = $this->config_model->list_date(array('Year' => $row->Year,'Term' => $row->Term ));
                    $d = $date->row();
                    $count = $this->getcountday($d->sDate,$d->eDate,$day,$d->sDateExam);
                    if( $row->s_level == 1){
                        $c_level += $count;
                        $c_max += $count;

                        if( $year == "all" && $term == "all"){
                            $his1 = $this->history_model->get_count("count('status') as count",'No_account ='.$user.' and No_timetable = '.$row->Sjt_No.' and Status = "เข้าสอนตรงเวลา" ');
                            $his2 = $this->history_model->get_count("count('status') as count",'No_account ='.$user.' and No_timetable = '.$row->Sjt_No.' and Status = "เข้าสอนสาย"');
                        }else if( $year == "all" && $term != "all" ){
                            $his1 = $this->history_model->get_count("count('status') as count",'No_account ='.$user.' and Term = '.$term.' and No_timetable = '.$row->Sjt_No.' and  Status = "เข้าสอนตรงเวลา" ');
                            $his2 = $this->history_model->get_count("count('status') as count",'No_account ='.$user.' and Term = '.$term.' and No_timetable = '.$row->Sjt_No.' and Status = "เข้าสอนสาย"');
                        }else if( $year != "all" && $term == "all" ){
                            $his1 = $this->history_model->get_count("count('status') as count",'No_account ='.$user.' and Year = '.$year.' and No_timetable = '.$row->Sjt_No.' and Status = "เข้าสอนตรงเวลา"');
                            $his2 = $this->history_model->get_count("count('status') as count",'No_account ='.$user.' and Year = '.$year.' and No_timetable = '.$row->Sjt_No.' and  Status = "เข้าสอนสาย"');
                        }else if($year != "all" && $term != "all"){
                            $his1 = $this->history_model->get_count("count('status') as count",'No_account ='.$user.' and Year = '.$year.' and Term = '.$term.' and No_timetable = '.$row->Sjt_No.' and  Status = "เข้าสอนตรงเวลา" ');
                            $his2 = $this->history_model->get_count("count('status') as count",'No_account ='.$user.' and Year = '.$year.' and Term = '.$term.' and No_timetable = '.$row->Sjt_No.' and  Status = "เข้าสอนสาย"');
                        }

                        if(count($his1->result()) > 0){
                            $h = $his1->row();
                            $c_come += $h->count;
                        }

                        if(count($his2->result()) > 0){
                            $h = $his2->row();
                            $c_level = $c_level-$h->count;
                        }
                    }else{ 
                        $c_max += $count;
                    }                  
                }
                $data['max'] = $c_max;
                $data['user'] = $u->Name." ".$u->SName;
                $count = $this->history_model->get_count("count('status') as count",$arrData1);
                $c = $count->row();
                $history_own = $this->history_model->select_where("select * from history where Status like 'ชดเฉย:%'");
                $data['c_come'] = ($c->count - $c_come)+$c_level; 
                $data['percent_come'] = ($data['c_come']*100)/$c_max;
                $count = $this->history_model->get_count("count('status') as count",$arrData2);
                $c = $count->row();
                $data['c_late'] = $c->count ;
                $data['percent_late'] = ($data['c_late']*100)/$c_max;
                $data['c_absent'] = ($c_max-( $data['c_come']+$data['c_late'] ));
                $data['percent_absent'] = ($data['c_absent']*100)/$c_max;
            }else{
                $data['max'] = 0;
                $data['user'] = $u->Name." ".$u->SName;
                $data['c_come'] = 0; 
                $data['c_late'] = 0;
                $data['c_absent'] = 0;
                $data['percent_come'] = 0;
                $data['percent_late'] = 0;
                $data['percent_absent'] = 0;
            }
            $this->load->view('history/list_tablecomepeople',$data); 
            echo "pass!";
        }else{
            echo "error!".$str;
        }
    }

    public function list_cometotal(){ // รายงานสรุปการสอนทั้งหมด
        $st = $this->input->post('st');
        $year = $this->input->post('year');
        $term = $this->input->post('term');
        $str = "";

        $rs_y = $this->subject_table_model->select_where("No > 0 GROUP BY Year ORDER BY Year DESC");
        foreach ($rs_y as $row) {
            $rs_t = $this->subject_table_model->select_where("Year = ".$row->Year." GROUP BY Term ORDER BY Term DESC");
            foreach ($rs_t as $row2) {
                $rs_s = $this->config_model->list_date(array('Year' => $row->Year,'Term' => $row2->Term ));
                if(count($rs_s->result()) == 0){
                    $str .= "ปีการศึกษา ".$row->Year." เทอม ".$row2->Term."\n";
                }
            }
        }

        if( $str == ""){

            if( $st == "all" ){
                $count = $this->subject_table_model->get_count("max(`Year`) as max,min(`Year`) as min",array('No_account >' => 0));
                $row = $count->row();
                $sdata['header'] = "ปีการศึกษา ( ".$row->min." - ".$row->max." )";
                $sdata['term'] = "auto";
            }else if( $st == "year" ){
                $sdata['header'] = "ปีการศึกษา ".$year;
                $sdata['term'] = "auto";
            }else if( $st == "term" ){
                if($term == "auto"){
                    $count = $this->subject_table_model->get_count("max(`Term`) as max",array('Year' => $year));
                    $row = $count->row();
                    $term = $row->max; 
                }
                $sdata['term'] = $term;
                $sdata['header'] = "ปีการศึกษา ".$term."/".$year;
            }

            $sdata['sum'] = 0;
            $user = $this->account_model->list_account();
                $c_user = 0;
                foreach ($user as $u) {
                    if( $st == "all" ){
                        $table_subject = $this->subject_table_model->select_where_join(array('No_account' => $u->No));
                    }else if( $st == "year" ){
                        $table_subject = $this->subject_table_model->select_where_join(array('No_account' => $u->No,'Year' => $year));
                    }else if( $st == "term" ){
                        $table_subject = $this->subject_table_model->select_where_join(array('No_account' => $u->No,'Year' => $year,'Term' => $term));
                    }

                    if( count($table_subject->result()) > 0){ 
                        $c_max = 0;
                        $c_level = 0;
                        $c_come = 0;
                        $sdata['sum'] += 1;
                        foreach ($table_subject->result() as $row) {
                            if( $row->Day == "จันทร์"){
                                $day = "Monday";
                            }else if( $row->Day == "อังคาร" ){
                                $day = "Tuesday";
                            }else if( $row->Day == "พุธ" ){
                                $day = "Wednesday";
                            }else if( $row->Day == "พฤหัสบดี" ){
                                $day = "Thursday";
                            }else if( $row->Day == "ศุกร์" ){
                                $day = "Friday";
                            }

                            $date = $this->config_model->list_date(array('Year' => $row->Year,'Term' => $row->Term ));
                            $d = $date->row();
                            $count = $this->getcountday($d->sDate,$d->eDate,$day,$d->sDateExam);
                                if( $row->s_level == 1){
                                    $c_level += $count;
                                    $c_max += $count;

                                    if( $st == "all" ){
                                        $his1 = $this->history_model->get_count("count('status') as count",'No_account ='.$u->No.' and No_timetable = '.$row->Sjt_No.' and Status = "เข้าสอนตรงเวลา" ');
                                        $his2 = $this->history_model->get_count("count('status') as count",'No_account ='.$u->No.' and No_timetable = '.$row->Sjt_No.' and Status = "เข้าสอนสาย"');
                                    }else if( $st == "year" ){
                                        $his1 = $this->history_model->get_count("count('status') as count",'No_account ='.$u->No.' and Year = '.$year.' and No_timetable = '.$row->Sjt_No.' and Status = "เข้าสอนตรงเวลา"');
                                        $his2 = $this->history_model->get_count("count('status') as count",'No_account ='.$u->No.' and Year = '.$year.' and No_timetable = '.$row->Sjt_No.' and  Status = "เข้าสอนสาย"');
                                    }else if( $st == "term" ){
                                        $his1 = $this->history_model->get_count("count('status') as count",'No_account ='.$u->No.' and Year = '.$year.' and Term = '.$term.' and No_timetable = '.$row->Sjt_No.' and  Status = "เข้าสอนตรงเวลา" ');
                                        $his2 = $this->history_model->get_count("count('status') as count",'No_account ='.$u->No.' and Year = '.$year.' and Term = '.$term.' and No_timetable = '.$row->Sjt_No.' and  Status = "เข้าสอนสาย"');
                                    }

                                    if(count($his1->result()) > 0){
                                        $h = $his1->row();
                                        $c_come += $h->count;
                                    }

                                    if(count($his2->result()) > 0){
                                        $h = $his2->row();
                                        $c_level = $c_level-$h->count;
                                    }
                                }else{ 
                                    $c_max += $count;
                                }                  
                        }

                            if( $st == "all" ){
                                $arrData1 = array('No_account' => $u->No,'Status' => "เข้าสอนตรงเวลา");
                                $arrData2 = array('No_account' => $u->No,'Status' => "เข้าสอนสาย");
                            }else if( $st == "year" ){
                                $arrData1 = array('No_account' => $u->No,'Status' => "เข้าสอนตรงเวลา",'Year' => $year);
                                $arrData2 = array('No_account' => $u->No,'Status' => "เข้าสอนสาย",'Year' => $year);
                            }else if( $st == "term" ){
                                $arrData1 = array('No_account' => $u->No,'Status' => "เข้าสอนตรงเวลา",'Year' => $year,'Term' => $term);
                                $arrData2 = array('No_account' => $u->No,'Status' => "เข้าสอนสาย",'Year' => $year,'Term' => $term);
                            }

                        $sdata['max'][$c_user] = $c_max;
                        $sdata['user'][$c_user] = $u->Name." ".$u->SName;
                        $count = $this->history_model->get_count("count('status') as count",$arrData1);
                        $c = $count->row();
                        $history_own = $this->history_model->select_where("select * from history where Status like 'ชดเฉย:%'");
                if(count($history_own->result()) > 0){
                   foreach ($history_own->result() as $row2) {
                       $ht_own = explode(':',$row2->Status);
                       $nDate = new DateTime($ht_own[1]);
                       $day = $this->getday(($nDate->format("Y")-543).$nDate->format("-m-d"));
                       $ht_sj = $this->subject_table_model->select_where_join("Day = '".$day."' and `Group` = '".$ht_own[3]."' and `subject`.`Name` ='".$ht_own[2]."'");
                       if( count($ht_sj->result()) > 0 ){
                            $c_level += 1;
                       }  
                   }
                }
                $history_own = $this->overtime_room_model->select_where("Detail like 'ชดเฉย:%'");
                if(count($history_own->result()) > 0){
                   foreach ($history_own->result() as $row2) {
                       $ht_own = explode(':',$row2->Detail);
                       $nDate = new DateTime($ht_own[1]);
                       $day = $this->getday(($nDate->format("Y")-543).$nDate->format("-m-d"));
                       $ht_sj = $this->subject_table_model->select_where_join("Day = '".$day."' and `Group` = '".$ht_own[3]."' and `subject`.`Name` ='".$ht_own[2]."'");
                       if( count($ht_sj->result()) > 0 ){
                            $c_level += 1;
                       }  
                   }
                }
                        $sdata['c_come'][$c_user] = ($c->count - $c_come)+$c_level; 
                        $sdata['percent_come'][$c_user] = ($sdata['c_come'][$c_user]*100)/$c_max;
                        $count = $this->history_model->get_count("count('status') as count",$arrData2);
                        $c = $count->row();
                        $sdata['c_late'][$c_user] = $c->count;
                        $sdata['percent_late'][$c_user] = ($sdata['c_late'][$c_user]*100)/$c_max;
                        $sdata['c_absent'][$c_user] = ($c_max-( $sdata['c_come'][$c_user]+$sdata['c_late'][$c_user] ));
                        $sdata['percent_absent'][$c_user] = ($sdata['c_absent'][$c_user]*100)/$c_max;
                    }else{
                        $sdata['max'][$c_user] = 0;
                        $sdata['user'][$c_user] = $u->Name." ".$u->SName;
                        $sdata['c_come'][$c_user] = 0; 
                        $sdata['c_late'][$c_user] = 0;
                        $sdata['c_absent'][$c_user] = 0;
                        $sdata['percent_come'][$c_user] = 0;
                        $sdata['percent_late'][$c_user] = 0;
                        $sdata['percent_absent'][$c_user] = 0;
                    }

                    $c_user += 1;   
                }                
            $sdata['round'] = $c_user;
            $this->load->view('history/list_tablecometotal',$sdata);
            echo "pass@";
        }else{
            echo "error!".$str;
        }
    }

    public function list_overtimetotal(){ // รายงานสรุปการใช้ห้องนอกเวลา

        $st = $this->input->post('st');
        $year = $this->input->post('year');
        $term =$this->input->post('term');

        if( $st == "all" ){
            $count = $this->history_model->get_count("max(`Year`) as max,min(`Year`) as min","Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' ");
            $row = $count->row();
            $data['header'] = "ปีการศึกษา ( ".$row->min." - ".$row->max." )";
            $data['term'] = "auto";
            $count = $this->history_model->get_count("count('history.No') as count","Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' ");
            $sort = $this->history_model->sort("Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' and account.No > 1");
        }else if( $st == "year" ){
            $count = $this->history_model->get_count("count('history.No') as count","Year = ".$year." and Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' ");
            $sort = $this->history_model->sort("Year = ".$year." and Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' and account.No > 1");
            $data['header'] = "ปีการศึกษา ".$year;
            $data['term'] = "auto";
        }else if ( $st == "term" ) {
            if($term == "auto"){
                $count = $this->history_model->get_count("max(`Term`) as max","Year = ".$year." and Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' ");
                $row = $count->row();
                $term = $row->max;
                $data['term'] = $term; 
            }
            $count = $this->history_model->get_count("count('history.No') as count","Year = ".$year." and Term = ".$term." and Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย'");
            $sort = $this->history_model->sort("Year = ".$year." and Term = ".$term." and Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' and account.No > 1");
            $data['header'] = "ปีการศึกษา ".$term."/".$year;
            $data['term'] = $term; 
        }
            
        $row = $count->row();
        if($row->count > 0){

            $data['max'] = $row->count;
            $n= 1;
            foreach ($sort as $row) {

                if($row->Flag == 0){
                    $data['user'][$n] = $row->Name." ".$row->SName." (ยกเลิก)";
                }else{
                    $data['user'][$n] = $row->Name." ".$row->SName;
                }
                $name[$n] = $row->No_account;
                if( $st == "all" ){
                    $count = $this->history_model->get_count("count('history.No') as count","No_account = ".$row->No_account." and Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' ");
                }else if( $st == "year" ){
                    $count = $this->history_model->get_count("count('history.No') as count","No_account = ".$row->No_account." and Year = ".$year." and Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' ");
                }else if ( $st == "term" ) {
                    $count = $this->history_model->get_count("count('history.No') as count","No_account = ".$row->No_account." and Year = ".$year." and Term = ".$term." and Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' ");
                }
                $row = $count->row();
                $data['val'][$n] = $row->count;
                $n += 1;
            }

            $user = $this->account_model->not_in_account($name);
            foreach ($user as $row ) {
                if($row->Flag == 0){
                    $data['user'][$n] = $row->Name." ".$row->SName." (ยกเลิก)";
                }else{
                    $data['user'][$n] = $row->Name." ".$row->SName;
                }
                $data['val'][$n] = 0;
                $n += 1;
            }

            $data['round'] = $n-1;
        }else{
            $data['header'] = "ปีการศึกษา ".$term."/".$year;
            $data['max'] = 0;
        }
        
        $this->load->view('history/list_overtimetotal',$data);
    }
  
    public function list_replace(){
        $user = $this->input->post('user');
        $year = $this->input->post('year');
        $term = $this->input->post('term');

        if( $user == "all" && $year != "all" && $term != "all"){ 
            $data['result'] = $this->history_model->select_where("select Name,SName,Begin,End,Number_Room from history join account on history.No_account = account.No join number_locker on history.No_numberlocker = number_locker.No where history.Replace <> 'null' and Year = ".$year." and Term = ".$term." ORDER BY history.Begin desc");
            $data['result2'] = $this->history_model->select_where("select Name,SName from history join account on history.Replace = account.No where history.Replace <> 'null' and Year = ".$year." and Term = ".$term." ORDER BY history.Begin desc");
        }else if( $user == "all" && $year == "all" && $term != "all" ){
            $data['result'] = $this->history_model->select_where("select Name,SName,Begin,End,Number_Room from history join account on history.No_account = account.No join number_locker on history.No_numberlocker = number_locker.No where history.Replace <> 'null' and Term = ".$term." ORDER BY history.Begin desc");
            $data['result2'] = $this->history_model->select_where("select Name,SName from history join account on history.Replace = account.No where history.Replace <> 'null' and Term = ".$term." ORDER BY history.Begin desc");
        }else if( $user == "all" && $year == "all" && $term == "all" ){
            $data['result'] = $this->history_model->select_where("select Name,SName,Begin,End,Number_Room from history join account on history.No_account = account.No join number_locker on history.No_numberlocker = number_locker.No where history.Replace <> 'null' ORDER BY history.Begin desc");
            $data['result2'] = $this->history_model->select_where("select Name,SName from history join account on history.Replace = account.No where history.Replace <> 'null' ORDER BY history.Begin desc");
        }else if( $user != "all" && $year == "all" && $term == "all" ){
            $data['result'] = $this->history_model->select_where("select Name,SName,Begin,End,Number_Room from history join account on history.No_account = account.No join number_locker on history.No_numberlocker = number_locker.No where history.Replace <> 'null' and No_account = ".$user." ORDER BY history.Begin desc");
            $data['result2'] = $this->history_model->select_where("select Name,SName from history join account on history.Replace = account.No where history.Replace <> 'null' and No_account = ".$user." ORDER BY history.Begin desc");
        }else if( $user != "all" && $year == "all" && $term != "all" ){
            $data['result'] = $this->history_model->select_where("select Name,SName,Begin,End,Number_Room from history join account on history.No_account = account.No join number_locker on history.No_numberlocker = number_locker.No where history.Replace <> 'null' and Term = ".$term." and No_account = ".$user." ORDER BY history.Begin desc");
            $data['result2'] = $this->history_model->select_where("select Name,SName from history join account on history.Replace = account.No where history.Replace <> 'null' and Term = ".$term." and No_account = ".$user." ORDER BY history.Begin desc");
        }else if( $user == "all" && $year != "all" && $term == "all" ){
            $data['result'] = $this->history_model->select_where("select Name,SName,Begin,End,Number_Room from history join account on history.No_account = account.No join number_locker on history.No_numberlocker = number_locker.No where history.Replace <> 'null' and Year = ".$year." ORDER BY history.Begin desc");
            $data['result2'] = $this->history_model->select_where("select Name,SName from history join account on history.Replace = account.No where history.Replace <> 'null' and Year = ".$year." ORDER BY history.Begin desc");
        }else if( $user != "all" && $year != "all" && $term == "all" ){
            $data['result'] = $this->history_model->select_where("select Name,SName,Begin,End,Number_Room from history join account on history.No_account = account.No join number_locker on history.No_numberlocker = number_locker.No where history.Replace <> 'null' and Year = ".$year." and No_account = ".$user." ORDER BY history.Begin desc");
            $data['result2'] = $this->history_model->select_where("select Name,SName from history join account on history.Replace = account.No where history.Replace <> 'null' and Year = ".$year." and No_account = ".$user." ORDER BY history.Begin desc");
        }else if( $user != "all" && $year != "all" && $term != "all" ){
            $data['result'] = $this->history_model->select_where("select Name,SName,Begin,End,Number_Room from history join account on history.No_account = account.No join number_locker on history.No_numberlocker = number_locker.No where history.Replace <> 'null' and Year = ".$year." and Term = ".$term." and No_account = ".$user." ORDER BY history.Begin desc");
            $data['result2'] = $this->history_model->select_where("select Name,SName from history join account on history.Replace = account.No where history.Replace <> 'null' and Year = ".$year." and Term = ".$term." and No_account = ".$user." ORDER BY history.Begin desc");
        }

        $count = 1;
        if(count($data['result']->result()) > 0){
            foreach ($data['result']->result() as $key ) {
                $bDate = new DateTime($key->Begin);
                $eDate = new DateTime($key->End);
                $data['Buser'][$count] = $key->Name." ".$key->SName;
                $data['date'][$count] = $bDate->format("Y-m-d");
                $data['timeb'][$count] = $bDate->format("H:i:s");
                $data['timee'][$count] = $eDate->format("H:i:s");
                $data['room'][$count] = $key->Number_Room;
                $count += 1;
            }
        }

        $count = 1;
        if(count($data['result2']->result()) > 0){
            foreach ($data['result2']->result() as $key ) {
                $data['Euser'][$count] = $key->Name." ".$key->SName;
                $count += 1;
            }
        }

        $data['max'] = $count-1;
        $this->load->view('history/list_replace',$data);
    }

    /*                         view                                     */
    
    public function view_add() {
      if($this->session->userdata("sess_username") != null){

        $data['result'] = $this->history_model->list_history(array('No_account' => $this->session->userdata("sess_id"),'Status' => "empty" ),"all");
        $data['user'] = $this->account_model->list_account();
        $this->session->set_userdata('sess_message',count($data['result']));
        $this->load->view('main/header');
        $this->load->view('history/add',$data);
        $this->load->view('main/footer');
       }else{

        redirect('account_controller/view_login','refresh');
      }
    }

    public function view_show(){
        if($this->session->userdata("sess_username") != null){
            $rs_st = $this->subject_table_model->select_where("No > 0");
            $rs_ht = $this->history_model->get_count("*","Status = 'empty' or Status = 'แจ้ง'");
            $rs_ht1 = $this->history_model->get_count("*","`Replace` <> 'null'");
            //$rs_ht2 = $this->overtime_room_model->select_where("No > 0");

            if( $this->input->post('st') == "" || $this->input->post('st') == "report"){ // รายงานการสอน

                if( count($rs_st) > 0){
                    $data['user'] = $this->account_model->list_account();
                    $data['year'] = $this->subject_table_model->list_year("0");
                    $this->load->view('main/header');
                    $this->load->view('history/menu');
                    $this->load->view('history/table_report',$data);
                    $this->load->view('main/footer');
                }else{
                    $data['data'] = "ต้องมีตารางสอนก่อน และต้องกำหนดวันที่ก่อน วิธีการกำหนดวันที่ ไปที่ตั้งต่า แล้วเลือก กำหนดวันเริ่ม - จบ";
                    $this->load->view('main/header');
                    $this->load->view('history/menu');
                    $this->load->view('main/found',$data);
                    $this->load->view('main/footer');
                }
            }else if( $this->input->post('st') == "" || $this->input->post('st') == "report_overtime"){ // รายงานการใช้ห้องนอกเวลา

                if( count($rs_ht->result()) > 0){
                    $data['user'] = $this->account_model->list_account();
                    $data['year'] = $this->history_model->list_year();
                    $this->load->view('main/header');
                    $this->load->view('history/menu');
                    $this->load->view('history/table_overtime',$data);
                    $this->load->view('main/footer');
                }else{
                    $data['data'] = "ไม่มีประวัติการใช้ห้องนอกเวลา";
                    $this->load->view('main/header');
                    $this->load->view('history/menu');
                    $this->load->view('main/found',$data);
                    $this->load->view('main/footer');
                }
            }else if( $this->input->post('st') == "" || $this->input->post('st') == "report_come_people"){ // รายงานการเข้าสอน
                
                if( count($rs_st) > 0){
                    $data['user'] = $this->account_model->list_account();
                    $data['year'] = $this->subject_table_model->list_year("0");
                    $data['hearder'] = "รายงานสรุปการเข้าสอน (บุคคล)";
                    $this->load->view('main/header');
                    $this->load->view('history/menu');
                    $this->load->view('history/table_come_people',$data);
                    $this->load->view('main/footer');
                }else{
                    $data['data'] = "ต้องมีตารางสอนก่อน และต้องกำหนดวันที่ก่อน วิธีการกำหนดวันที่ ไปที่ตั้งต่า แล้วเลือก กำหนดวันเริ่ม - จบ";
                    $this->load->view('main/header');
                    $this->load->view('history/menu');
                    $this->load->view('main/found',$data);
                    $this->load->view('main/footer');
                }
            }else if( $this->input->post('st') == "report_come_total"){ //รายงานสรุปการเข้าสอนทั้งหมด

                if( count($rs_st) > 0){
                    $data['hearder'] = "รายงานสรุปการเข้าสอน (ทั้งหมด)";
                    $this->load->view('main/header');
                    $this->load->view('history/menu');
                    $this->load->view('history/table_come_total',$data);
                    $this->load->view('main/footer');
                }else{
                    $data['data'] = "ต้องมีตารางสอนก่อน และต้องกำหนดวันที่ก่อน วิธีการกำหนดวันที่ ไปที่ตั้งต่า แล้วเลือก กำหนดวันเริ่ม - จบ";
                    $this->load->view('main/header');
                    $this->load->view('history/menu');
                    $this->load->view('main/found',$data);
                    $this->load->view('main/footer');
                }
            }else if( $this->input->post('st') == "report_overtime_total" ){ // รายงาการสรุปการใช้ห้องนอกเวลา 

                if( count($rs_ht->result()) > 0){
                    $this->load->view('main/header');
                    $this->load->view('history/menu');
                    $this->load->view('history/table_overtime_total');
                    $this->load->view('main/footer');
                }else{
                    $data['data'] = "ไม่มีประวัติการใช้ห้องนอกเวลา";
                    $this->load->view('main/header');
                    $this->load->view('history/menu');
                    $this->load->view('main/found',$data);
                    $this->load->view('main/footer');
                }
            }else if( $this->input->post('st') == "report_replace" ){ // รายงานการเปิดห้องแทน

                if( count($rs_ht1->result()) > 0){
                    $data['user'] = $this->account_model->list_account();
                    $data['year'] = $this->history_model->list_year();
                    $this->load->view('main/header');
                    $this->load->view('history/menu');
                    $this->load->view('history/table_replace',$data);
                    $this->load->view('main/footer');
                }else{
                    $data['data'] = "ไม่มีประวัติการเปิดห้องแทน";
                    $this->load->view('main/header');
                    $this->load->view('history/menu');
                    $this->load->view('main/found',$data);
                    $this->load->view('main/footer');
                }
            }                  
        }else{
            redirect('account_controller/view_login','refresh');
        }  
    } 

    public function refresh($user,$pass,$fail){
        $data['result'] = $this->history_model->list_history(array('No_account' => $user,'Status' => "empty" ),"all");
        if( $user == $this->session->userdata("sess_id") ){
            $this->session->set_userdata('sess_message',count($data['result']));
        }
        $data['pass'] = $pass;
        $data['fail'] = $fail;
        $this->load->view('history/refresh',$data);
    }
}
