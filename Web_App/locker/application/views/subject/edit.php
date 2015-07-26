<div class="col-md-10" >
	<div class="panel panel-primary" style="margin:2% 0% 1% 0%;">
		<div class="panel-heading">
			<h3 class="panel-title"> แก้ไข </h3>
		</div>
	    <div class="panel-body">
	    	<div class="table table-responsive">
                <div class="alert-warning"></div>
				<table class="table table-bordered table-edit">
						<tbody>
							<tr>
                                <td>  รหัสวิชา 
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" id="txt-id" size="17px" value="<?php echo $Id;?>" style='padding:0px 7px 0px 7px'> 
                                </td>                       
                            </tr>
                            <tr>
                                <td>  ชื่อวิชา 
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" id="txt-name" size="17px" value="<?php echo $Name;?>" style='padding:0px 7px 0px 7px'></td>                       
                            </tr>
                            <tr>
                                <td>  จำนวนชั่วโมงที่สอน 
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="text" id="txt-hours" size="8px" value="<?php echo $Hours;?>" style='padding:0px 7px 0px 7px'></td>                       
                            </tr> 
                            <tr>
                                <td>  ไม่จำเป็นต้องเข้าสอน 
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" id="chk" style='padding:0px 7px 0px 7px' <?php if($Level == 1){ echo "checked";}else{}?>></td>                       
                            </tr> 
                            <tr>                       
                                <td>
                                    <button type="button" class="btn btn-warning btn-save"  style="margin-left:20px;">
                                    บันทึก
                                    </button>
                                    <button type="button" class="btn btn-default btn-back" style="margin-left:20px;">
                                     &nbsp;&nbsp;ยกเลิก&nbsp;&nbsp;
                                    </button>
                                </td>                       
                            </tr>
						</tbody>
				</table>
                    <input type="hidden" name="url" value="<?php echo base_url(); ?>subject_controller/">
                    <input type="hidden" name="id_before" value="<?php echo $Id; ?>">
                     <input type="hidden" name="name_before" value="<?php echo $Name; ?>">
                    <form id="f-back" method="post" action="<?php echo base_url();?>subject_controller/view_show">
                        <input type="hidden" name="detail" value="<?php echo $detail;?>">
                        <input type="hidden" name="st" value="back">
                    </form>
    		</div>
	    </div>
	</div>
</div>
<!-- end content -->
</div></div>


<script type="text/javascript">
	$(document).ready(function(){
        var level = 0;

		$("#txt-id,#txt-hours").bind('keypress', function(e) {
            return (e.which != 8 && e.which != 0 && e.which != 46 &&  (e.which < 48 || e.which > 57)) ? false : true;
        });

	    $(".btn-back").click(function(){
	    	$("#f-back").submit();
	    });

	    	
    	$(".btn-save").click(function() {
            if ( ($("#txt-id").val() == "") || ($("#txt-name").val() == "") || ($("#txt-hours").val() == "") ) {
                $(".alert-warning").html("<p class='alert alert-danger role='alert'>กรุณากรอกข้อมูลให้ครบ</p>");
            } else {
                if($("#chk").prop("checked")){
                    level = 1;
                }else{
                    level = 0;
                }
                $.ajax({
                    url: $("input[name='url']").val()+"edit", 
                    type: "post",
                    data: {
                        id_before: $("input[name='id_before']").val(),
                        name_before: $("input[name='name_before']").val(),
                    	id: $("#txt-id").val(),
                        name: $("#txt-name").val(),
                        hours: $("#txt-hours").val(),
                        level: level
                    },
                    success: function(result) {
                      var str = result.split("\n");
                        if (str[0] != "คุณกรอกข้อมูลไม่ถูกต้องหรือมีในระบบอยู่แล้ว") {
                            $("#f-back").submit();
                        } else {
                            $(".alert-warning").html("<p class='alert alert-danger role='alert'>"+str[0]+"</p>");
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