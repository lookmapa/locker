<!--  content -->
        <div class="col-md-10" >
        	<div class="panel panel-primary" style="margin:2% 0% 1% 0%;">
        		<div class="panel-heading">
        			<h3 class="panel-title"> กำหนดวัน เริ่ม-จบ ปีการศึกษา </h3>
        		</div>
        	    <div class="panel-body">
                    <button class="btn btn-success btn-sm btn-add" ><span class="glyphicon glyphicon-plus" style="margin-right:5px;width:20px"></span>เพิ่ม</button></br></br>
                    <div calss="row">
                        <div class="table table-responsive">
                            <table class="table  table-bordered table-striped" style="size:2px;">
                                <thead>
                                    <tr class="info" align="center">
                                        <td> ลำดับ </td>
                                        <td> ปีการศึกษา </td>
                                        <td> เริ่มวันที่ </td>
                                        <td> จบวันที่ </td>
                                        <td> เครื่องมือ </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i = 1;
                                        if( count($result->result()) > 0){
                                            foreach ($result->result() as $row ): 
                                                echo "<tr>";
                                                echo "<td>".$i."</td>";
                                                echo "<td>".$row->Term."/".$row->Year."</td>";
                                                echo "<td>".$row->sDate."</td>";
                                                echo "<td>".$row->eDate."</td>";
                                                echo "<td align='center'>";
                                                echo "<a id='edit' name=".base64_encode($row->No)."><span style='margin-right:5px;cursor:pointer;' class='glyphicon glyphicon-pencil'></span></a>";
                                                echo "<a id='del' name=".$row->No."><span style='margin-left:5px;margin-right:5px;cursor:pointer;' class='glyphicon glyphicon-trash'></span></a>";
                                                echo "</td>";
                                                echo "</tr>";
                                                $i += 1;
                                            endforeach;
                                        }else{
                                            echo "<tr><td colspan='5' style='text-align: center' > หาข้อมูลไม่พบ </td></tr>";
                                        }                    
                                    ?>                                                                   
                                </tbody>

                            </table>
                            <input type="hidden" name="url" value="<?php echo base_url();?>">
                            <div class="modal fade" id="dl_modal">
                                <div class="modal-dialog modal-sm " style="margin-top:10%">
                                    <div class="modal-content">
                                        <div class="modal-header modal-header-primary" >
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h5> คุณต้องการลบข้อมูลนี้ ? </h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success btn-sm btn-yes" data-dismiss="modal"> ตกลง </button>
                                            <button type="button" class="btn btn-danger btn-sm btn-no" data-dismiss="modal"> ยกเลิก </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                    
<script type="text/javascript">

    $(document).ready(function(){
        var number = 0;

        $("a#edit").click(function(){
            number = $(this).attr('name');
            location.href = ($("input[name='url']").val()+"config_controller/view_editdate/?id="+number);
        });

        $(".btn-add").click(function(){
            window.location.href = $("input[name='url']").val()+"config_controller/view_add"; 
        });

        $("a#del").click(function(){
            $('#dl_modal').modal('show');
            number = $(this).attr('name');
        });

        $(".btn-yes").click(function(){
            $.ajax({
                url : $("input[name='url']").val()+"config_controller/delete/"+number,
                success : function(rs){
                    window.location.href = $("input[name='url']").val()+"config_controller/view_show"; 

                }        
            });      
        });

    });
</script>