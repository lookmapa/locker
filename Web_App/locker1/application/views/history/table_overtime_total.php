<!--  content -->
				<div class="col-md-10" >
					<div class="panel panel-primary" style="margin:2% 0% 1% 0%;">
	  					<div class="panel-heading">
	    					<h3 class="panel-title"> รายงานสรุปการใช้ห้องนอกเวลา </h3>
	  					</div>
	  					<div class="panel-body"></br>
	  						<div class="table table-responsive">
									<label for="sel2">เลือกการสรุป :</label>
								    <select  class="form-control" id="sel" size="3">
								    	<option value="all" selected>เลือกทั้งหมด</option>
								    	<option value="year" >ปีการศึกษา</option>
								    	<option value="term" >ภาคเรียน</option>
								    </select>
									</br>
								<div id="content1"></div></br>
								<div id="content2"></div>
	  						</div>
	  						<input type="hidden" name="url" value="<?php echo base_url();?>">
	  						<input type="hidden" name="privileges" value="<?php echo $this->session->userdata("sess_type")?>">
	  						<input type="hidden" name="" value="<?php echo $this->session->userdata("sess_id")?>">
	  					</div>
					</div>
				</div>
			<!--  end content -->
			</div>
		</div>
<script type="text/javascript">
	$(document).ready(function(){
		var year_max = 0;
		var year_min = 0;

		$.ajax({
			url: $("input[name='url']").val()+"history_controller/list_year?st=history",
			type: "post",
			success: function(rs){
				var data = rs.split("/");
				year_max = data[0];
				year_min = data[1];
			},
			error: function(jqXHR) {
				alert(jqXHR.status);
			}
	    });

		$.ajax({
			url: $("input[name='url']").val()+"history_controller/list_overtimetotal",
			type: "post",
			data: { st:"all" },
			success: function(rs){
				$("#content2").html(rs); 
			},
			error: function(jqXHR) {
				alert(jqXHR.status);
			}
		});

		$("#sel").change(function(){
			if( $("#sel :selected").val() == "all" ){
				$("#content1").html("");
				$.ajax({
					url: $("input[name='url']").val()+"history_controller/list_overtimetotal",
					type: "post",
					data: { st:"all" },
					success: function(rs){
						$("#content2").html(rs); 
					},
					error: function(jqXHR) {
						alert(jqXHR.status);
					}
				});
			}else if( $("#sel :selected").val() == "year" ){
				$.ajax({
					url: $("input[name='url']").val()+"history_controller/list_year?st=history",
					type: "post",
					success: function(rs){
						var data = rs.split("/");
						if( data[0] != ""){
							$("#content1").html("");
							$("#content1").append(
												" ปีการศึกษา  "+
												"<select  id='sel_year' onchange='get_year(this)'>"+
											    "</select>"
											);
							for (var i = year_max; i >= year_min; i--) {
								$("#sel_year").append("<option value='"+i+"'>"+i+"</option>");
							}
						}

						$.ajax({
							url: $("input[name='url']").val()+"history_controller/list_overtimetotal",
							type: "post",
							data: { 
								st:"year",
								year : $("#sel_year :selected").val() 
							},
							success: function(rs){
								$("#content2").html(rs); 
							},
							error: function(jqXHR) {
								alert(jqXHR.status);
							}
						});
					},
					error: function(jqXHR) {
						alert(jqXHR.status);
					}
			    });

			}else if( $("#sel :selected").val() == "term" ){
				$.ajax({
					url: $("input[name='url']").val()+"history_controller/list_year?st=history",
					type: "post",
					success: function(rs){
						var data = rs.split("/");
						if( data[0] != ""){
							$("#content1").html("");
							$("#content1").append(
												" ปีการศึกษา  "+
												"<select  id='sel_year_term' onchange='get_year(this)'>"+
											    "</select>"+
											    "  ภาคเรียน "+
											    "<label id='term1' style='cursor:pointer' onclick='get_term(this)'> 1 </label> /"+
											    " <label id='term2' style='cursor:pointer' onclick='get_term(this)'> 2 </label> /"+
											    " <label id='term3' style='cursor:pointer' onclick='get_term(this)'> 3 </label> "
											);
							for (var i = year_max; i >= year_min; i--) {
								$("#sel_year_term").append("<option value='"+i+"'>"+i+"</option>");
							}
						}

						$.ajax({
							url: $("input[name='url']").val()+"history_controller/list_overtimetotal",
							type: "post",
							data: { 
								st:"term",
								year : $("#sel_year_term :selected").val(),
								term : "auto" 
							},
							success: function(rs){
								$("#content2").html(rs); 
							},
							error: function(jqXHR) {
								alert(jqXHR.status);
							}
						});
					},
					error: function(jqXHR) {
						alert(jqXHR.status);
					}
			    });
			}
		});
	});

	function get_year(obj){
		if( obj.id == "sel_year" ){
			$.ajax({
				url: $("input[name='url']").val()+"history_controller/list_overtimetotal",
				type: "post",
				data: { 
					st:"year",
					year : $("#sel_year :selected").val() 
				},
				success: function(rs){
					$("#content2").html(rs); 
				},
				error: function(jqXHR) {
					alert(jqXHR.status);
				}
			});
		}else if( obj.id == "sel_year_term" ){
			var term = 0;
			if( $("#term1").css("color") == "rgb(255, 0, 0)" ){
				term = 1;
			}

			if( $("#term2").css("color") == "rgb(255, 0, 0)" ){
				term = 2;
			}

			if( $("#term3").css("color") == "rgb(255, 0, 0)" ){
				term = 3;
			}

			$.ajax({
				url: $("input[name='url']").val()+"history_controller/list_overtimetotal",
				type: "post",
				data: { 
					st:"term",
					year : $("#sel_year_term :selected").val(),
					term : term 
				},
				success: function(rs){
					$("#content2").html(rs); 
				},
				error: function(jqXHR) {
					alert(jqXHR.status);
				}
			});

		}
		
	}

	function get_term(obj){
		if( obj.id == "term1"){
			$("#term1").css("color","red");
			$("#term2").css("color","black");
			$("#term3").css("color","black");
			$.ajax({
				url: $("input[name='url']").val()+"history_controller/list_overtimetotal",
				type: "post",
				data: { 
					st:"term",
					year : $("#sel_year_term :selected").val(),
					term : "1" 
				},
				success: function(rs){
					$("#content2").html(rs); 
				},
				error: function(jqXHR) {
					alert(jqXHR.status);
				}
			});

		}else if( obj.id == "term2" ){
			$("#term1").css("color","black");
			$("#term2").css("color","red");
			$("#term3").css("color","black");
			$.ajax({
				url: $("input[name='url']").val()+"history_controller/list_overtimetotal",
				type: "post",
				data: { 
					st:"term",
					year : $("#sel_year_term :selected").val(),
					term : "2" 
				},
				success: function(rs){
					$("#content2").html(rs); 
				},
				error: function(jqXHR) {
					alert(jqXHR.status);
				}
			});

		}else if( obj.id == "term3" ){
			$("#term1").css("color","black");
			$("#term2").css("color","black");
			$("#term3").css("color","red");
			$.ajax({
				url: $("input[name='url']").val()+"history_controller/list_overtimetotal",
				type: "post",
				data: { 
					st:"term",
					year : $("#sel_year_term :selected").val(),
					term : "3" 
				},
				success: function(rs){
					$("#content2").html(rs); 
				},
				error: function(jqXHR) {
					alert(jqXHR.status);
				}
			});

		}
	}
</script>