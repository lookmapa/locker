<!--  content -->
				<div class="col-md-10" >
					<div class="panel panel-primary" style="margin:2% 0% 1% 0%;">
	  					<div class="panel-heading">
	    					<h3 class="panel-title"> กำหนดค่าเริ่มต้นอาคาร </h3>
	  					</div>
	  					<div class="panel-body">
                        	<div class="table table-responsive">
                        		<div class="alert-warning"></div>
								<table class="table table-bordered table-edit">
									<tbody>
									<?php
										$i = 1;
										foreach ($result->result() as $row):
											echo "<tr>";    
											if( $row->Town != ""){
		                            			echo "<td>กำหนดค่าเริ่มต้นอาคาร <input type='text' id='txt-town' size='8px' value=".$row->Town." style='padding:0px 7px 0px 7px;margin-left:17px'> </td>";
		                            		}else{
		                            			echo "<td>กำหนดค่าเริ่มต้นอาคาร <input type='text' id='txt-town' size='8px' value='' style='padding:0px 7px 0px 7px;margin-left:17px'> </td>";
		                            		}
		                            		echo "</tr>";
		                        			$i += 1;		                            	
		                        		endforeach;
		                        	?>
		                        		<tr>                       
                            				<td>
                            					<button type="button" class="btn btn-warning btn-save"  style="margin-left:10px;">
                                    				<span class="glyphicon glyphicon-save"></span> บันทึก
                                				</button>
                                				<input type="hidden" name="url" value="<?php echo base_url();?>">
                                			</td>                       
                        				</tr>
									</tbody>
								</table>
    						</div>		
						</div>
					</div>
				</div>
			<!--  end content -->
			</div>
		</div>
<script type="text/javascript">
	$(document).ready(function(){

        $(".btn-save").click(function(){
            $.ajax({
            	url: $("input[name='url']").val()+"config_controller/edit_town",
            	type: "post",
            	data: { town:$("#txt-town").val()},
            	success: function(rs){
            		$(".alert-warning").html("<p class='alert alert-success role='alert'><span class='glyphicon glyphicon-ok'></span> "+ rs+"</p>");
            		window.location.href = $("input[name='url']").val()+"config_controller/view_edittown";
            	}
            });
        });



	});

</script>
