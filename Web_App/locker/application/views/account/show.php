<div class="container-fluid">
        <div class="row">
            <div class="col-md-12" style="padding: 0% 5% 0% 5%;margin: 2% 0% 2% 0%;">
            <div class="col-md-12" >
            	<div class="panel panel-primary" style="margin:2% 0% 1% 0%;">
            		<div class="panel-heading">
            			<h3 class="panel-title"> จัดการบัญชีผู้ใช้ </h3>
            		</div>
            	    <div class="panel-body">
                        <button class="btn btn-success btn-sm btn-add" ><span class="glyphicon glyphicon-plus" style="margin-right:5px;width:20px"></span>เพิ่มบัญชีผู้ใช้</button></br></br>
                        <div calss="row">
                            <div class="table table-responsive">
                                <table class="table  table-bordered table-striped" style="size:2px;">
                                    <thead>
                                        <tr class="info" align="center">
                                            <td> ลำดับ </td>
                                            <td> ชื่อ - นามสกุล </td>
                                            <td> สิทธิในการเข้าใช้ </td>
                                            <td> เครื่องมือ </td>
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
                                                    echo "<td>".$row->Privileges."</td>";
                                                    echo "<td align='center'>";
                                                    echo "<a id='edit' name=".base64_encode($row->No)."><span style='margin-right:5px;cursor:pointer;' class='glyphicon glyphicon-pencil' data-toggle='edit' title='แก้ไข'></span></a>";
                                                    echo "<a id='del' name=".$row->No."><span style='margin-left:5px;margin-right:5px;cursor:pointer;' class='glyphicon glyphicon-trash' data-toggle='del' title='ลบ'></span></a>";
                                                    echo "<a id='list' name=".$row->No."><span style='margin-left:5px;cursor:pointer;' class='glyphicon glyphicon-list-alt' data-toggle='detail' title='รายละเอียด'></span></a>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                    $i += 1;
                                                endforeach;
                                            }else{
                                                echo "<tr><td colspan='4' class='danger' style='text-align: center' > หาข้อมูลไม่พบ </td></tr>";
                                            }                    
                                        ?>                                                                   
                                    </tbody>

                                </table>
                                <input type="hidden" name="url" value="<?php echo base_url();?>">
                                <div class="modal fade" id="list_modal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header modal-header-primary">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">รายละเอียดผู้ใช้</h4>
                                                </div>
                                            <div class="modal-body">
                                                <label> <font face="Arial Black" color="red">รหัสบัตร RFID </font> </label>&nbsp;&nbsp;&nbsp;&nbsp; <label id="lb_rfid"></label></br>
                                                <label> <font face="Arial Black" color="red">ชื่อ - นามสกุล </font> </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label id="lb_name"></label>&nbsp;&nbsp;<label id="lb_sname"></label></br>
                                                <label> <font face="Arial Black" color="red">Username    </font> </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label id="lb_username"></label></br>
                                                <label> <font face="Arial Black" color="red">Pasword     </font> </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label id="lb_password"></label></br>
                                                <label> <font face="Arial Black" color="red">สิทธิการเข้าใช้  </font> </label>&nbsp;&nbsp;&nbsp;&nbsp; <label id="lb_license"></label></br>
                                                <label> <font face="Arial Black" color="red">ใช้ห้องนอกตารางสอน  </font> </label>&nbsp;&nbsp;&nbsp;&nbsp; <label id="lb_level"></label></br>
                                                <div class="table table-responsive">    
                                                    <table class="table table-bordered table-striped" style="size:2px;">
                                                        <thead>
                                                            <tr>
                                                                <th> 1 </th>
                                                                <th> 2 </th>
                                                                <th> 3 </th>
                                                                <th> 4 </th>
                                                                <th> 5 </th>
                                                                <th> 6 </th>
                                                                <th> 7 </th>
                                                                <th> 8 </th>
                                                                <th> 9 </th>
                                                                <th> 10 </th>
                                                                <th> 11 </th>
                                                                <th> 12 </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                            <?php
                                                            for($i = 1; $i <= 12; $i++){
                                                                echo "<td style='text-align: center'>ห้อง <label id='lb_room".$i."'></label></td>"; 
                                                            }
                                                            ?>
                                                           </tr> 
                                                            <tr>
                                                            <?php
                                                                for($i = 1; $i <= 12; $i++){
                                                                    echo "<td class='warning' style='text-align: center'><input type='checkbox' id='check".$i."' disabled style='cursor:default' ></td>";
                                                            }
                                                            ?>
                                                            </tr>                         
                                                        </tbody> 
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
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
<!--  content -->
                    
<script type="text/javascript">

    $(document).ready(function(){
        var number = 0;
        
        $('[data-toggle="detail"]').tooltip();
        $('[data-toggle="edit"]').tooltip(); 
        $('[data-toggle="del"]').tooltip();

        $("a#list").click(function(){
            $('#list_modal').modal('show');
            number = $(this).attr('name');
            $.ajax({
                url : $("input[name='url']").val()+"account_controller/detail/"+number,
                success : function(rs){
                    str = rs.split("/");
                    $("#lb_rfid").html(str[0]);
                    $("#lb_name").html(str[1]);
                    $("#lb_sname").html(str[2]);
                    $("#lb_username").html(str[3]);
                    $("#lb_password").html(str[4]);
                    $("#lb_license").html(str[5]);
                    if( str[6] == 1){ 
                        $("#lb_level").html("อนุญาติ");
                    }else{
                        $("#lb_level").html("ไม่อนุญาติ");
                    }
                    room = str[7].split("-");
                    for(var i=0; i< 12; i++){
                        $("#lb_room"+(i+1)).html(room[i]);
                    }
                    number = str[8].split("-");
                    for(var i=0; i< 12; i++){
                        if( number[i] == 1 ){
                            $("#check"+(i+1)).prop( "checked", true );
                        }else{
                            $("#check"+(i+1)).prop( "checked", false );
                        }
                    }                
                }        
            });
        });

        $("a#del").click(function(){
            $('#dl_modal').modal('show');
            number = $(this).attr('name');
        });

        $(".btn-yes").click(function(){
            $.ajax({
                url : $("input[name='url']").val()+"account_controller/delete/"+number,
                success : function(rs){
                    window.location.href = $("input[name='url']").val()+"account_controller/view_show"; 
                }        
            });      
        });

        $("a#edit").click(function(){
            number = $(this).attr('name');
            location.href = ($("input[name='url']").val()+"account_controller/view_edit/?id="+number);
        });

        $(".btn-add").click(function(){
            window.location.href = $("input[name='url']").val()+"account_controller/view_add"; 
        });

    });
</script>