<div class="col-md-10" >
	<div class="panel panel-primary" style="margin:2% 0% 1% 0%;">
		<div class="panel-heading">
			<h3 class="panel-title"> เพิ่มกำหนดวันเริ่ม-จบ </h3>
		</div>
	    <div class="panel-body">
	    	<div class="table table-responsive">
            <div class="alert-warning"></div>
				<table class="table table-bordered table-adds">
						<tbody> 
                        <tr>
                            <td> ปีการศึกษา &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             <input type="text" id="txt-year" name="txt" maxlength="0" style="padding:0px 7px 0px 7px" size="12" disabled></td>
                        </tr>
                        <tr>
                            <td> เทอม &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             <select id="term">
                                 <option value="1">1</option>
                                 <option value="2">2</option>
                                 <option value="3">3</option>
                             </select>
                        </tr>
                        <tr>
                            <td> เริ่มวันที่ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" id="txt-date_s" name="txt" maxlength="0" style="padding:0px 7px 0px 7px" size="12"></td>
                        </tr>
                        <tr>
                            <td> จบวันที่ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" id="txt-date_e" name="txt" maxlength="0" style="padding:0px 7px 0px 7px" size="12"></td>
                        </tr>
                        <tr>
                            <td> เริ่มวันที่สอบ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" id="txt-date_s_exam" name="txt" maxlength="0" style="padding:0px 7px 0px 7px" size="12"></td>
                        </tr>
                        <tr>
                            <td> จบวันที่สอบ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" id="txt-date_e_exam" name="txt" maxlength="0" style="padding:0px 7px 0px 7px" size="12"></td>
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
    		</div>
	    </div>
	</div>
</div>
<!-- end content -->
</div></div>

<script type="text/javascript">
	$(document).ready(function(){
        /// minDate: new Date($('#txt-date_s').val())
        $("#txt-date_s").datepicker({
            dateFormat: 'yy-mm-dd',
            //minDate: new Date(),
            onClose: function() {
                $("#txt-date_e,#txt-date_s_exam,#txt-date_e_exam").datepicker(
                    "change",
                    { minDate: new Date($('#txt-date_s').val()) }
                );
            }
        });

        $("#txt-date_e").datepicker({
            dateFormat: 'yy-mm-dd',
            onClose: function() {
                $("#txt-date_s_exam,#txt-date_e_exam").datepicker(
                    "change",
                   { maxDate: new Date($('#txt-date_e').val()) }
                );
            }
        });

        $("#txt-date_s_exam").datepicker({
            dateFormat: 'yy-mm-dd',
            onClose: function() {
                $("#txt-date_e_exam").datepicker(
                    "change",
                   { minDate: new Date($('#txt-date_s_exam').val()) }
                );
            }
        });

        $("#txt-date_e_exam").datepicker({
            dateFormat: 'yy-mm-dd'
        });

        $("#txt-date_s").change(function(){
            var arr = $("#txt-date_s").val().split("-");
            $("#txt-year").val(parseInt(arr[0])+543);
        });

        $(".btn-clear").click(function(){
            $("input[name='txt']").val("");
            $('#term option')[0].selected = true;
            $(".alert-warning").html("");
        });

    	$(".btn-save").click(function() {
            if( $("#txt-date_s").val() == "" || $("#txt-date_e").val() == "" || $("#txt-date_s_exam").val() == "" || $("#txt-date_e_exam").val()== "" ){
                //alert("กรุณากรอกข้อมูลให้ครบ");
                $(".alert-warning").html("<p class='alert alert-danger role='alert'>กรุณากรอกข้อมูลให้ครบ</p>");
            }else{
                $(".alert-warning").html("");
                $.ajax({
                    url: $("input[name='url']").val()+"config_controller/add_setdate", 
                    type: "post",
                    data: {
                        year : $("#txt-year").val(),
                        term : $("#term :selected").val(),
                        sdate : $("#txt-date_s").val(),
                        edate : $("#txt-date_e").val(),
                        sexamdate : $("#txt-date_s_exam").val(),
                        eexamdate : $("#txt-date_e_exam").val()
                    },
                    success : function(rs){
                       if(rs == "บันทึกข้อมูลเรียบร้อย"){
                            $(".alert-warning").html("<p class='alert alert-success role='alert'><span class='glyphicon glyphicon-ok'></span>"+rs+"</p>");
                            window.location.href = $("input[name='url']").val()+"config_controller/view_show";
                        }else{
                            $(".alert-warning").html("<p class='alert alert-danger role='alert'>"+rs+"</p>");
                        }
                    },
                    error: function(jqXHR) {
                        //alert(jqXHR.status);
                    }
                });
            }
        
        });
	});
</script>