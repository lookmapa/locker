<?php date_default_timezone_set('America/Los_Angeles'); ?>
<table class="table table-bordered  table-history" style="size:2px;">
    <thead>
        <tr class="info">
            <th> ลำดับ </th>
            <th> ชื่อ </th>
            <th> ปีการศึกษา </th>
            <th> ชื่อวิชา(กลุ่ม) </th>
            <th> วัน </th>
            <th> สถานะ </th>
        </tr>
    </thead>
	<tbody>
		<?php
        $df_user = 0;
        $df_year = 0;
        $df_subject = 0;
        $df_date = 0;
        $df_status = 0;
        $count_user = 1;
        $count_year = 1;
        $count_subject = 1;
        $count_date = 1;
        $count_status = 1;
        $b_user = "1/";
        $b_year = "1/";
        $b_subject = "1/";
        $b_date = "1/";
        $b_status = "1/";
        $n_user = "";
        $n_year = "";
        $n_subject = "";
        $n_date = "";
        $n_status = "";
        $count = 1;

        if( $max > 0){

            for($i = 1; $i < $max; $i++){
                if($i == 1){
                    $df_user = $user[$i];
                    $df_year = $year[$i];
                    $df_subject = $subject[$i];
                    $df_date = $date[$i];
                    $df_status = $status[$i];
                }else{
                    if($df_user == $user[$i]){
                        $count_user += 1;
                    }else{
                        $b_user .= $i."/";
                        $n_user .= $count_user."/";
                        $df_user = $user[$i];
                        $count_user = 1;
                    }

                    if($df_year == $year[$i]){
                        $count_year += 1;
                    }else{
                        $b_year .= $i."/";
                        $n_year .= $count_year."/";
                        $df_year = $year[$i];
                        $count_year = 1;
                    }

                    if( $df_subject == $subject[$i]){
                        $count_subject += 1;
                    }else{
                        $b_subject .= $i."/";
                        $n_subject .= $count_subject."/";
                        $df_subject = $subject[$i];
                        $count_subject = 1;
                    }

                    if( $df_date == $date[$i]){
                        $count_date += 1;
                    }else{
                        $b_date .= $i."/";
                        $n_date .= $count_date."/";
                        $df_date = $date[$i];
                        $count_date = 1;
                    }

                    if( $df_status == $status[$i]){
                        $count_status += 1;
                    }else{
                        $b_status .= $i."/";
                        $n_status .= $count_status."/";
                        $df_status = $status[$i];
                        $count_status = 1;
                    }
                }
                if( $i == $max-1){
                    $n_user .= $count_user;
                    $n_year .= $count_year;
                    $n_subject .= $count_subject;
                    $n_date .= $count_date;
                    $n_status .= $count_status;
                }
            }

            $c_user = 0;
            $c_year = 0;
            $c_subject = 0;
            $c_date = 0;
            $c_status = 0;
            $arr_buser = explode("/", $b_user);
            $arr_nuser = explode("/", $n_user);
            $arr_byear = explode("/", $b_year);
            $arr_nyear = explode("/", $n_year);
            $arr_bsubject = explode("/", $b_subject);
            $arr_nsubject = explode("/", $n_subject);
            $arr_bdate = explode("/", $b_date);
            $arr_ndate = explode("/", $n_date);
            $arr_bstatus = explode("/", $b_status);
            $arr_nstatus = explode("/", $n_status);

            for($i = 1; $i < $max; $i++){
                echo "<tr>";
                echo "<td>".$i."</td>";
                if( $i == $arr_buser[$c_user] ){ echo "<td rowspan='".$arr_nuser[$c_user]."'>".$user[$i]."</td>"; $c_user += 1; }
                if( $i == $arr_byear[$c_year] ){ echo "<td rowspan='".$arr_nyear[$c_year]."'>".$year[$i]."</td>"; $c_year += 1; }
                if( $i == $arr_bsubject[$c_subject] ){ echo "<td rowspan='".$arr_nsubject[$c_subject]."'>".$subject[$i]."</td>"; $c_subject += 1; }
                if( $i == $arr_bdate[$c_date] ){ echo "<td rowspan='".$arr_ndate[$c_date]."'>".$date[$i]."</td>"; $c_date += 1;}
                if( $i == $arr_bstatus[$c_status] ){ 
                    if( $status[$i] == "ขาดสอน"){ 
                        echo "<td rowspan='".$arr_nstatus[$c_status]."'><font style='color:red'>".$status[$i]."</font></td>"; 
                    }else{ 
                        echo "<td rowspan='".$arr_nstatus[$c_status]."'>".$status[$i]."</td>"; 
                    }
                    $c_status += 1;
                }
                echo "</tr>";
            }
        }else{
            echo "<tr><td colspan='6'  style='text-align: center' > ไม่มีข้อมูล </td></tr>";
        }
        ?>       
	</tbody>
</table>



