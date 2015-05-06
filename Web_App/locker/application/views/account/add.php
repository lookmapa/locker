<div class="container-fluid">
    <div class="row">
        <div class="col-md-12" style="padding: 0% 5% 0% 5%;margin: 2% 0% 2% 0%;">
<!--  content -->
        <div class="col-md-12" >
        	<div class="panel panel-primary" style="margin:2% 0% 1% 0%;">
        		<div class="panel-heading">
        			<h3 class="panel-title"> เพิ่มบัญชีผู้ใช้ </h3>
        		</div>
        	    <div class="panel-body">
                    <div calss="row">
                        <div class="table table-responsive">
                            <table class="table table-bordered">                               
                                <tbody>
                                    <tr>
                                        <td> 
                                            รหัสบัตร RFID &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="txt-rfid" size="17px" >&nbsp;&nbsp; 
                                            <button class="btn btn-info btn-sm btn-read" ><span class="glyphicon glyphicon-time" style="margin-right:5px;width:20px"></span>อ่าน</button>
                                            &nbsp;&nbsp;<label id="lb1" name="lb"></label>&nbsp;&nbsp; <label><font face="Arial Black" color="red" id="clock"></font></label> 
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td> ชื่อ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="txt-name" size="17px" > &nbsp;&nbsp;<label id="lb2" name="lb"></label> </td>
                                    </tr>
                                    <tr>
                                        <td> นามสกุล &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="txt-sname" size="17px" > &nbsp;&nbsp;<label id="lb3" name="lb"></label></td>
                                    </tr>
                                    <tr>
                                        <td> Username &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="txt-username" size="17px" > &nbsp;&nbsp;<label id="lb4" name="lb"></label></td>
                                    </tr> 
                                    <tr>
                                        <td> Password &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="txt-password" size="17px" > </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            สิทธิการเข้าใช้&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <select id="cmblicense" name="license" >
                                                 <option value="ผู้ดูแลระบบ">ผู้ดูแลระบบ</option>
                                                 <option value="ผู้ใช้งานทั่วไป" selected>ผู้ใช้งานทั่วไป</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> 
                                            อนุญาติให้ใช้ห้องนอกตารางสอน&nbsp;&nbsp;
                                            <input type="checkbox" id="level">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-10"></br>                 
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
                                                            foreach ($number as $row):
                                                                echo "<td style='text-align: center'>ห้อง ".$row->Number_Room."</td>"; 
                                                            endforeach;    
                                                        ?>
                                                        </tr>
                                                        <tr>
                                                        <?php
                                                            for($i = 1; $i <= 12; $i++){
                                                                echo "<td class='warning' style='text-align: center'><input type='checkbox' id='check".$i."' disabled></td>";
                                                        }
                                                        ?>
                                                        </tr>                         
                                                    </tbody> 
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td>
                                        <button type="button" class="btn btn-warning btn-save btn-sm"  >
                                            <span class="glyphicon glyphicon-save"></span> บันทึก
                                        </button>
                                        <a href="<?php echo base_url();?>account_controller/view_show" id="cancel">
                                            <button type="button" class="btn btn-default btn-sm"  style="margin-left:20px;">
                                                ยกเลิก
                                            </button>
                                        </a>
                                        </td>                                   
                                    </tr>                          
                                </tbody>
                            </table>
                            <input type="hidden" name="url" value="<?php echo base_url();?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                   
