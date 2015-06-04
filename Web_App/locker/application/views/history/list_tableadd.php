<?php date_default_timezone_set('America/Los_Angeles'); ?>
<table class="table table-bordered  table-historydetail" style="size:2px;">
    <thead>
        <tr class="info">
            <th> ลำดับ </th>
            <th> ชื่อ - นามสกุล </th>
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
        $df_term = 0;
        $df_day = 0;
        $df_room = 0;
        $count_user = 1;
        $count_year = 1;
        $count_day = 1;
        $count_room = 1;
        $b_user = "1/";
        $b_year = "1/";
        $b_day = "1/";
        $b_room = "1/";
        $n_user = "";
        $n_year = "";
        $n_day = "";
        $n_room = "";
        $count = 1;
        if (count($result) > 0){
            foreach ($result as $row):
                $bDate = new DateTime($row->Begin);
                if($count == 1){
                    $df_user = $row->UserName;
                    $df_year = $row->Year;
                    $df_term = $row->Term;
                    $df_day = $bDate->format("d-m-Y");
                    $df_room = $row->Number_Room;
                }else{
                    if($df_user == $row->UserName){
                        $count_user += 1;
                    }else{
                        $count_user = 1;
                    }

                    if($df_year == $row->Year && $df_term == $row->Term){
                        $count_year += 1;
                    }else{
                        $b_year .= $count."/";
                        $n_year .= $count_year."/";
                        $df_year = $row->Year;
                        $df_term = $row->Term;
                        $count_year = 1;
                    }

                    if( $df_day == $bDate->format("d-m-Y")){
                        $count_day += 1;
                    }else{
                        $b_day .= $count."/";
                        $n_day .= $count_day."/";
                        $df_day = $bDate->format("d-m-Y");
                        $count_day = 1;
                    }

                    if( $df_room == $row->Number_Room){
                        $count_room += 1;
                    }else{
                        $b_room .= $count."/";
                        $n_room .= $count_room."/";
                        $df_room = $row->Number_Room;
                        $count_room = 1;
                    }
                }
                if(count($result) == $count){
                    $n_user .= $count_user;
                    $n_year .= $count_year;
                    $n_day .= $count_day;
                    $n_room .= $count_room;
                }
                $count += 1;
            endforeach;
            $count = 1;
            $c_user = 0;
            $c_year = 0;
            $c_room = 0;
            $c_day = 0;
            $arr_buser = explode("/", $b_user);
            $arr_nuser = explode("/", $n_user);
            $arr_byear = explode("/", $b_year);
            $arr_nyear = explode("/", $n_year);
            $arr_broom = explode("/", $b_room);
            $arr_nroom = explode("/", $n_room);
            $arr_bday = explode("/", $b_day);
            $arr_nday = explode("/", $n_day);
            foreach ($result as $row): 
            	$bDate = new DateTime($row->Begin);
            	$eDate = new DateTime($row->End);
            	$datearray = explode("-", $bDate->format("Y-m-d"));
                echo "<tr>";
                echo "<td>".$count."<input type='hidden' id='edit' value='".$row->ht_no."'></td>";
                if( $count == $arr_buser[$c_user] ){ echo "<td rowspan='".$arr_nuser[$c_user]."'>".$row->Name." ".$row->SName."</td>"; $c_user += 1; }
                if( $count == $arr_byear[$c_year] ){ echo "<td rowspan='".$arr_nyear[$c_year]."'>".$row->Term."/".$row->Year."</td>"; $c_year += 1;}
                if( $count == $arr_bday[$c_day] ){ echo "<td rowspan='".$arr_nday[$c_day]."'>".($datearray[0]+543)."-".$bDate->format("m-d")."</td>"; $c_day += 1;}
                echo "<td>".$bDate->format("H:i:s")."</td>";
                echo "<td>".$eDate->format("H:i:s")."</td>";
                if( $count == $arr_broom[$c_room] ){ echo "<td rowspan='".$arr_nroom[$c_room]."'>".$row->Number_Room."</td>"; $c_room += 1;}
                echo "<td><center>";
                echo "<input type='radio' id ='".$count."' name=' ro".$count."' onclick='open_own(this);' value='own' checked>&nbsp;เปิดใช้งานเอง&nbsp;&nbsp;";
                echo "<input type='radio' id ='".$count."' name=' ro".$count."' onclick='open_other(this);' value='other' >&nbsp;เปิดให้คนอื่น";
                echo "<div id='view".$count."'><input type='text' id='txt-detail' style='width:100%;padding-left:7px' ></div>";
                echo "</center></td>";
                echo "</tr>";
                $count += 1;
            endforeach;
        }else{
            echo "<tr><td colspan='8'  style='text-align: center' > ไม่มีประวัติการใช้ห้องนอกเวลา </td></tr>";
        }
        ?>       
	</tbody>
</table>
<?php if( count($result) > 0 ){?>
    <button type="button" class="btn btn-warning btn-save btn-sm"  >
        <span class="glyphicon glyphicon-save"></span> บันทึก
    </button>                           
<?php } ?>
<script type="text/javascript">
    var ac_no = [];
    var ac_name = [];

    $(document).ready(function(){

        $.ajax({
            url: $("input[name='url']").val()+"account_controller/list_account",
            type: "get",
            success: function(rs) {
                var str = rs.split(",");
                for(var i=0; i<=str.length-2;i++){
                    var str1 = str[i].split("/");
                    ac_no[i] = str1[0];
                    ac_name[i] = str1[1];
                }
            }
        });

        $(".btn-save").click(function(){
            var no = "";
            var detail = "";
            var status = "";
            $('.table-historydetail > tbody  > tr').each(function() {
                if( $("input:checked",this).val() == "own"){
                    no += $("#edit",this).val()+"/";
                    status += "own/";
                    detail += $("#txt-detail",this).val()+"/";
                }else{
                    no += $("#edit",this).val()+"/";
                    status += "other/";
                    detail += $("#open_user :selected",this).val()+"/";
                }
            });
            $.ajax({
                url: $("input[name='url']").val()+"history_controller/edit",
                type: "post", 
                data: {
                    user: $("#sel_user :selected").val(),
                    no: no,
                    status : status,
                    detail: detail
                },
                success: function(rs){
                    if( rs.length == 0){
                        alert("บันทึกข้อมูลเรียบร้อย");
                        window.location.href = $("input[name='url']").val()+"history_controller/view_add"; 
                    }else{
                        alert("คุณทำรายการไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง");
                    }
                },
                error: function(jqXHR) {
                    alert(jqXHR.status);
                }
            });
        });
    });

    function open_own(obj){
        var id = obj.id;
        $("#view"+id).html("");
        $("#view"+id).append("<input type='text' id='txt-detail' style='width:100%;padding-left:7px' > ");
    }

    function open_other(obj){
        var id = obj.id;
        var str = "<select id='open_user' class='form-control'>";
        $("#view"+id).html("");
        for (var i = 0; i < ac_no.length; i++) {
            if( $("#sess_id").val() != ac_no[i]){
                str += "<option value='"+ac_no[i]+"'>"+ac_name[i]+"</option>";
            }
        }
        str += "</select>";
        $("#view"+id).append(str);
    }
</script>


