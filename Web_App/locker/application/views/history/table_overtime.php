<!--  content -->
				<div class="col-md-10" >
					<div class="panel panel-primary" style="margin:2% 0% 1% 0%;">
	  					<div class="panel-heading">
	    					<h3 class="panel-title"> รายงานการใช้ห้องนอกเวลา </h3>
	  					</div>
	  					<div class="panel-body">
	  					<div style="text-align:right">
							ส่งออก<select id='export'  style="height: 30px;width: 100px;margin-right:3px;margin-left:3px">
									<option>PDF</option>
									<option>Excel</option>	
								</select>
								<button type="button" class="btn btn-success btn-sm btn-export" style="float:right" disabled>
								<span class="glyphicon glyphicon glyphicon-eject"></span> ส่งออก 
							</button> 
						</div>
	  						<div class="row">
	  						<?php if( $this->session->userdata("sess_type") == "ผู้ดูแลระบบ" ){?>
								<div class="col-md-3">
									<label for="sel2" style ="margin-top:10px">เลือกชื่ออาจารย์ :</label>
							    	<select  class="form-control" id="sel_user" size="5">
							    		<option value="all" selected>เลือกทั้งหมด</option>
						    		<?php foreach ($user as $row): ?>
						        		<option value="<?php echo $row->No;?>" > <?php echo $row->Name." ".$row->SName;?></option>
						    		<?php endforeach; ?>
							    	</select>
								</div>
							<?php }?>
								<div class="col-md-2" style ="margin-top:10px">
									<label for="sel2">เลือกปี :</label>
							    	<select  class="form-control" id="sel_year" size="5">
							    		<option value="all" selected>เลือกทั้งหมด</option>
								    <?php foreach ($year as $row): ?>
						        		<option value="<?php echo $row->Year;?>" > <?php echo $row->Year;?></option>
						    		<?php endforeach; ?>
							    	</select>
								</div>
								<div class="col-md-2" style ="margin-top:10px">
									<label for="sel2">เลือกเทอม :</label>
							    	<select  class="form-control" id="sel_term" size="5">
							    		<option value="all" selected>เลือกทั้งหมด</option>
								    	<option value="1" >1</option>
								    	<option value="2" >2</option>
								    	<option value="3" >3</option>
							    	</select>
								</div>
								<div class="col-md-2">
									<div class="btn-group btn-group-sm" style ="margin-top:30px">
                                		<a class="btn  btn-primary btn-search" ><i class="glyphicon glyphicon-search" style="margin-right:5px" ></i>ค้นหา</a>
                            		</div>
								</div>
							</div></br>
	  						<div class="table table-responsive">
								<div id="content"></div>
	  						</div>
	  						<input type="hidden" name="url" value="<?php echo base_url();?>">
	  						<input type="hidden" name="privileges" value="<?php echo $this->session->userdata("sess_type")?>">
	  						<input type="hidden" name="no" value="<?php echo $this->session->userdata("sess_id")?>">
	  					</div>
					</div>
				</div>
			<!--  end content -->
			</div>
		</div>
		<form id="fexport" method="post" action="<?php echo base_url();?>report_controller/list_overtime">
			<input type="hidden" name="export_user" value="">
			<input type="hidden" name="export_year" value="">
			<input type="hidden" name="export_term" value="">
			<input type="hidden" name="export" value="">
		</form>
<script type="text/javascript">
	$(document).ready(function(){

		var user = "";
		$(".btn-search").click(function(){
			$(".btn-export").prop('disabled',true);
			$("#content").html("");
			$("#content").append(
									" <div class='progress'> "+
									" 	<div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='80' aria-valuemin='0' aria-valuemax='100' style='width: 80%'> "+
									" 		<span class='sr-only'>45% Complete</span> "+
									"	</div>"+
									" </div>"
								 );
			if( $("input[name='privileges']").val() == "ผู้ดูแลระบบ" ){
				user = $("#sel_user :selected").val();
			}else{
				user = $("input[name='no']").val();
			}

			$.ajax({
				url: $("input[name='url']").val()+"history_controller/list_overtime",
				type: "post",
				data: {
					user : user,
					year : $("#sel_year :selected").val(),
					term : $("#sel_term :selected").val()
				},
				success: function(rs){
					$("#content").html(rs); 
					$(".btn-export").prop('disabled',false);
				},
				error: function(jqXHR) {
					alert(jqXHR.status);
				}
			});
		});

		$(".btn-export").click(function(){
			//$(".loader").attr("style", "visibility: visible");
			$("input[name='export_user']").val(user);
			$("input[name='export_year']").val($("#sel_year :selected").val());
			$("input[name='export_term']").val($("#sel_term :selected").val());
			$("input[name='export']").val($("#export").val());
			$("#fexport").submit();
		});

	});
</script>