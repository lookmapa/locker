<!--  content -->
				<div class="col-md-10" >
					<div class="panel panel-primary" style="margin:2% 0% 1% 0%;">
	  					<div class="panel-heading">
	    					<h3 class="panel-title"> แก้ไขหมายเลขห้อง </h3>
	  					</div>
	  					<div class="panel-body">
                        	<div class="table table-responsive">
                        	<div class="alert-warning"></div>
								<table class="table table-bordered table-edit">
									<tbody>
									<?php
										$i = 1;
										foreach ($result as $row):
											echo "<tr>";    
		                            		echo "<td> ตู้หมายเลข ".$i;
		                            		if($i <= 9){
		                            			if( $row->Number_Room != "0"){
		                            				echo "<input type='text' id='txt-room".$i."' size='8px' value=".$row->Number_Room." style='padding:0px 7px 0px 7px;margin-left:17px'> </td>";
		                            			}else{
		                            				echo "<input type='text' id='txt-room".""."' size='8px' value='' style='padding:0px 7px 0px 7px;margin-left:17px'> </td>";
		                            			}		                      
		                            		}else{
		                            			if( $row->Number_Room != "0"){
		                            				echo "<input type='text' id='txt-room".$i."' size='8px' value=".$row->Number_Room." style='padding:0px 7px 0px 7px;margin-left:10px'> </td>";
		                            			}else{
		                            				echo "<input type='text' id='txt-room".""."' size='8px' value=' ' style='padding:0px 7px 0px 7px;margin-left:10px'> </td>";
		                            			}
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
		var str = "";

		$("input").bind('keypress', function(e) {
        	return (e.which != 8 && e.which != 0 && e.which != 46 &&  (e.which < 48 || e.which > 57)) ? false : true;
    	});       

        $(".btn-save").click(function(){
        	str = "";
            $("input[type='text']").each(function(){
            	str += $(this).val()+"/";
            });
            $.ajax({
            	url: $("input[name='url']").val()+"numberlocker_controller/edit",
            	type: "post",
            	data: { data:str},
            	success: function(rs){
            		$(".alert-warning").html("<p class='alert alert-success role='alert'><span class='glyphicon glyphicon-ok'></span> "+ rs+"</p>");
            		window.location.href = $("input[name='url']").val()+"numberlocker_controller/view_editnumber";
            	}
            });
        });



	});

</script>
