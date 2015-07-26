        <?php $row = $result->row();?>
        <div class="col-md-10" >
        	<div class="panel panel-primary" style="margin:2% 0% 1% 0%;">
        		<div class="panel-heading">
        			<h3 class="panel-title"> แก้ไขการขอใช้ห้อง </h3>
        		</div>
        	    <div class="panel-body">
        	    	<div class="table table-responsive">
                    <div class="alert-warning"></div>
        				<table class="table table-bordered table-adds">
        						<tbody> 
                                <tr>
                                    <td>  ชื่ออาจารย์  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
                                        <div class="btn-group btn-group-sm" >
                                            <a class="btn dropdown-toggle btn-default btn-user" data-toggle="dropdown" href="#" style="width:150px">
                                            <?php foreach ($user as $u1):?>
                                                <?php if( $row->No_account == $u1->No){ echo $u1->Name." ".$u1->SName; } ?>
                                            <?php endforeach; ?>
                                            <span class="caret" style="margin-left:10px"></span></a>
                                                <ul class="dropdown-menu btn-user" style=" height: 120px;overflow: auto;">
                                                    <?php foreach ($user as $u):?>
                                                        <li style='cursor:pointer'>
                                                            <a><?php echo $u->Name." ".$u->SName;?>
                                                            <input type="hidden" id="no" value="<?php echo $u->No;?>"></a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td> วันที่ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                     <input type="text" id="txt-date" name="txt" maxlength="0" style="padding:0px 7px 0px 7px" value="<?php echo $row->Date;?>"></td>
                                </tr>
                                <tr>
                                    <td> เวลาเริ่ม &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                     <input type="text" id="txt-timeF" name="txt" size="12" maxlength="0" style="padding:0px 7px 0px 7px" value="<?php echo $row->Time_Begin;?>"> &nbsp;&nbsp;&nbsp;

                                     เวลาจบ &nbsp;&nbsp;&nbsp;
                                    <input type="text" id="txt-timeE" name="txt" size="12" maxlength="0" style="padding:0px 7px 0px 7px" value="<?php echo $row->Time_End;?>"> </td>
                                </tr>
                                <tr>
                                    <td> ห้อง &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" id="txt-room" name="txt" style="padding:0px 7px 0px 7px" value="<?php echo $row->Room;?>"> </td>
                                </tr>
                                <tr>
                                    <td> เหตุผลการใช้ห้อง &nbsp;&nbsp;&nbsp; 
                                     <input type="text" id="txt-detail" name="txt" style="padding:0px 7px 0px 7px" value="<?php echo $row->Detail;?>"> </td>
                                </tr>
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-save btn-sm"  >
                                            <span class="glyphicon glyphicon-save"></span> บันทึก
                                        </button>&nbsp;&nbsp;&nbsp; 
                                        <button type="button" class="btn btn-default btn-back btn-sm"  >
                                            &nbsp;&nbsp;ยกเลิก&nbsp;&nbsp;
                                        </button>  
                                    </td>
                                </tr>
        						</tbody>
        				</table>
                        <input type="hidden" name="url" value="<?php echo base_url();?>">
                        <input type="hidden" id="value" value="<?php echo $row->No_account;?>">
                        <input type="hidden" id="b_no" value="<?php echo $row->No;?>">
                        <input type="hidden" id="b_no_account" value="<?php echo $row->No_account;?>" >
                        <input type="hidden" id="b_date" value="<?php echo $row->Date;?>" >
                        <input type="hidden" id="b_time_f" value="<?php echo $row->Time_Begin;?>" >
                        <input type="hidden" id="b_time_e" value="<?php echo $row->Time_End;?>" >
                        <input type="hidden" id="b_room" value="<?php echo $row->Room;?>" >
            		</div>
        	    </div>
        	</div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
        
        $("#txt-room").bind('keypress', function(e) {
            return ((e.which < 48 || e.which > 57)) ? false : true;
        });

        $("#txt-date").datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: 0
        });

        $("#txt-timeF").timepicker({
            timeFormat: "HH:mm"
        });

        $("#txt-timeE").timepicker({
            timeFormat: "HH:mm"
        });

        $(".btn-user").on("click", "li", function() {
            $("a.btn-user").html($(this).text()+'<span class="caret" style="margin-left:10px"></span>');
            $("#value").val($("#no",this).val());
        });

        $(".btn-back").click(function(){
            window.location.href = $("input[name='url']").val()+"overtime_room_controller/view_show";
        });
        
    	$(".btn-save").click(function() {
            if( $("#value").val() == 0 ){
               // alert("กรุณาเลือกอาจารย์");
               $(".alert-warning").html("<p class='alert alert-danger role='alert'>กรุณาเลือกอาจารย์</p>");
            } else {
                if(
                    $("#txt-timeF").val() == "" || $("#txt-timeE").val()== "" || $("#txt-date").val()== "" || 
                    $("#txt-room").val() == "" || $("#txt-detail").val() == "" 
                ){
                    //alert("กรุณากรอกข้อมูลให้ครบ");
                $(".alert-warning").html("<p class='alert alert-danger role='alert'>กรุณากรอกข้อมูลให้ครบ</p>");
                }else{
                    var time_f = $("#txt-timeF").val().split(":");
                    var time_e = $("#txt-timeE").val().split(":");
                    var stime = time_f[0]+"."+time_f[1];
                    var etime = time_e[0]+"."+time_e[1];
                    if( parseFloat(etime) > parseFloat(stime)){
                        $.ajax({
                            url: $("input[name='url']").val()+"overtime_room_controller/edit", 
                            type: "post",
                            async:false,
                            data: {
                                no: $("#b_no").val(),
                                no_account : $("#value").val(),
                                date : $("#txt-date").val(),
                                time_f: $("#txt-timeF").val(),
                                time_e: $("#txt-timeE").val(),
                                room : $("#txt-room").val(),
                                detail : $("#txt-detail").val(),
                                b_no_account : $("#b_no_account").val(),
                                b_date : $("#b_date").val(),
                                b_time_f : $("#b_time_f").val(),
                                b_time_e : $("#b_time_e").val(),
                                b_room : $("#b_room").val()
                            },
                            success : function(rs){
                                if(rs == "บันทึกข้อมูลเรียบร้อย"){
                                    $(".alert-warning").html("<p class='alert alert-success role='alert'><span class='glyphicon glyphicon-ok'></span>"+rs+"</p>");
                                    window.location.href = $("input[name='url']").val()+"overtime_room_controller/view_show"; 
                                }else{
                                    $(".alert-warning").html("<p class='alert alert-danger role='alert'>"+rs+"</p>");
                                }
                            },
                            error: function(jqXHR) {
                                alert(jqXHR.status);
                            }
                        });
                    }else{
                        $(".alert-warning").html("<p class='alert alert-danger role='alert'>คุณกรอกเวลาไม่ถูกต้อง กรุณากรอกใหม่อีกรอบ เวลาเริ่ม < เวลาจบ</p>");
                        //alert("คุณกรอกเวลาไม่ถูกต้อง กรุณากรอกใหม่อีกรอบ เวลาเริ่ม < เวลาจบ");
                    }
                }
            
            }
        });
	});
</script>