<!--  content -->
        <div class="col-md-10" >
        	<div class="panel panel-primary" style="margin:2% 0% 1% 0%;">
        		<div class="panel-heading">
        			<h3 class="panel-title"> ตารางการขอใช้ห้องนอกเวลา </h3>
        		</div>
        	    <div class="panel-body">
                    <div calss="row">
                        <div class="table table-responsive">
                            <table class="table  table-bordered table-striped" id="overtime_room" style="size:2px;">
                                <thead>
                                    <tr class="info" align="center">
                                        <th> ลำดับ </th>
                                        <th> ชื่อ - นามสกุล </th>
                                        <th> วันที่ </th>
                                        <th> เวลาเริ่ม </th>
                                        <th> เวลาเจบ </th>
                                        <th> ห้อง </th>
                                        <th> รายละเอียด </th>
                                        <th> เครื่องมือ </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i = 1;
                                        if( count($result) > 0){
                                            foreach ($result as $row ): 
                                                echo "<tr>";
                                                echo "<td>".$i."</td>";
                                                echo "<td>".$row->Name."  ".$row->SName."</td>";
                                                echo "<td>".$row->Date."</td>";
                                                echo "<td>".$row->Time_Begin."</td>";
                                                echo "<td>".$row->Time_End."</td>";
                                                echo "<td>".$row->Room."</td>";
                                                echo "<td>".$row->Detail."</td>";
                                                echo "<td align='center'>";
                                                echo "<a id='edit' name=".base64_encode($row->otr_no)."><span style='margin-right:5px;cursor:pointer;' class='glyphicon glyphicon-pencil'></span></a>";
                                                echo "<a id='del' name=".$row->otr_no."><span style='margin-left:5px;margin-right:5px;cursor:pointer;' class='glyphicon glyphicon-trash'></span></a>";
                                                echo "</td>";
                                                echo "</tr>";
                                                $i += 1;
                                            endforeach;
                                        }else{
                                            echo "<tr><td colspan='8' style='text-align: center' > หาข้อมูลไม่พบ </td></tr>";
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

        $("a#del").click(function(){
            $('#dl_modal').modal('show');
            number = $(this).attr('name');
        });

        $("a#edit").click(function(){
            number = $(this).attr('name');
            location.href = ($("input[name='url']").val()+"overtime_room_controller/view_edit/?id="+number);
        });

        $(".btn-yes").click(function(){
            $.ajax({
                url : $("input[name='url']").val()+"overtime_room_controller/delete",
                type : 'post',
                data : {no : number},
                success : function(rs){
                    window.location.href = $("input[name='url']").val()+"overtime_room_controller/view_show"; 
                }        
            });      
        });
    }); 
</script>