        <div class="col-md-10" >
        	<div class="panel panel-primary" style="margin:2% 0% 1% 0%;">
        		<div class="panel-heading">
        			<h3 class="panel-title"> เพิ่มการขอใช้ห้อง </h3>
        		</div>
        	    <div class="panel-body">
        	    	<div class="table table-responsive">
        				<table class="table table-bordered table-adds">
        						<tbody> 
                                <tr>
                                    <td>  ชื่ออาจารย์  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
                                        <div class="btn-group btn-group-sm" >
                                            <a class="btn dropdown-toggle btn-default btn-user" data-toggle="dropdown" href="#" style="width:150px">เลือกอาจารย์<span class="caret" style="margin-left:10px"></span></a>
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
                                     <input type="text" id="txt-date" name="txt" maxlength="0" style="padding:0px 7px 0px 7px"></td>
                                </tr>
                                <tr>
                                    <td> เวลาเริ่ม &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                     <input type="text" id="txt-timeF" name="txt" size="12" maxlength="0" style="padding:0px 7px 0px 7px"> &nbsp;&nbsp;&nbsp;

                                     เวลาจบ &nbsp;&nbsp;&nbsp;
                                    <input type="text" id="txt-timeE" name="txt" size="12" maxlength="0" style="padding:0px 7px 0px 7px"> </td>
                                </tr>
                                <tr>
                                    <td> ห้อง &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" id="txt-room" name="txt" style="padding:0px 7px 0px 7px"> </td>
                                </tr>
                                <tr>
                                    <td> เหตุผลการใช้ห้อง &nbsp;&nbsp;&nbsp; 
                                     <input type="text" id="txt-detail" name="txt" style="padding:0px 7px 0px 7px"> </td>
                                </tr>
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-save btn-sm"  >
                                            <span class="glyphicon glyphicon-save"></span> บันทึก
                                        </button>&nbsp;&nbsp;&nbsp; 
                                        <button type="button" class="btn btn-warning btn-clear btn-sm"  >
                                            <span class="glyphicon glyphicon-refresh"></span> รีเซ็ต
                                        </button>  
                                    </td>
                                </tr>
        						</tbody>
        				</table>
                        <input type="hidden" name="url" value="<?php echo base_url();?>">
                        <input type="hidden" id="value" value="0">
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

        $(".btn-clear").click(function(){
            $("input[name='txt']").val("");
            $("a.btn-user").html('เลือกอาจารย์<span class="caret" style="margin-left:10px"></span>');
            $("#value").val("0");
        });

    	$(".btn-save").click(function() {
            if( $("#value").val() == 0 ){
                alert("กรุณาเลือกอาจารย์");
            } else {
                if(
                    $("#txt-timeF").val() == "" || $("#txt-timeE").val()== "" || $("#txt-date").val()== "" || 
                    $("#txt-room").val() == "" || $("#txt-detail").val() == "" 
                ){
                    alert("กรุณากรอกข้อมูลให้ครบ");
                }else{
                    var time_f = $("#txt-timeF").val().split(":");
                    var time_e = $("#txt-timeE").val().split(":");
                    var stime = time_f[0]+"."+time_f[1];
                    var etime = time_e[0]+"."+time_e[1];
                    if( parseFloat(etime) > parseFloat(stime)){
                        $.ajax({
                            url: $("input[name='url']").val()+"overtime_room_controller/add", 
                            type: "post",
                            data: {
                                no_account : $("#value").val(),
                                date : $("#txt-date").val(),
                                time_f: $("#txt-timeF").val(),
                                time_e: $("#txt-timeE").val(),
                                room : $("#txt-room").val(),
                                detail : $("#txt-detail").val()

                            },
                            success : function(rs){
                                alert(rs);
                            },
                            error: function(jqXHR) {
                                alert(jqXHR.status);
                            }
                        });
                    }else{
                        alert("คุณกรอกเวลาไม่ถูกต้อง กรุณากรอกใหม่อีกรอบ \n เวลาเริ่ม < เวลาจบ");
                    }
                }
            
            }
        });
	});
</script>