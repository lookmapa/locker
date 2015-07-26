<!DOCTYPE html>
<html>
    <header>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Web Locker</title>
            <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>/css/bootstrap.css">
            <script type="text/javascript" src='<?php echo base_url();?>/js/jquery.js'></script>
            <script type="text/javascript" src='<?php echo base_url();?>/js/bootstrap.min.js'></script>  
            <script type="text/javascript" src='<?php echo base_url();?>/js/jquery-base64.js'></script>      
    </header>
    <body background='<?php echo base_url();?>/images/bg.jpg'></br></br>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12" style="padding: 0% 5% 0% 5%;margin: 2% 0% 2% 0%;">
                    <div class="col-md-4" ></div>
                    <div class="col-md-4" >
                        
                            <div class="panel panel-primary" style="margin:10% 1% 10% 1%;">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> เข้าสู่ระบบ </h3>
                                </div>
                                <div class="panel-body" style="text-align:center">
                                    <table width="100%">
                                        <tr>
                                            <td width="5%" > 
                                                <span class="glyphicon glyphicon-user" style="margin-right:15px"></span>
                                            </td>
                                            <td width="95%" >
                                                <input type="text" class="inputs" id="txt-username" placeholder="Username" value="<?php echo $t_username;?>" ><br/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><div class = "alert-username"></div></td>
                                        </tr>
                                        <tr>
                                            <td >
                                                <span class="glyphicon glyphicon-lock" style="margin-right:15px"></span>
                                            </td>
                                            <td>
                                                <input type="password" class="inputs" id="txt-password" placeholder="Password" value="<?php echo $t_password;?>" ><br/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><div class = "alert-password"></div></td>
                                        </tr>
                                        <tr>
                                            </br><td></td>
                                            <td >
                                                <label style="text-align:left">
                                                </label>
                                                <button type="button" class="btn btn-danger btn-login btn-sm" style="margin-right:2%;float:right" >&nbsp;&nbsp;&nbsp;&nbsp;เข้าสู่ระบบ&nbsp;&nbsp;&nbsp;&nbsp;</button>
                                            </td>
                                        </tr>
                                    </table>
                                    <input type="hidden" name="url" value="<?php echo base_url();?>">
                                    </br>                               
                                </div>
                            </div>
                        <!-- </form> -->
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
        </div>
    </body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
        $(".btn-login").click(function(){
            $(".alert-username,.alert-password").html("");
            if( $("#txt-username").val() == "" ||  $("#txt-password").val() == ""){
               $(".alert-password").html("<p class='alert alert-danger role='alert'>กรุณากรอกให้ครบ</p>"); 
            }else{
               // $("#f_login").submit();
                login();   
            }
        });

         $("input").keypress(function(event) {
            if (event.which == 13) {
                $(".alert-username,.alert-password").html("");
                if( $("#txt-username").val() == "" ||  $("#txt-password").val() == ""){
                    $(".alert-password").html("<p class='alert alert-danger role='alert'>กรุณากรอกให้ครบ</p>"); 
                }else{
                    //$("#f_login").submit();
                    login();
                }
            }
        });

    });

    function login(){
        $.ajax({
                    url : $("input[name='url']").val()+"account_controller/login",
                    type : "post",
                    data : { 
                        username : $("#txt-username").val(),
                        password : $.base64('encode', $("#txt-password").val())
                    },
                    success : function(rs){
                        if(rs == "success"){
                            window.location.href = $("input[name='url']").val()+"history_controller/view_add";
                        }else if( rs == "failUsername"){
                            //$(".alert-username").html("กรุณากรอก username ให้ถูกต้อง");
                            $(".alert-username").html("<p class='alert alert-danger role='alert'>กรุณากรอก username ให้ถูกต้อง</p>");
                        }else{
                            $(".alert-password").html("<p class='alert alert-danger role='alert'>กรุณากรอก password ให้ถูกต้อง</p>");
                        }
                         /*if( rs.length == 4){
                            alert("บันทึกข้อมูลเรียบร้อย");
                            window.location.href = $("input[name='url']").val()+"account_controller/view_show";
                        }else if(parseInt(rs) == 1){
                            $("#lb1").html("X").css({"color": "red", "font-size": "13px"});
                            alert("รหัสบัตรนี้มีคนใช้แล้ว กรุณาเปลี่ยนเป็นรหัสอื่น");
                        }else if(parseInt(rs) == 2){
                            $("#lb4").html("X").css({"color": "red", "font-size": "13px"});
                            alert("username นี้มีผู้ใช้แล้ว กรุณาเปลี่ยนเป็น username อื่น");
                        }else if(parseInt(rs) == 12){
                            $("#lb1,#lb4").html("X").css({"color": "red", "font-size": "13px"});
                            alert("รหัวบัตร และ username นี้มีคนใช้แล้ว กรุณาเปลี่ยนเป็นใหม่");
                        }*/
                    }
                });
    }



</script>
<style>
.inputs {
    height: 34px;
    padding-left: 7px;
    width: 100%;
    font-size: 14px;
    margin-bottom: 10px;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.inputs:focus {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
}
</style>