<script type="text/javascript">

    $(document).ready(function(){
        var myVar;
        var bl = "false";

        $("#txt-name,#txt-sname").bind('keypress', function(e) {
            return ((e.which < 48 || e.which > 57)) ? true : false;
        });

        $("li a,#edit,#cancel").click(function(){
            ready();
        });

        $("#level").click(function(){
            if( bl == "false"){
                bl = "true";
                for ( var i = 1; i <= 12; i++){
                    $("#check"+i).prop("disabled", false);
                }
            }else{
                bl = "false";
                for ( var i = 1; i <= 12; i++){
                    $("#check"+i).prop("disabled", true);
                    $("#check"+i).prop("checked", false);
                }
            }
        });

        $(".btn-cancel").click(function(){
            window.location.href = $("input[name='url']").val()+"account_controller/view_show";
        });

        $(".btn-read").click(function(){
            $(this).attr("disabled", true);
            $("#txt-rfid").val("");
            wait();
        });

        $(".btn-save").click(function(){
            if( $("#txt-rfid").val() == "" || $("#txt-name").val() == "" || $("#txt-sname").val() == "" || 
                $("#txt-username").val() == "" || $("#txt-password").val() == "" ){
                alert("กรุณากรอกข้อมูลให้ครบ");
            }else{
                var total = "";
                var level = 0;
                $("label[name='lb']").html("");
                for (i = 1; i <= 12; i++) { 
                    if($("#check"+i).prop("checked")){
                        total += "1";
                    }else{
                        total += "0";
                    }
                }
                if( $("#level").prop("checked") ){
                    level = 1;
                }else{
                    level = 0;
                }
                $.ajax({
                    url : $("input[name='url']").val()+"account_controller/add",
                    type : "post",
                    data : { 
                        rfid : $("#txt-rfid").val(),
                        name : $("#txt-name").val(),
                        sname : $("#txt-sname").val(),
                        username : $("#txt-username").val(),
                        password : $("#txt-password").val(),
                        privileges : $("#cmblicense").val(),
                        license : total,
                        level: level
                    },
                    success : function(rs){
                        if( rs.length == 4){
                            window.location.href = $("input[name='url']").val()+"account_controller/view_show";
                        }else if(parseInt(rs) == 1){
                            $("#lb1").html("X").css({"color": "red", "font-size": "13px"});
                            alert("กรุณาป้อนข้อมูลใหม่");
                        }else if(parseInt(rs) == 2){
                            $("#lb2,#lb3").html("X").css({"color": "red", "font-size": "13px"});
                            alert("กรุณาป้อนข้อมูลใหม่");
                        }else if(parseInt(rs) == 3){
                            $("#lb4").html("X").css({"color": "red", "font-size": "13px"});
                            alert("กรุณาป้อนข้อมูลใหม่");
                        }else if(parseInt(rs) == 12){
                            $("#lb1,#lb2,#lb3").html("X").css({"color": "red", "font-size": "13px"});
                            alert("กรุณาป้อนข้อมูลใหม่");
                        }else if(parseInt(rs) == 13){
                            $("#lb1,#lb4").html("X").css({"color": "red", "font-size": "13px"});
                            alert("กรุณาป้อนข้อมูลใหม่");
                        }else if(parseInt(rs) == 23){
                            $("#lb2,#lb3,#lb4").html("X").css({"color": "red", "font-size": "13px"});
                            alert("กรุณาป้อนข้อมูลใหม่");
                        }else{
                            $("#lb1,#lb2,#lb3,#lb4").html("X").css({"color": "red", "font-size": "13px"});
                            alert("กรุณาป้อนข้อมูลใหม่");
                        }  
                    }
                });
            }
        });
    });

    function myStartFunction() {
        time = 10;
        myVar = setInterval(function(){ 
            $("font").attr("color","red");
            $("#clock").html("กรุณานำบัตรแตะเครื่องอ่าน เหลือเวลาอีก "+time+" วินาที");
            $.ajax({
                url : $("input[name='url']").val()+"config_controller/list_config",
                type : "post",
                success: function(rs){
                    if(rs.length > 5){
                        $("#txt-rfid").val(rs);
                        myStopFunction();
                        $("font").attr("color","green");
                        $("#clock").html("อ่านหมายเลขได้สำเร้จ");
                        $(".btn-read").prop("disabled", false);
                        ready();
                    }                   
                }
            });
            time -= 1; 
            if( time == -1){
                $("#clock").html("ไม่สามารถอ่านหมายเลขได้ กรุณากดปุ่มอ่านอีกครั้ง");
                $(".btn-read").prop("disabled", false);
                myStopFunction();
                ready();
            }
        }, 1000);
    }

    function myStopFunction() {
        clearInterval(myVar);
    }

    function ready(){
        $.ajax({
            url : $("input[name='url']").val()+"config_controller/edit_ready",
            type : "post"
        });
    }

    function wait(){
        $.ajax({
            url : $("input[name='url']").val()+"config_controller/edit_wait",
            type : "post",
            success: function(){
                myStartFunction();
            }
        });
    }
</script>