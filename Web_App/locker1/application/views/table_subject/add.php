<!--  content -->
				<div class="col-md-10" >
					<div class="panel panel-primary" style="margin:2% 0% 1% 0%;">
	  					<div class="panel-heading">
	    					<h3 class="panel-title"> เพิ่มตารางสอน </h3>
	  					</div>
	  					<div class="panel-body">
		  					<button class="btn btn-success btn-sm btn-add" ><span class="glyphicon glyphicon-plus" style="margin-right:5px;width:20px"></span>เพิ่มตารางสอน</button></br></br>
	  						<div calss="row">
		                        <div calss="col-md-6">
		                            <div class="btn-group btn-group-sm" style ="margin-bottom:15px">
		                                <a class="btn dropdown-toggle btn-default btn-user-show" data-toggle="dropdown" href="#" style="width:150px">เลือกอาจารย์<span class="caret" style="margin-left:10px"></span></a>
		                                    <ul class="dropdown-menu btn-user-show" style=" height: 120px;overflow: auto;">
		                                        <?php foreach ($user as $row):?>
                                            		<li style='cursor:pointer'>
                                            			<a><?php echo $row->Name." ".$row->SName;?>
                                            			<input type="hidden" id="no" value="<?php echo $row->No;?>"></a>
                                            		</li>
                                        		<?php endforeach; ?>
		                                    </ul>
		                            </div>
		                            <div class="btn-group btn-group-sm " style ="margin-bottom:15px">
		                                <a class="btn dropdown-toggle btn-default btn-year-show" data-toggle="dropdown" href="#" style="width:70px;">เลือกปี<span class="caret" style="margin-left:10px;"></span></a>
		                                    <ul class="dropdown-menu btn-year-show" style=" height: 120px;overflow: auto;">
		                                    	<?php for($i = date("Y")+538; $i<= date("Y")+548; $i++){ ?>
		                                    		<li style='cursor:pointer'><a><?php echo $i; ?></a></li>
		                                    	<?php } ?>
		                                    </ul>
		                            </div>
		                            <div class="btn-group btn-group-sm" style ="margin-bottom:15px">
		                                <a class="btn dropdown-toggle btn-default btn-term-show" data-toggle="dropdown" href="#" style="width:90px;">เลือกเทอม<span class="caret" style="margin-left:10px"></span></a>
		                                    <ul class="dropdown-menu btn-term-show">
		                                    	<li style='cursor:pointer'><a>1</a></li>
		                                    	<li style='cursor:pointer'><a>2</a></li>
		                                    	<li style='cursor:pointer'><a>3</a></li>
		                                    </ul>
		                            </div>
		                        </div>
		                    </div>
	  						<div class="table table-responsive">
								<table class="table table-bordered table-add table-striped">
									<thead>
										<tr class="info">
											<th><div id="show">1</div></th>
											<th>รหัสวิชา/ชื่อวิชา</th>
											<th>กลุ่ม</th>
											<th>วัน</th>
											<th>เวลาเริ่ม</th>
											<th>เวลาจบ</th>
											<th>ตึก</th>
											<th>ห้อง</th>
											<th>สถานะ</th>
										</tr>
									</thead>
			  						<tbody>
			  							<tr>
			  								<td><span class="glyphicon glyphicon-trash del" style="cursor:pointer;"></span></td>
			  								<td><input type="text" id="txt-name" name="txt-name1" size="17px" mytag="1"  style="padding:0px 7px 0px 7px"> &nbsp;<label id="lb11" name="check_lb"></td>
			  								<td><input type="text" id="txt-group" size="4px" style="padding:0px 7px 0px 7px" onclick='check();'> &nbsp;<label id="lb21" name="check_lb"></td>
			  								<td>
			  									<select style="overflow: auto;cursor:pointer;">
			  										<option value="จันทร์">จันทร์</option>
			  										<option vlue="อังคาร">อังคาร</option>
			  										<option value="พุธ">พุธ</option>
			  										<option value="พฤหัสบดี">พฤหัสบดี</option>
			  										<option value="ศุกร์">ศุกร์</option>
			  									</select>&nbsp;<label id="lb31" name="check_lb">
			  								</td>
			  								<td><input type="text" id="txt-timeF" name="txt-timeF1" mytag="1" size="8px" style="padding:0px 7px 0px 7px"> &nbsp;<label id="lb41" name="check_lb"></td>
			  								<td><input type="text" id="txt-timeE"  name="txt-timeE1" size="8px" style="padding:0px 7px 0px 7px" disabled> &nbsp;<label id="lb51" name="check_lb"></td>
			  								<td><input type="text" id="txt-town" size="8px" style="padding:0px 7px 0px 7px" value="<?php echo $this->session->userdata('sess_town');?>"> &nbsp;<label id="lb61" name="check_lb" ></td>
			  								<td><input type="text" id="txt-room" size="8px" style="padding:0px 7px 0px 7px"> &nbsp;<label id="lb71" name="check_lb"></td>
			  								<td><div id="status1" class="status"></div></td>
			  							</tr>			  							
			  						</tbody>
		    					</table>
		    					<input type="hidden" name="url" value="<?php echo base_url();?>">
		    					<input type="hidden" id="default_town" value="<?php echo $this->session->userdata('sess_town');?>">
		    					<input type="hidden" id="value">
							</div>
			    					<button type="button" class="btn btn-warning btn-save btn-sm"  >
	                                    <span class="glyphicon glyphicon-save"></span> บันทึก
	                                </button>&nbsp;&nbsp;&nbsp; 
	                                <button type="button" class="btn btn-warning btn-clear btn-sm"  >
	                                    <span class="glyphicon glyphicon-refresh"></span> รีเซ็ต
	                                </button>                                
                        		</br></br></br><div class="content" ></div>
						</div>
					</div>
				</div>
			<!--  end content -->
			</div>
		</div>
