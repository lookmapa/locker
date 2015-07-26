<!--  content -->
				<div class="col-md-10" >
					<div class="panel panel-primary" style="margin:2% 0% 1% 0%;">
	  					<div class="panel-heading">
	    					<h3 class="panel-title"> รายงานการสอน </h3>
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
	  						<?php if( $this->session->userdata("sess_type") == "ผู้ดูแลระบบ" || $this->session->userdata("sess_type") == "หัวหน้าสาขา/ประธานหลักสูตร"){?>
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
		<form id="fexport" method="post" action="<?php echo base_url();?>report_controller/list_report">
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
				url: $("input[name='url']").val()+"history_controller/list_report",
				type: "post",
				data: {
					user : user,
					year : $("#sel_year :selected").val(),
					term : $("#sel_term :selected").val()
				},
				success: function(rs){
					var str = rs.split("!");
					if(str[0] == "error"){
						alert("กรุณาไปกำหนดวันที่ เริ่ม - จบ ตามที่กำหนดให้เรียบร้อย \n"+str[1]);
						window.location.href = $("input[name='url']").val()+"config_controller/view_show";
					}else{
						$("#content").html(str[1]);
						$(".btn-export").prop('disabled',false);
					} 
				},
				error: function(jqXHR) {
					//alert("กรุณารอสักครู่");
				}
			});
		});

		$(".btn-export").click(function(){
			$(".loader").attr("style", "visibility: visible");
			$("input[name='export_user']").val(user);
			$("input[name='export_year']").val($("#sel_year :selected").val());
			$("input[name='export_term']").val($("#sel_term :selected").val());
			$("input[name='export']").val($("#export").val());
			$("#fexport").submit();
			/*$.ajax({
				url: $("input[name='url']").val()+"report_controller/list_report",
				type: "post",
				data: {
					export_user : user,
					export_year : $("#sel_year :selected").val(),
					export_term : $("#sel_term :selected").val(),
					export_ : $("#export").val()
				},
				success: function(rs){
					alert(rs);
				}
			});*/
		});

	});
</script>

<style type="text/css">
.loader {
  margin-left: 10px;
  float: right;
  font-size: 10px;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background: #ffffff;
  background: -moz-linear-gradient(left, #ffffff 10%, rgba(255, 255, 255, 0) 42%);
  background: -webkit-linear-gradient(left, #ffffff 10%, rgba(255, 255, 255, 0) 42%);
  background: -o-linear-gradient(left, #ffffff 10%, rgba(255, 255, 255, 0) 42%);
  background: -ms-linear-gradient(left, #ffffff 10%, rgba(255, 255, 255, 0) 42%);
  background: linear-gradient(to right, #ffffff 10%, rgba(255, 255, 255, 0) 42%);
  position: relative;
  -webkit-animation: load3 1.4s infinite linear;
  animation: load3 1.4s infinite linear;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
}
.loader:before {
  width: 50%;
  height: 50%;
  background: green;
  border-radius: 100% 0 0 0;
  position: absolute;
  top: 0;
  left: 0;
  content: '';
}
.loader:after {
  background: #fff;
  width: 75%;
  height: 75%;
  border-radius: 50%;
  content: '';
  margin: auto;
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}
@-webkit-keyframes load3 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes load3 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}


</style>