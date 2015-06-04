<!--  content -->
        <div class="col-md-10" >
        	<div class="panel panel-primary" style="margin:2% 0% 1% 0%;">
        		<div class="panel-heading">
        			<h3 class="panel-title"> ตารางการขอใช้ห้องนอกเวลา </h3>
        		</div>
        	    <div class="panel-body">
                    <div calss="row">
                        <div class="table table-responsive">
                            <table class="table  table-bordered " id="overtime_room" style="size:2px;">
                                <thead>
                                    <tr class="info" align="center">
                                        <th> ลำดับ </th>
                                        <th> ชื่อ - นามสกุล </th>
                                        <th> วันที่ </th>
                                        <th> เวลาเริ่ม </th>
                                        <th> เวลาเจบ </th>
                                        <th> ห้อง </th>
                                        <th> รายละเอียด </th>
                                        <th> เครื่องมือ </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $df_user = 0;
                                        $df_date = 0;
                                        $df_timeb = 0;
                                        $df_timee = 0;
                                        $df_room = 0;
                                        $df_detail = 0;
                                        $count_user = 1;
                                        $count_date = 1;
                                        $count_timeb = 1;
                                        $count_timee = 1;
                                        $count_room = 1;
                                        $count_detail = 1;
                                        $b_user = "1/";
                                        $b_date = "1/";
                                        $b_timeb = "1/";
                                        $b_timee = "1/";
                                        $b_room = "1/";
                                        $b_detail = "1/";
                                        $n_user = "";
                                        $n_date = "";
                                        $n_timeb = "";
                                        $n_timee = "";
                                        $n_room = "";
                                        $n_detail = "";
                                        $count = 1;

                                        if (count($result) > 0){
                                            foreach ($result as $row):
                                                if($count == 1){
                                                    $df_user = $row->Name."  ".$row->SName;
                                                    $df_date = $row->Date;
                                                    $df_timeb = $row->Time_Begin;
                                                    $df_timee = $row->Time_End;
                                                    $df_room = $row->Room;
                                                    $df_detail = $row->Detail;
                                                }else{
                                                    if($df_user == $row->Name."  ".$row->SName){
                                                        $count_user += 1;
                                                    }else{
                                                        $b_user .= $count."/";
                                                        $n_user .= $count_user."/";
                                                        $df_user = $row->Name."  ".$row->SName;
                                                        $count_user = 1;
                                                    }

                                                    if($df_date == $row->Date){
                                                        $count_date += 1;
                                                    }else{
                                                        $b_date .= $count."/";
                                                        $n_date .= $count_date."/";
                                                        $df_date = $row->Date;
                                                        $count_date = 1;
                                                    }

                                                    if( $df_timeb == $row->Time_Begin){
                                                        $count_timeb += 1;
                                                    }else{
                                                        $b_timeb .= $count."/";
                                                        $n_timeb .= $count_timeb."/";
                                                        $df_timeb = $row->Time_Begin;
                                                        $count_timeb = 1;
                                                    }

                                                    if( $df_timee == $row->Time_End){
                                                        $count_timee += 1;
                                                    }else{
                                                        $b_timee .= $count."/";
                                                        $n_timee .= $count_timee."/";
                                                        $df_timee = $row->Time_End;
                                                        $count_timee = 1;
                                                    }

                                                    if( $df_room == $row->Room){
                                                        $count_room += 1;
                                                    }else{
                                                        $b_room .= $count."/";
                                                        $n_room .= $count_room."/";
                                                        $df_room = $row->Room;
                                                        $count_room = 1;
                                                    }

                                                    if( $df_detail == $row->Detail){
                                                        $count_detail += 1;
                                                    }else{
                                                        $b_detail .= $count."/";
                                                        $n_detail .= $count_detail."/";
                                                        $df_detail = $row->Detail;
                                                        $count_detail = 1;
                                                    }
                                                }
                                                if(count($result) == $count){
                                                    $n_user .= $count_user;
                                                    $n_date .= $count_date;
                                                    $n_timeb .= $count_timeb;
                                                    $n_timee .= $count_timee;
                                                    $n_room .= $count_room;
                                                    $n_detail .= $count_detail;
                                                }
                                                $count += 1;
                                            endforeach;

                                            $count = 1;
                                            $c_user = 0;
                                            $c_date = 0;
                                            $c_timeb = 0;
                                            $c_timee = 0;
                                            $c_room = 0;
                                            $c_detail = 0;
                                            $arr_buser = explode("/", $b_user);
                                            $arr_nuser = explode("/", $n_user);
                                            $arr_bdate = explode("/", $b_date);
                                            $arr_ndate = explode("/", $n_date);
                                            $arr_btimeb = explode("/", $b_timeb);
                                            $arr_ntimeb = explode("/", $n_timeb);
                                            $arr_btimee = explode("/", $b_timee);
                                            $arr_ntimee = explode("/", $n_timee);
                                            $arr_broom = explode("/", $b_room);
                                            $arr_nroom = explode("/", $n_room);
                                            $arr_bdetail = explode("/", $b_detail);
                                            $arr_ndetail = explode("/", $n_detail);

                                            foreach ($result as $row):
                                                echo "<tr>";
                                                echo "<td>".$count."</td>";
                                                if( $count == $arr_buser[$c_user] ){ echo "<td rowspan='".$arr_nuser[$c_user]."'>".$row->Name." ".$row->SName."</td>"; $c_user += 1; }
                                                if( $count == $arr_bdate[$c_date] ){ echo "<td rowspan='".$arr_ndate[$c_date]."'>".$row->Date."</td>"; $c_date += 1;}
                                                if( $count == $arr_btimeb[$c_timeb] ){ echo "<td rowspan='".$arr_ntimeb[$c_timeb]."'>".$row->Time_Begin."</td>"; $c_timeb += 1;}
                                                if( $count == $arr_btimee[$c_timee] ){ echo "<td rowspan='".$arr_ntimee[$c_timee]."'>".$row->Time_End."</td>"; $c_timee += 1;}
                                                if( $count == $arr_broom[$c_room] ){ echo "<td rowspan='".$arr_nroom[$c_room]."'>".$row->Room."</td>"; $c_room += 1;}
                                                if( $count == $arr_bdetail[$c_detail] ){ echo "<td rowspan='".$arr_ndetail[$c_detail]."'>".$row->Detail."</td>"; $c_detail += 1;}
                                                echo "<td align='center'>";
                                                echo "<a id='edit' name=".base64_encode($row->otr_no)."><span style='margin-right:5px;cursor:pointer;' class='glyphicon glyphicon-pencil'></span></a>";
                                                echo "<a id='del' name=".$row->otr_no."><span style='margin-left:5px;margin-right:5px;cursor:pointer;' class='glyphicon glyphicon-trash'></span></a>";
                                                echo "</td>";
                                                echo "</tr>";
                                                $count += 1;
                                            endforeach;
                                        }else{
                                            echo "<tr><td colspan='8' style='text-align: center' > หาข้อมูลไม่พบ </td></tr>";
                                        }                    
                                    ?>                                                                   
                                </tbody>

                            </table>
                            <input type="hidden" name="url" value="<?php echo base_url();?>">
                            <div class="modal fade" id="dl_modal">
                                <div class="modal-dialog modal-sm " style="margin-top:10%">
                                    <div class="modal-content">
                                        <div class="modal-header modal-header-primary" >
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h5> คุณต้องการลบข้อมูลนี้ ? </h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success btn-sm btn-yes" data-dismiss="modal"> ตกลง </button>
                                            <button type="button" class="btn btn-danger btn-sm btn-no" data-dismiss="modal"> ยกเลิก </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                    
<script type="text/javascript">

    $(document).ready(function(){
        var number = 0;

        $("a#del").click(function(){
            $('#dl_modal').modal('show');
            number = $(this).attr('name');
        });

        $("a#edit").click(function(){
            number = $(this).attr('name');
            location.href = ($("input[name='url']").val()+"overtime_room_controller/view_edit/?id="+number);
        });

        $(".btn-yes").click(function(){
            $.ajax({
                url : $("input[name='url']").val()+"overtime_room_controller/delete",
                type : 'post',
                data : {no : number},
                success : function(rs){
                    window.location.href = $("input[name='url']").val()+"overtime_room_controller/view_show"; 
                }        
            });      
        });
    }); 
</script>