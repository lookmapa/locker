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
	  								<th></th>
	  							</thead>
	  							<tbody>
	  								<tr>
	  									<td>
	  										<a href="<?php echo base_url();?>subject_controller/view_add"> เพิ่มรายวิชา</a>
	  									</td>
	  								</tr>
	  								<tr>
	  									<td>
	  										<form id="f-front" method="post" action="<?php echo base_url();?>subject_controller/view_show"><input type="hidden" name="st" value="front"></form>
	  										<a id="front" style="cursor:pointer"> ดูรายวิชา</a>
	  									</td>
	  								</tr>
	  							</tbody>
	    					</table>
	  					</div>
					</div>
				</div>
			<!--  end menu -->
<script type="text/javascript">
	$(document).ready(function(){
		$("a#front").click(function(){
			$("#f-front").submit();
		});
	});
</script>