<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class report_controller extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('account_model');
    $this->load->model('history_model');
    $this->load->model('subject_table_model');
    $this->load->model('config_model');
    $this->load->controller('history_controller');
    $this->load->library("mpdf_v6/mpdf"); //โหลด Library โฟล์เดอร์ mpdf ตามด้วยชื่อไฟล์ mpdf ไม่    //ต้องมี .php นะครับ
  }

    public function excel($data){

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=".$data['header'].".xls");
 
        $th = explode(":",$data['th']);
        $td = explode(":",$data['td']);
        $max = $data['max']-1;
        if( $data['max'] == 0){
            $max = 1;
        }
        for($i=1; $i<=$max; $i++){ 
            if( $i == 1 ) { 
                $html.="<table border='1'>";
                $html.="<tr><td colspan='".$data['col']."' align='center'><h2>".$data['header']."</h2></td></tr>";
                $html.="<tr>";
                for ($n=0; $n< count($th); $n++) { 
                    $html.="<th>".$th[$n]."</th>"; 
                }
                $html.="</tr>";
            }
            if( $data['max'] == 0){
                $html.="<tr><td colspan='".$data['col']."' align='center'>ไม่มีข้อมูล</td></tr>";
            }else{
                $html.="<tr>";
                $html.="<td align='right'>$i</td>";
                for ($n=0; $n < count($td) ; $n++) { 
                    $html.="<td>".$data[$td[$n]][$i]."</td>";
                }
                $html.="</tr>";
            }
            if( $i == $max ) { 
                $html.="</table>";
            }
        }
        echo $html;
    }

      public function pdf($data){  
        $count = 1;
        $th = explode(":",$data['th']);
        $td = explode(":",$data['td']);
        $set = explode(":",$data['set']);
        $max = $data['max']-1;
        if( $data['max'] == 0){
            $max = 1;
        }
        for($i=1; $i<=$max; $i++){ 
            if( $i == 1 ) { 
                $html.="<table border='1' align='center' width='100%' style='border-collapse: collapse'>";
                $html.="<tr><td colspan='".$data['col']."' align='center'><h2>".$data['header']."</h2></td></tr>";
                $html.="<tr>";
                for ($n=0; $n< count($th); $n++) { 
                    $html.="<th width='".$set[$n]."%'>".$th[$n]."</th>"; 
                }
                $html.="</tr>";
            $count += $data['pdf-max'];
            }
        if( $data['max'] == 0){
            $html.="<tr><td colspan='".$data['col']."' align='center'>ไม่มีข้อมูล</td></tr>";
        }else{
            $html.="<tr>";
            $html.="<td align='right'>$i</td>";
            for ($n=0; $n < count($td) ; $n++) { 
                $html.="<td>".$data[$td[$n]][$i]."</td>";
            }
            $html.="</tr>";
        }
        if(  $i == $max ) { 
            $html.="</table>";
        }
    }
    $this->mpdf= new mPDF('th'); //เรียกใช้งาน mPDF ส่งค่า parameter เข้าไปครับ
    $this->mpdf->WriteHTML($html); // สั่งให้ mPDF เขียนไฟล์ pdf
    $this->mpdf->Output(''.$data['header'].'.pdf', 'D'); // จากนั้นส่งชื่อไฟล์ออกมาครับผม
    }

    public function list_report(){   // รายงาการสอน
        $user = $this->input->post('export_user');
        $year = $this->input->post('export_year');
        $term = $this->input->post('export_term');
        $export = $this->input->post('export');
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
                        if($day == date("l",strtotime($edate))){
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
                            $tDate = new DateTime($eDate);
                            $datearray = explode("-", $tDate->format("Y-m-d"));
                            $data['user'][$count] = $row->a_name." ".$row->SName;
                            if( $export == 'PDF' ){
                                $data['year'][$count] = $row->Term."/".$row->Year;
                            }else{
                                $data['year'][$count] = $row->Term."|".$row->Year;
                            }
                            $data['subject'][$count] = $row->s_name."(".$row->Group.")";
                            $data['date'][$count] = $tDate->format("d-m-").($datearray[0]+543);//$edate;
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
            $data['pdf-max'] = 44;
            $data['col'] = 6;
            $data['th'] = "ลับดำ:ชื่อ - นามสกุล:ปีการศึกษา:ชื่อวิชา(กลุ่ม):วัน:สถานะ";
            $data['td'] = "user:year:subject:date:status";
            $data['header'] = "รายงานการสอน";
            $data['set'] = "10:25:15:15:15:20";
            if( $export == 'PDF' ){
                $this->pdf($data);
            }else{
                $this->excel($data);
            }
        }else{
        }
    }

    public function list_overtime(){  // รายงานการใช้ห้องนอกเวลา
        $user = $this->input->post('export_user');
        $year = $this->input->post('export_year');
        $term = $this->input->post('export_term');
        $export = $this->input->post('export');

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
                $datearray = explode("-", $bDate->format("Y-m-d"));


                $data['name'][$c_user] = $rs1->Name." ".$rs1->SName;
                if( $export == 'PDF' ){
                    $data['year'][$c_user] = $rs1->Term."/".$rs1->Year;
                }else{
                    $data['year'][$c_user] = $rs1->Term."|".$rs1->Year;
                }
                $data['date'][$c_user] = $bDate->format("d-m-").($datearray[0]+543);
                $data['begin'][$c_user] = $bDate->format("H:i:s");
                $data['end'][$c_user] = $eDate->format("H:i:s");
                $data['room'][$c_user] = $rs1->Number_Room;
                if( $rs1->Status == "empty" ){
                    $data['detail'][$c_user] = "ยังไม่ได้กรอกเหตุผล";
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
                if( $export == 'PDF' ){
                    $data['year'][$c_user] = $rs2->Term."/".$rs2->Year;
                }else{
                    $data['year'][$c_user] = $rs2->Term."|".$rs2->Year;
                }
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
        $data['pdf-max'] = 47;
        $data['max'] = $c_user;
        $data['col'] = 8;
        $data['th'] = "ลำดับ:ชื่อ - นามสกุล:ปีการศึกษา:วันที่:เวลาเริ่ม:เวลาจบ:ห้อง:เหตุผลการใช้ห้องนอกเวลา";
        $data['td'] = "name:year:date:begin:end:room:detail";
        $data['header'] = "รายงานการใช้ห้องนอกเวลา";
        $data['set'] = "10:25:14:14:11:11:6:20";
        if( $export == 'PDF' ){
            $this->pdf($data);
        }else{
            $this->excel($data);
        }
    }

    public function list_comepeople(){ // รายงานการมาสอนบุคคล
        $user = $this->input->post('export_user');
        $year = $this->input->post('export_year');
        $term = $this->input->post('export_term');
        $export = $this->input->post('export');

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
                    $count = $this->history_controller->getcountday($d->sDate,$d->eDate,$day,$d->sDateExam);
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
                $data['cmax'][1] = $data['max']." ( 100% )";
                $data['user'] = $u->Name." ".$u->SName;
                $count = $this->history_model->get_count("count('status') as count",$arrData1);
                $c = $count->row();
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
                $data['cmax'][1] = $data['max']." ( 0% )";
                $data['user'] = $u->Name." ".$u->SName;
                $data['c_come'] = 0; 
                $data['c_late'] = 0;
                $data['c_absent'] = 0;
                $data['percent_come'] = 0;
                $data['percent_late'] = 0;
                $data['percent_absent'] = 0;
            }

            $data['max'] = 2;
            $data['users'][1] = $data['user'];
            $data['come'][1] = $data['c_come']." ( ".number_format($data['percent_come'], 2, '.', '')." )";
            $data['late'][1] = $data['c_late']." ( ".number_format($data['percent_late'], 2, '.', '')." )";
            $data['absent'][1] = $data['c_absent']." ( ".number_format($data['percent_absent'], 2, '.', '')." )";
            $data['pdf-max'] = 41;
            $data['col'] = 6;
            if( $export == 'PDF' ){
                $data['th'] = "ลำดับ:ชื่อ - นามสกุล:เข้าสอนทั้งหมด (ครั้ง):เข้าสอนตรงเวลา (ครั้ง):เข้าสอนสาย (ครั้ง):ขาดสอน <br> (ครั้ง)";
            }else{
                $data['th'] = "ลำดับ:ชื่อ - นามสกุล:เข้าสอนทั้งหมด (ครั้ง):เข้าสอนตรงเวลา (ครั้ง):เข้าสอนสาย (ครั้ง):ขาดสอน (ครั้ง)";
            }
            $data['td'] = "users:cmax:come:late:absent";
            $data['header'] = "รายงานสรุปการเข้าสอน (บุคคล) ".$data['header'];
            $data['set'] = "10:25:20:15:15:15";
            if( $export == 'PDF' ){
                $this->pdf($data);
            }else{
                $this->excel($data);
            }
        }else{
        }
    }

    public function list_cometotal(){ // รายงานสรุปการสอนทั้งหมด

        $st = $this->input->post('export_st');
        $year = $this->input->post('export_year');
        $term = $this->input->post('export_term');
        $page = $this->input->post('export_page');
        $export = $this->input->post('export');
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
                $c_user = 1;
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
                            $count = $this->history_controller->getcountday($d->sDate,$d->eDate,$day,$d->sDateExam);
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
                        $sdata['cmax'][$c_user] = $sdata['max'][$c_user]." ( 100% )";
                        $sdata['user'][$c_user] = $u->Name." ".$u->SName;
                        $count = $this->history_model->get_count("count('status') as count",$arrData1);
                        $c = $count->row();
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
                        $sdata['cmax'][$c_user] = $sdata['max'][$c_user]." ( 0% )";
                        $sdata['user'][$c_user] = $u->Name." ".$u->SName;
                        $sdata['c_come'][$c_user] = 0; 
                        $sdata['c_late'][$c_user] = 0;
                        $sdata['c_absent'][$c_user] = 0;
                        $sdata['percent_come'][$c_user] = 0;
                        $sdata['percent_late'][$c_user] = 0;
                        $sdata['percent_absent'][$c_user] = 0;
                    }
                    $sdata['come'][$c_user] = $sdata['c_come'][$c_user]." ( ".number_format($sdata['percent_come'][$c_user], 2, '.', '')." )";
                    $sdata['late'][$c_user] = $sdata['c_late'][$c_user]." ( ".number_format($sdata['percent_late'][$c_user], 2, '.', '')." )";
                    $sdata['absent'][$c_user] = $sdata['c_absent'][$c_user]." ( ".number_format($sdata['percent_absent'][$c_user], 2, '.', '')." )";
                    $c_user += 1;   
                }
                $sdata['max'] = $c_user;
                $sdata['col'] = 6;
                $sdata['pdf-max'] = 41;
                if( $export == 'PDF' ){
                    $sdata['th'] = "ลำดับ:ชื่อ - นามสกุล:เข้าสอนทั้งหมด (ครั้ง):เข้าสอนตรงเวลา (ครั้ง):เข้าสอนสาย (ครั้ง):ขาดสอน <br> (ครั้ง)";
                }else{
                    $sdata['th'] = "ลำดับ:ชื่อ - นามสกุล:เข้าสอนทั้งหมด (ครั้ง):เข้าสอนตรงเวลา (ครั้ง):เข้าสอนสาย (ครั้ง):ขาดสอน (ครั้ง)";
                }
                $sdata['td'] = "user:cmax:come:late:absent";
                $sdata['header'] = "รายงานสรุปการเข้าสอน (ทั้งหมด) ".$sdata['header'];
                $sdata['set'] = "10:25:20:15:15:15";
                if( $export == 'PDF' ){
                    $this->pdf($sdata);
                }else{
                    $this->excel($sdata);
                }                
        }else{
        }
    }

    public function list_overtimetotal(){ // รายงานสรุปการใช้ห้องนอกเวลา

        $st = $this->input->post('export_st');
        $year = $this->input->post('export_year');
        $term = $this->input->post('export_term');
        $page = $this->input->post('export_page');
        $export = $this->input->post('export');

        if( $st == "all" ){
            $count = $this->history_model->get_count("max(`Year`) as max,min(`Year`) as min","Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' ");
            $row = $count->row();
            $data['header'] = "ปีการศึกษา ( ".$row->min." - ".$row->max." )";
            $data['term'] = "auto";
            $count = $this->history_model->get_count("count('history.No') as count","Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' ");
            $sort = $this->history_model->sort("Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' ");
        }else if( $st == "year" ){
            $count = $this->history_model->get_count("count('history.No') as count","Year = ".$year." and Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' ");
            $sort = $this->history_model->sort("Year = ".$year." and Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' ");
            $data['header'] = "ปีการศึกษา ".$year;
            $data['term'] = "auto";
        }else if ( $st == "term" ) {
            if($term == "auto"){
                $count = $this->history_model->get_count("max(`Term`) as max","Year = ".$year." and Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' ");
                $row = $count->row();
                $term = $row->max;
                $data['term'] = $term; 
            }
            $count = $this->history_model->get_count("count('history.No') as count","Year = ".$year." and Term = ".$term." and Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' ");
            $sort = $this->history_model->sort("Year = ".$year." and Term = ".$term." and Status != 'เข้าสอนตรงเวลา' and Status != 'เข้าสอนสาย' ");
            $data['header'] = "ปีการศึกษา ".$term."/".$year;
            $data['term'] = $term; 
        }
            
        $rows = $count->row();
        if($rows->count > 0){

            $n= 1;
            foreach ($sort as $row) {
                $data['cmax'][$n] = $rows->count;
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
                $data['percent'][$n] = number_format((intval($data['val'][$n])*100)/intval($data['cmax'][$n]), 2, '.', '');
                $n += 1;
            }

            $user = $this->account_model->not_in_account($name);
            foreach ($user as $row ) {
                $data['cmax'][$n] = $rows->count;
                if($row->Flag == 0){
                    $data['user'][$n] = $row->Name." ".$row->SName." (ยกเลิก)";
                }else{
                    $data['user'][$n] = $row->Name." ".$row->SName;
                }
                $data['val'][$n] = 0;
                $data['percent'][$n] = "0.00";
                $n += 1;
            }
            $data['max'] = $n;
        }else{
            $data['header'] = "ปีการศึกษา ".$term."/".$year;
            $data['cmax'] = 0;
            $data['max'] = 0;
        }
        
        $data['col'] = 5;
        $data['pdf-max'] = 41;
        $data['th'] = "ลำดับ:ชื่อ - นามสกุล:จำนวนการใช้ห้องทั้งหมด (ครั้ง):จำนวนที่ใช้ (ครั้ง):คิดเป็น %";
        $data['td'] = "user:cmax:val:percent";
        $data['header'] = "รายงานสรุปการใช้ห้องนอกเวลา ".$data['header'];
        $data['set'] = "10:25:25:20:20";
        if( $export == 'PDF' ){
            $this->pdf($data);
        }else{
            $this->excel($data);
        }                
    }

    public function list_replace(){// รายงานการเปิดห้องแทน
        $user = $this->input->post('export_user');
        $year = $this->input->post('export_year');
        $term = $this->input->post('export_term');
        $export = $this->input->post('export');

        if( $user == "all" && $year != "all" && $term != "all"){ 
            $data['result'] = $this->history_model->select_where("select Name,SName,Begin,End,Number_Room from history join account on history.No_account = account.No join number_locker on history.No_numberlocker = number_locker.No where history.Replace is not null and Year = ".$year." and Term = ".$term." ORDER BY history.Begin desc");
            $data['result2'] = $this->history_model->select_where("select Name,SName from history join account on history.Replace = account.No where history.Replace is not null and Year = ".$year." and Term = ".$term." ORDER BY history.Begin desc");
        }else if( $user == "all" && $year == "all" && $term != "all" ){
            $data['result'] = $this->history_model->select_where("select Name,SName,Begin,End,Number_Room from history join account on history.No_account = account.No join number_locker on history.No_numberlocker = number_locker.No where history.Replace is not null and Term = ".$term." ORDER BY history.Begin desc");
            $data['result2'] = $this->history_model->select_where("select Name,SName from history join account on history.Replace = account.No where history.Replace is not null and Term = ".$term." ORDER BY history.Begin desc");
        }else if( $user == "all" && $year == "all" && $term == "all" ){
            $data['result'] = $this->history_model->select_where("select Name,SName,Begin,End,Number_Room from history join account on history.No_account = account.No join number_locker on history.No_numberlocker = number_locker.No where history.Replace is not null ORDER BY history.Begin desc");
            $data['result2'] = $this->history_model->select_where("select Name,SName from history join account on history.Replace = account.No where history.Replace is not null ORDER BY history.Begin desc");
        }else if( $user != "all" && $year == "all" && $term == "all" ){
            $data['result'] = $this->history_model->select_where("select Name,SName,Begin,End,Number_Room from history join account on history.No_account = account.No join number_locker on history.No_numberlocker = number_locker.No where history.Replace is not null and No_account = ".$user." ORDER BY history.Begin desc");
            $data['result2'] = $this->history_model->select_where("select Name,SName from history join account on history.Replace = account.No where history.Replace is not null and No_account = ".$user." ORDER BY history.Begin desc");
        }else if( $user != "all" && $year == "all" && $term != "all" ){
            $data['result'] = $this->history_model->select_where("select Name,SName,Begin,End,Number_Room from history join account on history.No_account = account.No join number_locker on history.No_numberlocker = number_locker.No where history.Replace is not null and Term = ".$term." and No_account = ".$user." ORDER BY history.Begin desc");
            $data['result2'] = $this->history_model->select_where("select Name,SName from history join account on history.Replace = account.No where history.Replace is not null and Term = ".$term." and No_account = ".$user." ORDER BY history.Begin desc");
        }else if( $user == "all" && $year != "all" && $term == "all" ){
            $data['result'] = $this->history_model->select_where("select Name,SName,Begin,End,Number_Room from history join account on history.No_account = account.No join number_locker on history.No_numberlocker = number_locker.No where history.Replace is not null and Year = ".$year." ORDER BY history.Begin desc");
            $data['result2'] = $this->history_model->select_where("select Name,SName from history join account on history.Replace = account.No where history.Replace is not null and Year = ".$year." ORDER BY history.Begin desc");
        }else if( $user != "all" && $year != "all" && $term == "all" ){
            $data['result'] = $this->history_model->select_where("select Name,SName,Begin,End,Number_Room from history join account on history.No_account = account.No join number_locker on history.No_numberlocker = number_locker.No where history.Replace is not null and Year = ".$year." and No_account = ".$user." ORDER BY history.Begin desc");
            $data['result2'] = $this->history_model->select_where("select Name,SName from history join account on history.Replace = account.No where history.Replace is not null and Year = ".$year." and No_account = ".$user." ORDER BY history.Begin desc");
        }else if( $user != "all" && $year != "all" && $term != "all" ){
            $data['result'] = $this->history_model->select_where("select Name,SName,Begin,End,Number_Room from history join account on history.No_account = account.No join number_locker on history.No_numberlocker = number_locker.No where history.Replace is not null and Year = ".$year." and Term = ".$term." and No_account = ".$user." ORDER BY history.Begin desc");
            $data['result2'] = $this->history_model->select_where("select Name,SName from history join account on history.Replace = account.No where history.Replace is not null and Year = ".$year." and Term = ".$term." and No_account = ".$user." ORDER BY history.Begin desc");
        }

        $count = 1;
        if(count($data['result']->result()) > 0){
            foreach ($data['result']->result() as $key ) {
                $bDate = new DateTime($key->Begin);
                $eDate = new DateTime($key->End);
                $datearray = explode("-", $eDate->format("Y-m-d"));
                $data['Buser'][$count] = $key->Name." ".$key->SName;
                $data['date'][$count] = $bDate->format("d-m-").$datearray[0];
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

        $data['max'] = $count;
        $data['pdf-max'] = 44;
        $data['col'] = 7;
        $data['th'] = "ลับดำ:ชื่อ - นามสกุล:วันที่:เวลาเริ่ม:เวลาจบ:ห้อง:คนเปิดแทน";
        $data['td'] = "Buser:date:timeb:timee:room:Euser";
        $data['header'] = "รายงานการเปิดแทน";
        $data['set'] = "10:25:10:10:10:10:25";
        if( $export == 'PDF' ){
            $this->pdf($data);
        }else{
            $this->excel($data);
        }       
    }

}
