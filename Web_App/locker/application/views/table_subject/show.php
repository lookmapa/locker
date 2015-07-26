<?php if ($this->session->userdata("sess_type") != "ผู้ดูแลระบบ"){?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12" style="padding: 0% 5% 0% 5%;margin: 2% 0% 2% 0%;">
            <div class="col-md-12" >
<?php }else{?>
            <div class="col-md-10" >
<?php }?>
<!--  content -->            
        	<div class="panel panel-primary" style="margin:2% 0% 1% 0%;">
        		<div class="panel-heading">
        			<h3 class="panel-title"> ตารางสอน </h3>
        		</div>
        	    <div class="panel-body">
                    <div class="alert-warning"></div>
                    <div calss="row">
                        <div calss="col-md-6">
                            <div class="btn-group btn-group-sm" style ="margin-bottom:15px">
                                <a class="btn dropdown-toggle btn-default btn-user-show" data-toggle="dropdown" href="#" style="width:150px">เลือกอาจารย์<span class="caret" style="margin-left:10px"></span></a>
                                    <ul class="dropdown-menu btn-user-show" style=" height: 120px;overflow: auto;">
                                        <?php foreach ($user as $row):?>
                                            <li style='cursor:pointer'>
                                            <a><?php echo $row->Name." ".$row->SName;?>
                                            <input type="hidden" id="no" value="<?php echo $row->No;?>"></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                            </div>
                            <div class="btn-group btn-group-sm " style ="margin-bottom:15px">
                                <a class="btn dropdown-toggle btn-default btn-year-show" data-toggle="dropdown" href="#" style="pointer-events: none;width:70px;">เลือกปี<span class="caret" style="margin-left:10px;"></span></a>
                                    <ul class="dropdown-menu btn-year-show" style=" height: 120px;overflow: auto;">

                                    </ul>
                            </div>
                            <div class="btn-group btn-group-sm" style ="margin-bottom:15px">
                                <a class="btn dropdown-toggle btn-default btn-term-show" data-toggle="dropdown" href="#" style="pointer-events: none;width:90px;">เลือกเทอม<span class="caret" style="margin-left:10px"></span></a>
                                    <ul class="dropdown-menu btn-term-show">

                                    </ul>
                            </div>
                            <div class="btn-group btn-group-sm" style ="margin-bottom:15px">
                                <a class="btn  btn-primary btn-search" href="#" style="pointer-events: none;"><i class="glyphicon glyphicon-search" style="margin-right:5px" ></i>ค้นหา</a>
                            </div>
                        </div>
                    </div>
                    <div calss="col-md-12">
                        <div class="content" ></div>
                    </div>  
                </div>
            </div>
            </div>
        <!--  end content -->
        </div>
    </div>     
                    <input type="hidden" name="url" value="<?php echo base_url(); ?>"> 
                    <input type="hidden" name="status" value="<?php echo $status; ?>">
                    <input type="hidden" id="value">  
                    <?php if($status == "back"){ ?>
                        <input type="hidden" name="b-no_account" value="<?php echo $b_no_account; ?>">
                        <input type="hidden" name="b-user" value="<?php echo $b_user; ?>">
                        <input type="hidden" name="b-year" value="<?php echo $b_year; ?>">
                        <input type="hidden" name="b-term" value="<?php echo $b_term; ?>">
                    <?php } ?>
