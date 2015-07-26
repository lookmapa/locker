
                        <div class="table table-responsive">
                			<table class="table table-bordered table-striped" style="size:2px;">
                                <thead>
                                    <tr class="info">
                                        <th> ลำดับ </th>
                                        <th> รหัสวิชา </th>
                                        <th> ชื่อวิชา </th>
                                        <th> จำนวนชั่วโมงที่สอน </th>
                                        <th> เครื่องมือ </th>
                                    </tr>
                                </thead>
                				<tbody>
                					<?php
                                    if (count($result) > 0){
                                        $count = 1;
                                        foreach ($result as $row): 
                                            echo "<tr>";
                                            echo "<td>".$count."</td>";
                                            echo "<td>".$row->Id."</td>";
                                            echo "<td>".$row->Name."</td>";
                                            echo "<td>".$row->Hours."</td>";
                                            echo "<td><center>";
                                            echo "<a id='edit' name=".base64_encode($row->No)."><span style='margin-right:10px;cursor:pointer;' class='glyphicon glyphicon-pencil' data-toggle='edit' title='แก้ไข'></span></a>";
                                            echo "<a id='del' name=".$row->No."><span style='margin-left:10px;cursor:pointer;' class='glyphicon glyphicon-trash' data-toggle='del' title='ลบ'></span></a>";
                                            echo "</center></td>";
                                            echo "</tr>";
                                            $count += 1;
                                        endforeach;
                                    }else{
                                        echo "<tr><td colspan='5'  style='text-align: center' > หาข้อมูลไม่พบ </td></tr>";
                                    }
                                    ?>                                     
                				</tbody>
                			</table>
                            <input type="hidden" name="url" value="<?php echo base_url();?>">
                            <div class="modal fade" id="dl_Modal">
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
                      <form id="f_del" method="post" action="<?php echo base_url();?>subject_controller/delete">
                          <input type="hidden" name="no" id="no" value="">
                      </form>

    <script type="text/javascript" >
        $(document).ready(function(){
            var del = 0;
            var edit = 0;

            $('[data-toggle="edit"]').tooltip(); 
            $('[data-toggle="del"]').tooltip();

            $("a#del").click(function(){
                $('#dl_Modal').modal('show');
                del = $(this).attr('name');
            });

            $("a#edit").click(function(){
                edit = $(this).attr('name');
                location.href = $("input[name='url']").val()+"subject_controller/view_edit/?id="+edit+"&detail="+$("input[name='detail']").val();
            });

            $(".btn-yes").click(function(){
                $("#no").val(del);
                $("#f_del").submit();
                /*$.ajax({
                    url: $("input[name='url']").val()+"subject_controller/delete",
                    type: "post",
                    data: {no:del},
                    success : function(){
                        $.ajax({
                            url: $("input[name='url']").val()+"subject_controller/list_table/all",
                            type: "post",
                            success : function(rs){
                                $(".content").html(rs);
                            }  
                        });
                    }
                });*/
            });
        });
    </script>