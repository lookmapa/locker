                       <div class="table table-responsive">
                			<table class="table table-bordered" style="size:2px;">
                				<tbody>
                					<tr >
                                        <td> Date/Time </td>
                                        <td> 8.00-9.00</td>
                                        <td> 9.00-10.00 </td>
                                        <td> 10.00-11.00 </td>
                                        <td> 11.00-12.00 </td>
                                        <td rowspan="6">  </td>
                                        <td> 13.00-14.00 </td>
                                        <td> 14.00-15.00 </td>
                                        <td> 15.00-16.00 </td>
                                        <td> 16.00-17.00 </td>
                                        <td rowspan="6">  </td>
                                        <td> 17.00-18.00 </td>
                                        <td> 18.00-19.00 </td>
                                        <td> 19.00-20.00 </td>
                                        <td> 20.00-21.00 </td>
                                        <td> 21.00-22.00 </td>
                                    </tr>
                                    <?php if(count($result) > 0){?>
                                    <?php $GLOBALS['duration1'] = 0; $GLOBALS['duration2'] = 0; $GLOBALS['duration3'] = 0; $GLOBALS['count'] = 1; ?>
                                    <tr>
                                        <td> จันทร์</td>
                                        <?php 
                                        foreach ($result as $row): 
                                        if(intval($row->Time_Begin) <= 11){ $GLOBALS['duration1']  = 1;}
                                        elseif(intval($row->Time_Begin) <= 16){ $GLOBALS['duration2'] = 1; }
                                        else{ $GLOBALS['duration3'] = 1; }
                                        endforeach; 
                                        foreach ($result as $row): 
                                        check(intval($row->Time_Begin),intval($row->Time_End),$row,$this->session->userdata("sess_type"));
                                        endforeach;
                                        while ( $GLOBALS['count'] < 4) {
                                            if($GLOBALS['count'] > 2){
                                                echo "<td></td><td></td><td></td><td></td><td></td>";
                                            }else{
                                                echo "<td></td><td></td><td></td><td></td>";
                                            }
                                            $GLOBALS['count'] += 1;
                                        }
                                        ?>
                                    </tr>
                                        <?php }else{ echo "<tr><td> จันทร์</td><td></td><td></td><td></td><td></td> <td></td><td></td><td></td><td></td> <td></td><td></td><td></td><td></td><td></td></tr>";}?>
                                        <?php if(count($result2) > 0){?>
                                        <?php $GLOBALS['duration1'] = 0; $GLOBALS['duration2'] = 0; $GLOBALS['duration3'] = 0; $GLOBALS['count'] = 1; ?>
                                    <tr>
                                        <td> อังคาร</td>
                                        <?php 
                                        foreach ($result2 as $row): 
                                        if(intval($row->Time_Begin) <= 11){ $GLOBALS['duration1']  = 1;}
                                        elseif(intval($row->Time_Begin) <= 16){ $GLOBALS['duration2'] = 1; }
                                        else{ $GLOBALS['duration3'] = 1; }
                                        endforeach; 
                                        foreach ($result2 as $row): 
                                        check(intval($row->Time_Begin),intval($row->Time_End),$row,$this->session->userdata("sess_type"));
                                        endforeach;
                                        while ( $GLOBALS['count'] < 4) {
                                            if($GLOBALS['count'] > 2){
                                                echo "<td></td><td></td><td></td><td></td><td></td>";
                                            }else{
                                                echo "<td></td><td></td><td></td><td></td>";
                                            }
                                            $GLOBALS['count'] += 1;
                                        }
                                        ?>
                                    </tr>
                                        <?php }else{ echo "<tr><td> อังคาร</td><td></td><td></td><td></td><td></td> <td></td><td></td><td></td><td></td> <td></td><td></td><td></td><td></td><td></td></tr>";}?>
                                        <?php if(count($result3) > 0){?>
                                        <?php $GLOBALS['duration1'] = 0; $GLOBALS['duration2'] = 0; $GLOBALS['duration3'] = 0; $GLOBALS['count'] = 1; ?>
                                    <tr>
                                        <td> พุธ</td>
                                        <?php 
                                        foreach ($result3 as $row): 
                                        if(intval($row->Time_Begin) <= 11){ $GLOBALS['duration1']  = 1;}
                                        elseif(intval($row->Time_Begin) <= 16){ $GLOBALS['duration2'] = 1; }
                                        else{ $GLOBALS['duration3'] = 1; }
                                        endforeach; 
                                        foreach ($result3 as $row): 
                                        check(intval($row->Time_Begin),intval($row->Time_End),$row,$this->session->userdata("sess_type"));
                                        endforeach;
                                        while ( $GLOBALS['count'] < 4) {
                                            if($GLOBALS['count'] > 2){
                                                echo "<td></td><td></td><td></td><td></td><td></td>";
                                            }else{
                                                echo "<td></td><td></td><td></td><td></td>";
                                            }
                                            $GLOBALS['count'] += 1;
                                        }
                                        ?>
                                    </tr>
                                        <?php }else{ echo "<tr><td> พุธ</td><td></td><td></td><td></td><td></td> <td></td><td></td><td></td><td></td> <td></td><td></td><td></td><td></td><td></td></tr>";}?>
                                        <?php if(count($result4) > 0){?>
                                        <?php $GLOBALS['duration1'] = 0; $GLOBALS['duration2'] = 0; $GLOBALS['duration3'] = 0; $GLOBALS['count'] = 1; ?>
                                    <tr>
                                        <td> พฤหัสบดี</td>
                                        <?php 
                                        foreach ($result4 as $row): 
                                        if(intval($row->Time_Begin) <= 11){ $GLOBALS['duration1']  = 1;}
                                        elseif(intval($row->Time_Begin) <= 16){ $GLOBALS['duration2'] = 1; }
                                        else{ $GLOBALS['duration3'] = 1; }
                                        endforeach; 
                                        foreach ($result4 as $row): 
                                        check(intval($row->Time_Begin),intval($row->Time_End),$row,$this->session->userdata("sess_type"));
                                        endforeach;
                                        while ( $GLOBALS['count'] < 4) {
                                            if($GLOBALS['count'] > 2){
                                                echo "<td></td><td></td><td></td><td></td><td></td>";
                                            }else{
                                                echo "<td></td><td></td><td></td><td></td>";
                                            }
                                            $GLOBALS['count'] += 1;
                                        }
                                        ?>
                                    </tr>
                                        <?php }else{ echo "<tr><td> พฤหัสบดี</td><td></td><td></td><td></td><td></td> <td></td><td></td><td></td><td></td> <td></td><td></td><td></td><td></td><td></td></tr>";}?>
                                        <?php if(count($result5) > 0){?>
                                        <?php $GLOBALS['duration1'] = 0; $GLOBALS['duration2'] = 0; $GLOBALS['duration3'] = 0; $GLOBALS['count'] = 1; ?>
                                    <tr>
                                        <td> ศุกร์</td>
                                        <?php 
                                        foreach ($result5 as $row): 
                                        if(intval($row->Time_Begin) <= 11){ $GLOBALS['duration1']  = 1;}
                                        elseif(intval($row->Time_Begin) <= 16){ $GLOBALS['duration2'] = 1; }
                                        else{ $GLOBALS['duration3'] = 1; }
                                        endforeach; 
                                        foreach ($result5 as $row): 
                                        check(intval($row->Time_Begin),intval($row->Time_End),$row,$this->session->userdata("sess_type"));
                                        endforeach;
                                        while ( $GLOBALS['count'] < 4) {
                                            if($GLOBALS['count'] > 2){
                                                echo "<td></td><td></td><td></td><td></td><td></td>";
                                            }else{
                                                echo "<td></td><td></td><td></td><td></td>";
                                            }
                                            $GLOBALS['count'] += 1;
                                        }
                                        ?>
                                    </tr>
                                    <?php }else{ echo "<tr><td> ศุกร์</td><td></td><td></td><td></td><td></td> <td></td><td></td><td></td><td></td> <td></td><td></td><td></td><td></td><td></td></tr>";}?>
                                    </td>    
                                    </tr>
                				</tbody>
                			</table>
                            <input type="hidden" name="url" value="<?php echo base_url();?>">
                            <div class="modal fade" id="dl_Modal">
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

