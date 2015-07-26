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
                        <div class="alert-warning"></div>
                            <table class="table  table-bordered table-striped" style="size:2px;">
                                <thead>
                                    <tr class="info" align="center">
                                        <td> ลำดับ </td>
                                        <td> ปีการศึกษา </td>
                                        <td> เริ่มวันที่ </td>
                                        <td> จบวันที่ </td>
                                        <td> เริ่มวันที่สอบ </td>
                                        <td> จบวันที่สอบ </td>
                                        <td> เครื่องมือ </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i = 1;
                                        if( count($result->result()) > 0){
                                            foreach ($result->result() as $row ): 
                                                $bDate = new DateTime($row->sDate);
                                                $eDate = new DateTime($row->eDate);
                                                $sDateExam = new DateTime($row->sDateExam);
                                                $eDateExam = new DateTime($row->eDateExam);
                                                $bDatearray = explode("-", $bDate->format("Y-m-d"));
                                                $eDatearray = explode("-", $eDate->format("Y-m-d"));
                                                $bExDatearray = explode("-", $sDateExam->format("Y-m-d"));
                                                $eExDatearray = explode("-", $eDateExam->format("Y-m-d"));

                                                echo "<tr>";
                                                echo "<td>".$i."</td>";
                                                echo "<td>".$row->Term."/".$row->Year."</td>";
                                                echo "<td>".$bDate->format("d-m-").($bDatearray[0]+543)."</td>";
                                                echo "<td>".$eDate->format("d-m-").($eDatearray[0]+543)."</td>";
                                                echo "<td>".$sDateExam->format("d-m-").($bExDatearray[0]+543)."</td>";
                                                echo "<td>".$eDateExam->format("d-m-").($eExDatearray[0]+543)."</td>";
                                                echo "<td align='center'>";
                                                echo "<a id='edit' name=".base64_encode($row->No)."><span style='margin-right:5px;cursor:pointer;' class='glyphicon glyphicon-pencil' data-toggle='edit' title='แก้ไข' ></span></a>";
                                                echo "<a id='del' name=".$row->No."><span style='margin-left:5px;margin-right:5px;cursor:pointer;' class='glyphicon glyphicon-trash' data-toggle='del' title='ลบ'></span></a>";
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

        $('[data-toggle="detail"]').tooltip();
        $('[data-toggle="edit"]').tooltip(); 
        $('[data-toggle="del"]').tooltip();

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
                    $(".alert-warning").html("<p class='alert alert-success role='alert'><span class='glyphicon glyphicon-ok'></span> "+ rs+"</p>");
                    window.location.href = $("input[name='url']").val()+"config_controller/view_show"; 

                }        
            });      
        });

    });
</script>