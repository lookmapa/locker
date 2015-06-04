<div class="container-fluid">
		<div class="row">
			<div class="col-md-12" style="padding: 0% 5% 0% 5%;margin: 2% 0% 2% 0%;">
				<div class="col-md-12" >
					<div class="panel panel-primary" style="margin:2% 0% 1% 0%;">
	  					<div class="panel-heading">
	    					<h3 class="panel-title"> กรอกเหตุผลการใช้ห้องนอกเวลา </h3>
	  					</div>
	  					<div class="panel-body"></br>
	  						<div class="table table-responsive">
								<?php if( $this->session->userdata("sess_type") == "ผู้ดูแลระบบ" ){?>
									</br><label for="sel2">เลือกชื่ออาจารย์ :</label>
								    <select  class="form-control" id="sel_user" size="5">
								      	<?php foreach ($user as $row): ?>
								        <option value="<?php echo $row->No;?>" <?php if( $row->No == $this->session->userdata("sess_id")){echo "selected";} ?> > <?php echo $row->Name." ".$row->SName;?></option>
								    	<?php endforeach; ?>
								    </select>
									</br></br>
								<?php } ?>
								<div id="content"></div></br>
	  						</div>
	  						<input type="hidden" name="url" value="<?php echo base_url();?>">
	  						<input type="hidden" name="privileges" value="<?php echo $this->session->userdata("sess_type")?>">
	  						<input type="hidden" name="no" value="<?php echo $this->session->userdata("sess_id")?>">
	  						<inpt type="hidden" id="sess_id">
	  					</div>
					</div>
				</div>
			<!--  end content -->
			</div>
		</div>

<script type="text/javascript">
	$(document).ready(function(){

		var url = "";
		if( $("input[name='privileges']").val() == "ผู้ใช้งานทั่วไป" ){
			url = $("input[name='url']").val()+"history_controller/list_addhistory?user="+$("input[name='no']").val();
			$("#sess_id").val($("input[name='no']").val());
		}else{
			url = $("input[name='url']").val()+"history_controller/list_addhistory?user="+$("#sel_user :selected").val();
			$("#sess_id").val($("#sel_user :selected").val());
		}

		$.ajax({
			url: url,
			type: "post",
			success: function(rs){
				$("#content").html("");
				$("#content").append(
									" <div class='progress'> "+
									" 	<div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='80' aria-valuemin='0' aria-valuemax='100' style='width: 80%'> "+
									" 		<span class='sr-only'>45% Complete</span> "+
									"	</div>"+
									" </div>"
								 );
				$("#content").html(rs); 
			},
			error: function(jqXHR) {
				alert(jqXHR.status);
			}
		});

		$("#sel_user").change(function(){
			$("#sess_id").val($("#sel_user :selected").val());
			$.ajax({
				url: $("input[name='url']").val()+"history_controller/list_addhistory?user="+$("#sel_user :selected").val(),
				type: "post",
				success: function(rs){
					$("#content").html("");
					$("#content").append(
									" <div class='progress'> "+
									" 	<div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='80' aria-valuemin='0' aria-valuemax='100' style='width: 80%'> "+
									" 		<span class='sr-only'>45% Complete</span> "+
									"	</div>"+
									" </div>"
								 );
					$("#content").html(rs); 
				},
				error: function(jqXHR) {
					alert(jqXHR.status);
				}
			});
		});

	});
</script>