<script type="text/javascript">

    $(document).ready(function(){

        if($("input[name=status]").val() == "back"){            
          
           $("a.btn-user-show").html($("input[name=b-user]").val()+'<span class="caret" style="margin-left:10px"></span>');
           $("a.btn-year-show").html($("input[name=b-year]").val()+'<span class="caret" style="margin-left:10px"></span>');
           $("a.btn-term-show").html($("input[name=b-term]").val()+'<span class="caret" style="margin-left:10px"></span>');
           $(".btn-year-show li").remove();
           $(".btn-term-show li").remove();
           $(".alert-warning").html("");
                $.ajax({
                        url: $("input[name='url']").val()+"subject_table_controller/list_year",
                        type: "post",
                        data:{no_account:$("input[name='b-no_account']").val()},
                        success : function(rs){
                            if(rs == "error"){
                                //alert("อาจารย์ท่านนี้ยังไม่ได้ทำการลงตารางสอน");
                                $(".alert-warning").html("<p class='alert alert-danger role='alert'>อาจารย์ท่านนี้ยังไม่ได้ทำการลงตารางสอน</p>");
                            }else{
                                $("a.btn-year-show").css("pointer-events","visible");
                                $("a.btn-term-show").css("pointer-events","visible");
                                $("a.btn-search").css("pointer-events","visible");
                                var str = rs.split(",");
                                for(var i=0; i<=str.length-2;i++){                                    
                                    $('<li style="cursor:pointer"><a>'+str[i]+'</a></li>').appendTo('ul.btn-year-show');
                                }
                                    $.ajax({
                                        url: $("input[name='url']").val()+"subject_table_controller/list_term",
                                        type: "post",
                                        data:{
                                            year:$("a.btn-year-show").text(),
                                            no_account:$("input[name='b-no_account']").val()
                                            },
                                        success : function(rs){
                                            $("a.btn-term-show").css("pointer-events","visible");
                                            var str = rs.split(",");
                                            for(var i=0; i<=str.length-2;i++){
                                                $('<li style="cursor:pointer"><a>'+str[i]+'</a></li>').appendTo('ul.btn-term-show');
                                            }
                                            $("#value").val($("input[name='b-no_account']").val());
                                            search();
                                         }
                                    });
                            }
                        }
                    });
        }

            $(".btn-user-show").on("click", "li", function() {
                var html = "";
                var val = "";
               // $(".btn-year-show li").remove();
              //  $(".btn-term-show li").remove();
                $(".alert-warning").html("");
                html = $(this).text()+'<span class="caret" style="margin-left:10px"></span>';
                //$("a.btn-user-show").html($(this).text()+'<span class="caret" style="margin-left:10px"></span>');
                 val = $("#value").val();
                $("#value").val($("#no",this).val());
                $.ajax({
                        url: $("input[name='url']").val()+"subject_table_controller/list_year",
                        type: "post",
                        data:{no_account:$("#value").val()},
                        success : function(rs){
                            if(rs == "error"){
                                //alert("อาจารย์ท่านนี้ยังไม่ได้ทำการลงตารางสอน");
                                $("#value").val(val);
                                $(".alert-warning").html("<p class='alert alert-danger role='alert'>อาจารย์ท่านนี้ยังไม่ได้ทำการลงตารางสอน</p>");
                            }else{
                                $(".btn-year-show li").remove();
                                $(".btn-term-show li").remove();
                                $("a.btn-user-show").html(html);
                                $("a.btn-year-show").css("pointer-events","visible");
                                $("a.btn-term-show").css("pointer-events","visible");
                                $("a.btn-search").css("pointer-events","visible");
                                var str = rs.split(",");
                                for(var i=0; i<=str.length-2;i++){
                                    if(i==0){$('a.btn-year-show').html(str[i]+'<span class="caret" style="margin-left:10px"></span>');}
                                    $('<li style="cursor:pointer"><a>'+str[i]+'</a></li>').appendTo('ul.btn-year-show');
                                }
                                    $.ajax({
                                        url: $("input[name='url']").val()+"subject_table_controller/list_term",
                                        type: "post",
                                        data:{
                                            year:$("a.btn-year-show").text(),
                                            no_account:$("#value").val()
                                            },
                                        success : function(rs){
                                            $("a.btn-term-show").css("pointer-events","visible");
                                            var str = rs.split(",");
                                            for(var i=0; i<=str.length-2;i++){
                                                if(i==0){$('a.btn-term-show').html(str[i]+'<span class="caret" style="margin-left:10px"></span>');}
                                                $('<li style="cursor:pointer"><a>'+str[i]+'</a></li>').appendTo('ul.btn-term-show');
                                            }                            
                                         }
                                    });
                            }
                        }
                    });

            });

            $(".btn-year-show").on("click", "li", function() {
                $(".btn-term-show li").remove();
                $('a.btn-year-show').html($(this).text()+'<span class="caret" style="margin-left:10px"></span>');   
                $.ajax({
                    url: $("input[name='url']").val()+"subject_table_controller/list_term",
                    type: "post",
                    data:{
                        no_account:$("#value").val(),
                        year:$(this).text()
                    },
                    success : function(rs){
                        $("a.btn-term-show").css("pointer-events","visible");
                        var str = rs.split(",");
                        for(var i=0; i<=str.length-2;i++){
                            if(i==0){$('a.btn-term-show').html(str[i]+'<span class="caret" style="margin-left:10px"></span>');}
                            $('<li style="cursor:pointer"><a>'+str[i]+'</a></li>').appendTo('ul.btn-term-show');
                        }
                        
                    }
                });
            });

            $(".btn-term-show").on("click", "li", function() {
               $('a.btn-term-show').html($(this).text()+'<span class="caret" style="margin-left:10px"></span>');
            });

            $(".btn-search").click(function(){
                search();
            });
        });

function search(){
    $.ajax({
        url: $("input[name='url']").val()+"subject_table_controller/list_table",
        type: "post",
        data:{
            no_account:$("#value").val(),
            year:$("a.btn-year-show").text(),
            term:$("a.btn-term-show").text()
        },
        success : function(rs){
            $(".content").html(rs);
        }  
    });
}
</script>