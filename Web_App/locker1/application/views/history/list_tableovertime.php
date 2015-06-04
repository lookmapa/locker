<?php date_default_timezone_set('America/Los_Angeles'); ?>
<table class="table table-bordered  table-historydetail" style="size:2px;">
    <thead>
        <tr class="info">
            <th> ลำดับ </th>
            <th> ชื่อ </th>
            <th> ปีการศึกษา </th>
            <th> วันที่ </th>
            <th> เวลาเริ่ม </th>
            <th> เวลาสิ้นสุด </th>
            <th> ห้อง </th>
            <th> เหตุผลการใช้ห้องนอกเวลา </th>
        </tr>
    </thead>
	<tbody>
		<?php
        $df_user = 0;
        $df_year = 0;
        $df_day = 0;
        $df_room = 0;
        $df_detail = 0;
        $count_user = 1;
        $count_year = 1;
        $count_day = 1;
        $count_room = 1;
        $count_detail = 1;
        $b_user = "1/";
        $b_year = "1/";
        $b_day = "1/";
        $b_room = "1/";
        $b_detail = "1/";
        $n_user = "";
        $n_year = "";
        $n_day = "";
        $n_room = "";
        $n_detail = "";

        if ($max > 1){
            for ($i=1; $i < $max ; $i++) { 
                if($i == 1){
                    $df_user = $name[$i];
                    $df_year = $year[$i];
                    $df_day = $date[$i];
                    $df_room = $room[$i];
                    $df_detail = $detail[$i];
                }else{
                    if($df_user == $name[$i]){
                        $count_user += 1;
                    }else{
                        $b_user .= $i."/";
                        $n_user .= $count_user."/";
                        $df_user = $name[$i];
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

                    if( $df_day == $date[$i]){
                        $count_day += 1;
                    }else{
                        $b_day .= $i."/";
                        $n_day .= $count_day."/";
                        $df_day = $date[$i];
                        $count_day = 1;
                    }

                    if( $df_room == $room[$i]){
                        $count_room += 1;
                    }else{
                        $b_room .= $i."/";
                        $n_room .= $count_room."/";
                        $df_room = $room[$i];
                        $count_room = 1;
                    }

                    if( $df_detail == $detail[$i]){
                        $count_detail += 1;
                    }else{
                        $b_detail .= $i."/";
                        $n_detail .= $count_detail."/";
                        $df_detail = $detail[$i];
                        $count_detail = 1;
                    }
                }
                if($max-1 == $i){
                    $n_user .= $count_user;
                    $n_year .= $count_year;
                    $n_day .= $count_day;
                    $n_room .= $count_room;
                    $n_detail .= $count_detail;
                }
            }

            $count = 1;
            $c_user = 0;
            $c_year = 0;
            $c_room = 0;
            $c_day = 0;
            $c_detail = 0;
            $arr_buser = explode("/", $b_user);
            $arr_nuser = explode("/", $n_user);
            $arr_byear = explode("/", $b_year);
            $arr_nyear = explode("/", $n_year);
            $arr_broom = explode("/", $b_room);
            $arr_nroom = explode("/", $n_room);
            $arr_bday = explode("/", $b_day);
            $arr_nday = explode("/", $n_day);
            $arr_bdetail = explode("/",$b_detail);
            $arr_ndetail = explode("/", $n_detail);
            for ($i=1; $i < $max ; $i++) { 
                echo "<tr>";
                echo "<td>".$i."</td>";
                if( $i == $arr_buser[$c_user] ){ echo "<td rowspan='".$arr_nuser[$c_user]."'>".$name[$i]."</td>"; $c_user += 1; }
                if( $i == $arr_byear[$c_year] ){ echo "<td rowspan='".$arr_nyear[$c_year]."'>".$year[$i]."</td>"; $c_year += 1;}
                if( $i == $arr_bday[$c_day] ){ echo "<td rowspan='".$arr_nday[$c_day]."'>".$date[$i]."</td>"; $c_day += 1;}
                echo "<td>".$begin[$i]."</td>";
                echo "<td>".$end[$i]."</td>";
                if( $i == $arr_broom[$c_room] ){ echo "<td rowspan='".$arr_nroom[$c_room]."'>".$room[$i]."</td>"; $c_room += 1;}
                if( $i == $arr_bdetail[$c_detail] ){ 
                    if( $detail[$i] == "ยังไม่ได้กรอกเหตุผลการใช้ห้องนอกเวลา" ){
                        echo "<td rowspan='".$arr_ndetail[$c_detail] ."'><font style='color:red'>".$detail[$i]."</font></td>";
                    }else{
                        echo "<td rowspan='".$arr_ndetail[$c_detail]."'>".$detail[$i]."</td>"; 
                    }
                    $c_detail += 1;
                }
                echo "</tr>";
            }
        }else{
            echo "<tr><td colspan='8'  style='text-align: center' > ไม่มีประวัติการใช้ห้องนอกเวลา </td></tr>";
        }
        ?>       
	</tbody>
</table>