<script type="text/javascript">
	$(document).ready(function(){
		var time = ["8.00","9.00","10.00","11.00","13.00","14.00","15.00","16.00","17.00","18.00","19.00","20.00","21.00"];
   		var subject = [];
   		var hr = [];
   		var no = [];
   		var index=1;
		var count=1;
		
		$.ajax({
                url: $("input[name='url']").val()+"subject_controller/list_subject",
                type: "get",
                async:false,
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

		$(".btn-clear").click(function(){
			$("#txt-name,#txt-group,#txt-timeF,#txt-timeE,#txt-town,#txt-room").val("");
			$(".status").html("");
			$("a.btn-user-show").html('เลือกอาจารย์<span class="caret" style="margin-left:10px"></span>');
			$("a.btn-year-show").html('เลือกปี<span class="caret" style="margin-left:10px"></span>');
			$("a.btn-term-show").html('เลือกเทอม<span class="caret" style="margin-left:10px"></span>');
		});

		$(".btn-add").click(function(){
			index = index+1;count = count+1;
			$("#show").html(count);
			$(".table-add tbody").parent()
				.append(
					"<tr>"+
						"<td><span class='glyphicon glyphicon-trash del' style='cursor:pointer;'></span></td>"+
						"<td><input type='text' id='txt-name' name='txt-name"+index+"' mytag='"+index+"' size='17px' style='padding:0px 7px 0px 7px'> &nbsp;<label id='lb1"+index+"' name='check_lb'></td>"+
						"<td><input type='text' id='txt-group' size='4px' style='padding:0px 7px 0px 7px' onclick='check();'> &nbsp;<label id='lb2"+index+"' name='check_lb'></td>"+
						"<td>"+
							"<select style='overflow: auto;cursor:pointer;'>"+
								"<option value='จันทร์'>จันทร์</option>"+
								"<option vlue='อังคาร'>อังคาร</option>"+
								"<option value='พุธ'>พุธ</option>"+
								"<option value='พฤหัสบดี'>พฤหัสบดี</option>"+
								"<option value='ศุกร์'>ศุกร์</option>"+
			  				"</select> &nbsp;<label id='lb3"+index+"' name='check_lb'>"+
			  			"</td>"+
						"<td><input type='text' id='txt-timeF' name='txt-timeF"+index+"' mytag='"+index+"'  size='8px' style='padding:0px 7px 0px 7px'> &nbsp;<label id='lb4"+index+"' name='check_lb'></td>"+
						"<td><input type='text' id='txt-timeE'  name='txt-timeE"+index+"' size='8px' style='padding:0px 7px 0px 7px' disabled> &nbsp;<label id='lb5"+index+"' name='check_lb'></td>"+
						"<td><input type='text' id='txt-town' size='8px' style='padding:0px 7px 0px 7px' value='"+$("#default_town").val()+"'> &nbsp;<label id='lb6"+index+"' name='check_lb'></td>"+
						"<td><input type='text' id='txt-room' size='8px' style='padding:0px 7px 0px 7px'> &nbsp;<label id='lb7"+index+"' name='check_lb'></td>"+
						"<td><div id='status"+index+"' class='status'></div></td>"+
					"</tr>"
				);
		});

		$( ".table-add" ).on( "click", ".del", function() {
			$(this).parent().parent().remove();
			count = count-1;
			if(count==0){
				$("#show").html("");
			}else{
				$("#show").html(count);
			}
		});

	    $(".table-add").on("click","#txt-name",function(){
			$(this).autocomplete({
	      		source: subject
	    	});
	    });

	    $(".table-add").on("click","#txt-timeF",function(){
			$(this).autocomplete({
	      		source: time
	    	});
	    });

	    $(".table-add").on("focusout","#txt-timeF",function(){
	    	var n = $(this).attr("mytag");
	    	if( 
	    		$('input[name=txt-timeF'+n+']').val() == 8 || $('input[name=txt-timeF'+n+']').val() == 9 || $('input[name=txt-timeF'+n+']').val() == 10 ||
	    		$('input[name=txt-timeF'+n+']').val() == 13 || $('input[name=txt-timeF'+n+']').val() == 14 || $('input[name=txt-timeF'+n+']').val() == 15 ||
	    		$('input[name=txt-timeF'+n+']').val() == 17 || $('input[name=txt-timeF'+n+']').val() == 18 || $('input[name=txt-timeF'+n+']').val() == 19  || $('input[name=txt-timeF'+n+']').val() == 20
	    	){
	    		if( $('input[name=txt-name'+n+']').val() != "" ){
	    			$('input[name=txt-timeE'+n+']').val((parseFloat(($('input[name=txt-timeF'+n+']').val()))+parseFloat(hr[(subject.indexOf($('input[name=txt-name'+n+']').val()))]))+".00");
	    		}	    		
	    	}else{
	    		$('input[name=txt-timeF'+n+']').val("");
	    	}
	    });

	    $(".table-add").on("focusout","#txt-name",function(){
	    	var n = $(this).attr("mytag");
	    	var count = 0;
	    	for(var i=0; i<= subject.length-1; i++){
	    		if(subject[i] == $('input[name=txt-name'+n+']').val()){
	    			count += 1;
	    			break;
	    		}
	    	}
	    	if( count > 0 ){
				if( $('input[name=txt-timeF'+n+']').val() != "" ){
		    		$('input[name=txt-timeE'+n+']').val((parseFloat(($('input[name=txt-timeF'+n+']').val()))+parseFloat(hr[(subject.indexOf($('input[name=txt-name'+n+']').val()))]))+".00");
		    	}
		    }else{
		    	$('input[name=txt-name'+n+']').val("");
		    }
	    });

	    $(".btn-user-show").on("click", "li", function() {
            $("a.btn-user-show").html($(this).text()+'<span class="caret" style="margin-left:10px"></span>');
            $("#value").val($("#no",this).val());
        });

        $(".btn-year-show").on("click", "li", function() {
            $("a.btn-year-show").html($(this).text()+'<span class="caret" style="margin-left:10px"></span>');
        });

        $(".btn-term-show").on("click", "li", function() {
            $("a.btn-term-show").html($(this).text()+'<span class="caret" style="margin-left:10px"></span>');
        });

	    $(".btn-save").click(function(){
	    
		    var str = "";
	        if( $("a.btn-user-show").text() == "เลือกอาจารย์" ){
	          str += "เลือกอาจารย์ ";
	        }
	        if( $("a.btn-year-show").text() == "เลือกปี" ){
	          str += "เลือกปี ";
	        }
	        if( $("a.btn-term-show").text() == "เลือกเทอม" ){
	          str += "เลือกเทอม ";
	        }

	        if( str.length == 0 ){
	            $('.table-add > tbody  > tr').each(function() {
	          	var check = $("#txt-timeF",this).attr("mytag");
	          	var check_no = subject.indexOf($("#txt-name",this).val());
	          	var str = $("#txt-name",this).val().split("/");
	          		if(
	          			$("#txt-name",this).val() == "" || $("#txt-timeF",this).val() == "" || $("#txt-timeE",this).val()== "" || 
	          			$("#txt-group",this).val() == "" || $("#txt-town",this).val() == "" || $("#txt-room",this).val() == ""
	          		){
	          			$("#status"+check).html("<span class='glyphicon glyphicon-remove'></span>");
	          		}else{
	          			if( $("#status"+check+" span").hasClass("glyphicon-ok") ){
	          				$(this).remove();
	          				count = count-1;
								if(count==0){
									$("#show").html("");
								}else{
									$("#show").html(count);
								}
	          			}else{
	          				$("label[name='check_lb']").html("");
		          			$.ajax({
								url: $("input[name='url']").val()+"subject_table_controller/add",
								type: "post",
								async:false,
								data: {
									year: $("a.btn-year-show").text(),
									term: $("a.btn-term-show").text(),
									day: $("select option:selected",this).val(),
									no_account : $("#value").val(),
									no_subject : no[check_no],
									time_b: $("#txt-timeF",this).val(),
									time_e: $("#txt-timeE",this).val(),
									group: $("#txt-group",this).val(),
									town: $("#txt-town",this).val(),
									room: $("#txt-room",this).val()
								},
								success: function(rs) {
									if( rs == "group or subject" ){
                            			$("#lb1"+check).html("X").css({"color": "red", "font-size": "13px"});
                            			$("#lb2"+check).html("X").css({"color": "red", "font-size": "13px"});
                            			$("#status"+check).html("<span class='glyphicon glyphicon-remove'></span>");
                        			}else if(rs == "time"){
                           				$("#lb4"+check).html("X").css({"color": "red", "font-size": "13px"});
                           				$("#lb5"+check).html("X").css({"color": "red", "font-size": "13px"});
                           				$("#status"+check).html("<span class='glyphicon glyphicon-remove'></span>");
                        			}else if( rs == "error" ){
                            			$("#lb1"+check).html("X").css({"color": "red", "font-size": "13px"});
                            			$("#lb2"+check).html("X").css({"color": "red", "font-size": "13px"});
                            			$("#lb3"+check).html("X").css({"color": "red", "font-size": "13px"});
                            			$("#lb4"+check).html("X").css({"color": "red", "font-size": "13px"});
                            			$("#lb5"+check).html("X").css({"color": "red", "font-size": "13px"});
                            			$("#lb6"+check).html("X").css({"color": "red", "font-size": "13px"});
                            			$("#lb7"+check).html("X").css({"color": "red", "font-size": "13px"});
                            			$("#status"+check).html("<span class='glyphicon glyphicon-remove'></span>");
                        			}else if( rs == "pass"){
                        				$("#status"+check).html("<span class='glyphicon glyphicon-ok'></span>");
                        			}
								},
								error: function(jqXHR) {
									alert(jqXHR.status);
								}
		                	});
	                	}
	          		}			
	        	});
				list_table(); 
	        }else{
	        	alert("กรุณา "+str);
	        }   
	    });
		
	});

	function check(){
		$("#txt-group,#txt-timeF,#txt-timeE").bind('keypress', function(e) {
        	return (e.which != 8 && e.which != 0 && e.which != 46 &&  (e.which < 48 || e.which > 57)) ? false : true;
    	});
	}

	function list_table(){
		$.ajax({
				url: $("input[name='url']").val()+"subject_table_controller/list_table",
				type: "post",
				async:false,
				data:{
		            no_account : $("#value").val(),
		            year:$("a.btn-year-show").text(),
		            term:$("a.btn-term-show").text()
				},
				success : function(rs){
					$(".content").html(rs);
				}  
		});		
	}

</script>
<style>
.ui-autocomplete {
    max-height: 150px;
    overflow-y: auto;
    overflow-x: hidden;
    padding-right: 20px;
}
* html .ui-autocomplete {
    height: 100px;
}
</style>