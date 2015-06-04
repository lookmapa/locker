<?php $row = $result->row() ?>
<div class="col-md-10" >
	<div class="panel panel-primary" style="margin:2% 0% 1% 0%;">
		<div class="panel-heading">
			<h3 class="panel-title"> แก้ไข </h3>
		</div>
	    <div class="panel-body">
	    	<div class="table table-responsive">
				<table class="table table-bordered table-edit">
						<tbody>
							<tr>    
                            <td> ปีการศึกษา 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	<div class="btn-group btn-group-sm">
										<a class="btn dropdown-toggle btn-default btn-year" data-toggle="dropdown" href="#" ><?php echo $row->Year; ?><span class="caret" style="margin-left:10px"></span></a>
											<ul class="dropdown-menu btn-year" style=" height: 120px;overflow: auto;">
												<?php $today = getdate(); for($i = $today["year"]+548; $i > $today["year"]+538; $i--){
											echo "<li style='cursor:pointer'><a>$i</a></li>";
											} ?>
											</ul>
								</div>
                            	&nbsp;&nbsp;<label id="lb1" name="lb"></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                เทอม &nbsp;&nbsp;                      
                                	<div class="btn-group btn-group-sm">
											<a class="btn dropdown-toggle btn-default btn-term" data-toggle="dropdown" href="#" ><?php echo $row->Term; ?><span class="caret" style="margin-left:10px"></span></a>
												<ul class="dropdown-menu btn-term" >
    												<li style='cursor:pointer'><a>1</a></li>
    												<li style='cursor:pointer'><a>2</a></li>
    												<li style='cursor:pointer'><a>3</a></li>
												</ul>
									</div>
                                &nbsp;&nbsp;<label id="lb2" name="lb"></label>
                            </td>
                        </tr> 
                        <tr>    
                            <td>  วัน 
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio"  name="day" value="จันทร์" <?php if($row->Day == "จันทร์"){ echo "checked";}?> >&nbsp; จ.
                                <input type="radio"  name="day" value="อังคาร" <?php if($row->Day == "อังคาร"){ echo "checked";}?> >&nbsp; อ.
                                <input type="radio"  name="day" value="พุธ" <?php if($row->Day == "พุธ"){ echo "checked";}?> >&nbsp; พ.
                                <input type="radio"  name="day" value="พฤหัสบดี" <?php if($row->Day == "พฤหัสบดี"){ echo "checked";}?> >&nbsp; พฤ.
                                <input type="radio"  name="day" value="ศุกร์" <?php if($row->Day == "ศุกร์"){ echo "checked";}?> >&nbsp; ศ.
                                &nbsp;&nbsp;<label id="lb3" name="lb"></label>
                            </td>
                        </tr> 
                        <tr> 
                            <td> เวลาเริ่ม 
                               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                        
                               <input type="text" id="txt-timeF" name="txt-timeF" size="8px" value="<?php echo $row->Time_Begin?>" style="padding:0px 7px 0px 7px"> &nbsp;&nbsp;&nbsp;&nbsp; 
                                เวลาจบ &nbsp;
                                <input type="text" id="txt-timeE" name="txt-timeE"  size="8px" value="<?php echo $row->Time_End?>" style="padding:0px 7px 0px 7px" disabled>
                                &nbsp;&nbsp;<label id="lb4" name="lb"></label>
                            </td>
                        </tr>
                        <tr>
                            <td >  รหัสวิชา/ชื่อวิชา 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             <input type="text" id="txt-name" name="txt-name" size="17px" value="<?php echo $row->Id."/".$row->Sj_Name; ?>" style="padding:0px 7px 0px 7px"> &nbsp;&nbsp;<label id="lb5" name="lb"></label></td>
                        </tr>
                        <tr>
                            <td>  ชื่ออาจารย์ 
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="btn-group btn-group-sm" >
                                    <a class="btn dropdown-toggle btn-default btn-user" data-toggle="dropdown" href="#" style="width:150px"><?php echo $row->Name." ".$row->SName?><span class="caret" style="margin-left:10px"></span></a>
                                        <ul class="dropdown-menu btn-user" style=" height: 120px;overflow: auto;">
                                            <?php foreach ($user as $u):?>
                                                <li style='cursor:pointer'>
                                                    <a><?php echo $u->Name." ".$u->SName;?>
                                                    <input type="hidden" id="no" value="<?php echo $u->No;?>"></a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                </div>&nbsp;&nbsp;<label id="lb6" name="lb"></label>
                            </td>
                        </tr>
                        <tr>
                            <td>  กลุ่ม 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             <input type="text" id="txt-group" size="8px" value="<?php echo $row->Group; ?>" style="padding:0px 7px 0px 7px"> &nbsp;&nbsp;<label id="lb7" name="lb"></label></td>                       
                        </tr>
                        <tr>
                            <td>  ตึก 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             <input type="text" id="txt-town" size="8px" value="<?php echo $row->Town; ?>" style="padding:0px 7px 0px 7px"> &nbsp;&nbsp;<label id="lb8" name="lb"></label></td>                       
                        </tr>
                        <tr>
                            <td>  ห้อง 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             <input type="text" id="txt-room" size="8px" value="<?php echo $row->Room; ?>" style="padding:0px 7px 0px 7px"> &nbsp;&nbsp;<label id="lb9" name="lb"></label> </td>                       
                        </tr> 
                        <tr>                       
                            <td>
                            	<button type="button" class="btn btn-warning btn-save"  style="margin-left:20px;">
                                    <span class="glyphicon glyphicon-save"></span> บันทึก
                                </button>
                                <button type="button" class="btn btn-default btn-back" style="margin-left:20px;">
									 &nbsp;&nbsp;ยกเลิก&nbsp;&nbsp;
                                </button>
                                <input type="hidden" name="url" value="<?php echo base_url();?>">
                                <input type="hidden" id="no_edit" value="<?php echo $row->Sjt_No;?>">
                                <input type="hidden" id="value" value="<?php echo $row->No_account;?>">

                                <input type="hidden" id="b_no_account" value="<?php echo $row->No_account; ?>">
                                <input type="hidden" id="b_no_subject" value="<?php echo $row->No_subject; ?>">
                                <input type="hidden" id="b_year" value="<?php echo $row->Year; ?>">
                                <input type="hidden" id="b_term" value="<?php echo $row->Term; ?>">
                                <input type="hidden" id="b_day" value="<?php echo $row->Day; ?>">
                                <input type="hidden" id="b_time_b" value="<?php echo $row->Time_Begin; ?>">
                                <input type="hidden" id="b_time_e" value="<?php echo $row->Time_End; ?>">
                                <input type="hidden" id="b_group" value="<?php echo $row->Group; ?>">
                                <input type="hidden" id="b_town" value="<?php echo $row->Town; ?>">
                                <input type="hidden" id="b_room" value="<?php echo $row->Room; ?>">
                                </td>                       
                        </tr>
						</tbody>
				</table>
					<form id="f-back" method="post" action="<?php echo base_url();?>subject_table_controller/view_show">
						<input type="hidden" name="fback-no_account" value="<?php echo $row->No_account; ?>">
                        <input type="hidden" name="fback-user" value="<?php echo $row->Name." ".$row->SName; ?>">
                        <input type="hidden" name="fback-year" value="<?php echo $row->Year; ?>">
                        <input type="hidden" name="fback-term" value="<?php echo $row->Term; ?>">
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
        var time = ["8.00","9.00","10.00","11.00","13.00","14.00","15.00","16.00","17.00","18.00","19.00","20.00","21.00"];
        var subject = [];
        var hr = [];
        var no = [];
        
        $.ajax({
                url: $("input[name='url']").val()+"subject_controller/list_subject",
                type: "get",
                success: function(rs) {
                    var str = rs.split(",");
                    for(var i=0; i<=str.length-2;i++){
                        var str1 = str[i].split("-");
                        no[i] = str1[0];
                        subject[i] = str1[1];
                        hr[i] = str1[2];
                    }
                }
        });

		$("#txt-group,#txt-timeF,#txt-timeE").bind('keypress', function(e) {
            return (e.which != 8 && e.which != 0 && e.which != 46 &&  (e.which < 48 || e.which > 57)) ? false : true;
        });

        $(".table-edit").on("click","#txt-name",function(){
            $(this).autocomplete({
                source: subject
            });
        });

        $(".table-edit").on("click","#txt-timeF",function(){
            $(this).autocomplete({
                source: time
            });
        });

	    $(".btn-year").on("click", "li", function() {
	        $("a.btn-year").html($(this).text()+'<span class="caret" style="margin-left:10px"></span>');   
	    });

	    $(".btn-term").on("click", "li", function() {
	        $("a.btn-term").html($(this).text()+'<span class="caret" style="margin-left:10px"></span>');   
	    });

        $(".btn-user").on("click", "li", function() {
            $("a.btn-user").html($(this).text()+'<span class="caret" style="margin-left:10px"></span>');
            $("#value").val($("#no",this).val());
        });

	    $(".btn-back").click(function(){
	    	$("#f-back").submit();
	    });

	    $(".table-edit").on("focusout","#txt-timeF",function(){
            if( 
                $('input[name=txt-timeF]').val() == 8 || $('input[name=txt-timeF]').val() == 9 || $('input[name=txt-timeF]').val() == 10 ||
                $('input[name=txt-timeF]').val() == 13 || $('input[name=txt-timeF]').val() == 14 || $('input[name=txt-timeF]').val() == 15 ||
                $('input[name=txt-timeF]').val() == 17 || $('input[name=txt-timeF]').val() == 18 || $('input[name=txt-timeF]').val() == 19  || $('input[name=txt-timeF]').val() == 20
            ){
                if( $('input[name=txt-name]').val() != "" ){
                    $('input[name=txt-timeE]').val((parseFloat(($('input[name=txt-timeF]').val()))+parseFloat(hr[(subject.indexOf($('input[name=txt-name]').val()))]))+".00");
                }               
            }else{
                $('input[name=txt-timeF]').val("");
            }
        });

        $(".table-edit").on("focusout","#txt-name",function(){
            var count = 0;
            for(var i=0; i<= subject.length-1; i++){
                if(subject[i] == $('input[name=txt-name]').val()){
                    count += 1;
                    break;
                }
            }
            if( count > 0 ){
                if( $('input[name=txt-timeF]').val() != "" ){
                    $('input[name=txt-timeE]').val((parseFloat(($('input[name=txt-timeF]').val()))+parseFloat(hr[(subject.indexOf($('input[name=txt-name]').val()))]))+".00");
                }
            }else{
                $('input[name=txt-name]').val("");
            }
        });

    	$(".btn-save").click(function() {
            if(
                $("#txt-timeF").val() == "" || $("#txt-timeE").val()== "" || $("#txt-name").val()== "" || 
                $("#txt-group").val() == "" || $("#txt-town").val() == "" || $("#txt-room").val() == ""
            ){
                alert("กรุณากรอกข้อมูลให้ครบ");
            } else {
                $("label[name='lb']").html("");
                $.ajax({
                    url: $("input[name='url']").val()+"subject_table_controller/edit", 
                    type: "post",
                    data: {
                        no_edit : $("#no_edit").val(),
                    	no_account : $("#value").val(),
                        no_subject : no[subject.indexOf($("#txt-name").val())],
                        year: $("a.btn-year").text(),
                        term: $("a.btn-term").text(),
                        day: $("input[name='day']:checked").val(),
                        time_b: $("#txt-timeF").val(),
                        time_e: $("#txt-timeE").val(),
                        group: $("#txt-group").val(),
                        town: $("#txt-town").val(),
                        room: $("#txt-room").val(),
                        b_no_account : $("#b_no_account").val(),
                        b_no_subject : $("#b_no_subject").val(),
                        b_year: $("#b_year").val(),
                        b_term: $("#b_term").val(),
                        b_day: $("#b_day").val(),
                        b_time_b: $("#b_time_b").val(),
                        b_time_e: $("#b_time_e").val(),
                        b_group: $("#b_group").val(),
                        b_town: $("#b_town").val(),
                        b_room: $("#b_room").val()
                    },
                    success: function(rs) {
                        if( rs == "group or subject" ){
                            $("#lb5,#lb7").html("X").css({"color": "red", "font-size": "13px"});
                        }else if(rs == "time"){
                            $("#lb4").html("X").css({"color": "red", "font-size": "13px"});
                        }else if( rs == "user" ){
                            $("#lb6").html("ผู้ใช้คนนี้ได้ทำการลงทะเบียน วัน เวลานี้แล้ว").css({"color": "red", "font-size": "13px"});
                        }else{
                            alert(rs);
                            window.location.href = $("input[name='url']").val()+"subject_table_controller/view_show";
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