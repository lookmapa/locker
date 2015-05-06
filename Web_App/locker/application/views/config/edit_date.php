        <?php $row = $result->row();?>
        <div class="col-md-10" >
        	<div class="panel panel-primary" style="margin:2% 0% 1% 0%;">
        		<div class="panel-heading">
        			<h3 class="panel-title"> เพิ่มกำหนดวันเริ่ม-จบ </h3>
        		</div>
        	    <div class="panel-body">
        	    	<div class="table table-responsive">
        				<table class="table table-bordered table-adds">
        						<tbody> 
                                <tr>
                                    <td> ปีการศึกษา &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                     <input type="text" id="txt-year" name="txt" maxlength="0" style="padding:0px 7px 0px 7px" size="12" value="<?php echo $row->Year;?>" disabled></td>
                                </tr>
                                <tr>
                                    <td> เทอม &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                     <select id="term">
                                         <option value="1"<?php if($row->Term == "1"){ echo "selected";} ?>>1</option>
                                         <option value="2"<?php if($row->Term == "2"){ echo "selected";} ?>>2</option>
                                         <option value="3"<?php if($row->Term == "3"){ echo "selected";} ?>>3</option>
                                     </select>
                                </tr>
                                <tr>
                                    <td> เริ่มวันที่ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" id="txt-date_s" name="txt" maxlength="0" style="padding:0px 7px 0px 7px" size="12" value="<?php echo $row->sDate;?>"></td>
                                </tr>
                                <tr>
                                    <td> จบวันที่ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" id="txt-date_e" name="txt" maxlength="0" style="padding:0px 7px 0px 7px" size="12" value="<?php echo $row->eDate;?>"></td>
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
                        <input type="hidden" id='b_year' value="<?php echo $row->Year;?>">
                        <input type="hidden" id='b_term' value="<?php echo $row->Term;?>">
                        <input type='hidden' id='no' value="<?php echo $row->No;?>">
            		</div>
        	    </div>
        	</div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){

        $("#txt-date_s").datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: new Date(),
            onClose: function() {
                $("#txt-date_e").datepicker(
                    "change",
                    { minDate: new Date($('#txt-date_s').val()) }
                );
            }
        });

        $("#txt-date_e").datepicker({
            dateFormat: 'yy-mm-dd',
            onClose: function() {
                $("#txt-date_s").datepicker(
                    "change",
                    { minDate: new Date() }
                );
            }
        });

        $("#txt-date_s").change(function(){
            var arr = $("#txt-date_s").val().split("-");
            $("#txt-year").val(parseInt(arr[0])+543);
        });

        $(".btn-back").click(function(){
            window.location.href = $("input[name='url']").val()+"config_controller/view_show";
        });

    	$(".btn-save").click(function() {
            if( $("#txt-date_s").val() == "" || $("#txt-date_e").val()== "" ){
                alert("กรุณากรอกข้อมูลให้ครบ");
            }else{
                $.ajax({
                    url: $("input[name='url']").val()+"config_controller/edit_setdate", 
                    type: "post",
                    data: {
                        no : $("#no").val(),
                        year : $("#txt-year").val(),
                        term : $("#term :selected").val(),
                        sdate : $("#txt-date_s").val(),
                        edate : $("#txt-date_e").val(),
                        b_year : $("#b_year").val(),
                        b_term : $("#b_term").val()
                    },
                    success : function(rs){
                        if(rs.length == 21){
                            alert(rs);
                            window.location.href = $("input[name='url']").val()+"config_controller/view_show";
                        }else{
                            alert(rs);
                        }
                    },
                    error: function(jqXHR) {
                        alert(jqXHR.status);
                    }
                });
            }
        
        });
	});
</script>