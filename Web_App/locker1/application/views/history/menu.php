<div class="container-fluid">
		<div class="row">
			<div class="col-md-12" style="padding: 0% 5% 0% 5%;margin: 2% 0% 2% 0%;">
			<!--  menu -->
				<div class="col-md-2" >
					<div class="panel panel-primary" style="margin:10% 1% 10% 1%;">
	  					<div class="panel-heading">
	    					<h3 class="panel-title"> เมนู </h3>
	  					</div>
	  					<div class="panel-body">
	  						<table class="table table-hover">
	  							<thead>
	  								<tr>
	  									<th></th>
	  								</tr>
	  							</thead>
	  							<tbody>
	  								<tr>
	  									<td>
	  										<a id="report" style="cursor:pointer"> รายงานการสอน </a>
	  									</td>
	  								</tr>
	  								<tr>
	  									<td>
	  										<a id="report_overtime" style="cursor:pointer"> รายงานการใช้ห้องนอกเวลา </a>
	  									</td>
	  								</tr>
	  								<tr>
	  									<td>
	  										<a id="report_come_people" style="cursor:pointer"> รายงานสรุปการเข้าสอน <?php if( $this->session->userdata("sess_type") == "ผู้ดูแลระบบ" ){?> (บุคคล) <?php }?> </a>
	  									</td>
	  								</tr>
	  								<?php if( $this->session->userdata("sess_type") == "ผู้ดูแลระบบ" ){?>
	  								<tr>
	  									<td>
	  										<a id="report_come_total" style="cursor:pointer"> รายงานสรุปการเข้าสอน (ทั้งหมด) </a>
	  									</td>
	  								</tr>
	  								<tr>
	  									<td>
	  										<a id="report_overtime_total" style="cursor:pointer"> รายงานสรุปการใช้ห้องนอกเวลา </a>
	  									</td>
	  								</tr>
	  								<?php }?>
	  							</tbody>
	    					</table>
	    					<form method="post" action="<?php echo base_url();?>history_controller/view_show" id="history">
	    						<input type="hidden" name="st">
	    					</form>
	  					</div>
					</div>
				</div>
			<!--  end menu -->
<script type="text/javascript">
	$(document).ready(function(){

		$("a#report").click(function(){
			$("input[name='st']").val("report");
			$("form#history").submit();
		});

		$("a#report_come_total").click(function(){
			$("input[name='st']").val("report_come_total");
			$("form#history").submit();
		});

		$("a#report_come_people").click(function(){
			$("input[name='st']").val("report_come_people");
			$("form#history").submit();
		});

		$("a#report_overtime").click(function(){
			$("input[name='st']").val("report_overtime");
			$("form#history").submit();
		});

		$("a#report_overtime_total").click(function(){
			$("input[name='st']").val("report_overtime_total");
			$("form#history").submit();
		});
	});
</script>