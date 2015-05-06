<!--  content -->
				<div class="col-md-10" >
					<div class="panel panel-primary" style="margin:2% 0% 1% 0%;">
	  					<div class="panel-heading">
	    					<h3 class="panel-title"> เพิ่มรายวิชา </h3>
	  					</div>
	  					<div class="panel-body">
		  					<button class="btn btn-success btn-sm btn-add" ><span class="glyphicon glyphicon-plus" style="margin-right:5px;width:20px"></span>เพิ่มรายวิชา</button></br></br>
	  						<div calss="row">
	  						<div class="table table-responsive">
								<table class="table table-bordered table-add table-striped">
									<thead>
										<tr class="info">
											<th><div id="show">1</div></th>
											<th>รหัสวิชา</th>
											<th>ชื่อวิชา</th>
											<th>จำนวนชั่วโมงที่สอน</th>
											<th>ไม่จำเป็นต้องเข้าสอน</th>
											<th>สถานะ</th>
										</tr>
									</thead>
			  						<tbody>
			  							<tr>
			  								<td><span class="glyphicon glyphicon-trash del" style="cursor:pointer;"></span></td>
			  								<td><input type="text" id="txt-id" name="txt-id1" mytag="1" style='padding:0px 7px 0px 7px' onclick="check();"></td>
			  								<td><input type="text" id="txt-name" name="txt-name1" style='padding:0px 7px 0px 7px'></td>
			  								<td><input type="text" id="txt-hours" name='txt-hours' style='padding:0px 7px 0px 7px' onclick='check();'></td>
			  								<td><input type="checkbox" id="chk" class="chk"></td>
			  								<td><div id="status1" class="status"></div></td>
			  							</tr>			  							
			  						</tbody>
		    					</table>
		    					<input type="hidden" name="url" value="<?php echo base_url();?>">
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

   		var index=1;
		var count=1;

		$(".btn-add").click(function(){
			index = index+1;count = count+1;
			$("#show").html(count);
			$(".table-add tbody").parent()
				.append(
					"<tr>"+
						"<td><span class='glyphicon glyphicon-trash del' style='cursor:pointer;'></span></td>"+
						"<td><input type='text' id='txt-id' name='txt-id"+index+"' mytag='"+index+"' style='padding:0px 7px 0px 7px' onclick='check();'></td>"+
						"<td><input type='text' id='txt-name' name='txt-name"+index+"' style='padding:0px 7px 0px 7px'></td>"+
						"<td><input type='text' id='txt-hours' name='txt-hours' style='padding:0px 7px 0px 7px' onclick='check();'></td>"+
						"<td><input type='checkbox' id='chk' class='chk'></td>"+
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

		$(".btn-clear").click(function(){
			$("#txt-id,#txt-name,#txt-hours").val("");
			$(".status").html("");
			$(".chk").prop( "checked", false );
		});

		$(".btn-save").click(function(){
			$('.table-add > tbody  > tr').each(function() {
				var check = $("#txt-id",this).attr("mytag");
				var level = 0;
				if(
	          		$("#txt-id",this).val() == "" || $("#txt-name",this).val() == "" || $("#txt-hours",this).val()== "" 
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
	          			if($("#chk",this).prop("checked")){
	          				level = 1;
	          			}else{
	          				level = 0;
	          			}
		          		$.ajax({
								url: $("input[name='url']").val()+"subject_controller/add",
								type: "post",
								data: {
									id: $("#txt-id",this).val(),
									name: $("#txt-name",this).val(),
									hours: $("#txt-hours",this).val(),
									level: level
								},
								success: function(data) {
									var str = data.split("\n");
									if (str[0] == "error") {
									    $("#status"+check).html("<span class='glyphicon glyphicon-remove'></span>");
									} else {
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
		});
	});
	
	function check(){
		$("#txt-hours,#txt-id").bind('keypress', function(e) {
        	return (e.which != 8 && e.which != 0 && e.which != 46 &&  (e.which < 48 || e.which > 57)) ? false : true;
    	});
	}

</script>