<?php
        function check($time_st,$time_en,$row,$type){
            while(true){
               if( $GLOBALS['duration'.$GLOBALS['count']] == 1){
                    if(8 <= $time_st && $time_st <= 11){
                        for($i = 8; $i <= 12; $i++){
                            if($i == $time_st){
                                $i = $time_en;
                                $round = $time_en-$time_st;
                                echo "<td colspan='".$round."' bgcolor='#EEE9E9' align='center'>  ";
                                echo "<label><font color='#000080'>";
                                echo $row->Name."</br>".$row->Group.", ".$row->Room."</br>".$row->Town."</br>";
                                if( $type == "ผู้ดูแลระบบ" ){
                                echo "<a id='edit' name=".base64_encode($row->etc)."><span style='margin-right:5px;cursor:pointer;' class='glyphicon glyphicon-pencil'></span></a>";
                                echo "<a id='del' name=".$row->etc."><span style='margin-left:5px;cursor:pointer;' class='glyphicon glyphicon-remove'></span></a>";
                                }
                                echo "</font></label>";
                                echo "</td>"; 
                            }else{
                                echo "<td></td>";
                            }
                             
                        }
                    }elseif(13 <= $time_st && $time_st <= 16){
                        for($i = 13; $i <= 17; $i++){
                            if($i == $time_st){
                                $i = $time_en;
                                $round = $time_en-$time_st;
                                echo "<td colspan='".$round."' bgcolor='#EEE9E9' align='center'>";
                                echo "<label><font color='#000080'>";
                                echo $row->Name."</br>".$row->Group.", ".$row->Room."</br>".$row->Town."</br>";
                                if( $type == "ผู้ดูแลระบบ" ){
                                echo "<a id='edit' name=".base64_encode($row->etc)."><span style='margin-right:5px;cursor:pointer;' class='glyphicon glyphicon-pencil'></span></a>";
                                echo "<a id='del' name=".$row->etc."><span style='margin-left:5px;cursor:pointer;' class='glyphicon glyphicon-remove'></span></a>";
                                }
                                echo "</font></label>";
                                echo "</td>"; 
                            }else{
                                echo "<td></td>";
                            }
                             
                        }         
                    }else{
                        for($i = 17; $i <= 22; $i++){
                            if($i == $time_st){
                                $i = $time_en;
                                $round = $time_en-$time_st;
                                echo "<td colspan='".$round."' bgcolor='#EEE9E9' align='center'>";
                                echo "<label><font color='#000080'>";
                                echo $row->Name."</br>".$row->Group.", ".$row->Room."</br>".$row->Town."</br>";
                                if( $type == "ผู้ดูแลระบบ" ){
                                echo "<a id='edit' name=".base64_encode($row->etc)."><span style='margin-right:5px;cursor:pointer;' class='glyphicon glyphicon-pencil'></span></a>";
                                echo "<a id='del' name=".$row->etc."><span style='margin-left:5px;cursor:pointer;' class='glyphicon glyphicon-remove'></span></a>";
                                }
                                echo "</font></label>";
                                echo "</td>"; 
                            }else{
                                echo "<td></td>";
                            }
                             
                        }
                    }
                    $GLOBALS['count'] += 1;
                    break;
                }else{
                    if($GLOBALS['count'] > 2){
                        echo "<td></td><td></td><td></td><td></td><td></td>";
                    }else{
                        echo "<td></td><td></td><td></td><td></td>";
                    }
                    $GLOBALS['count'] += 1;
                    
                }
            }
        }           
    ?>
    <script type="text/javascript" >
        $(document).ready(function(){
            var del = 0;
            var edit = 0;

            $("a#del").click(function(){
                $('#dl_Modal').modal('show');
                del = $(this).attr('name');
            });

            $("a#edit").click(function(){
                edit = $(this).attr('name');
                location.href = ($("input[name='url']").val()+"subject_table_controller/view_edit/?id="+edit);
            });

            $(".btn-yes").click(function(){
                $.ajax({
                    url: $("input[name='url']").val()+"subject_table_controller/delete",
                    type: "post",
                    data: {no:del},
                    success : function(){
                        $.ajax({
                            url: $("input[name='url']").val()+"subject_table_controller/list_table",
                            type: "post",
                            data:{
                                no_account:$("#value").val(),
                                year:$("a.btn-year-show").text(),
                                term:$("a.btn-term-show").text()
                            },
                            success : function(rs){
                                $(".content").html(rs);
                            }  
                        });
                    }
                });
            });
        });
    </script>