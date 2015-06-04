<!--  content -->
        <div class="col-md-10" >
        	<div class="panel panel-primary" style="margin:2% 0% 1% 0%;">
        		<div class="panel-heading">
        			<h3 class="panel-title"> ตารางรายวิชา </h3>
        		</div>
        	    <div class="panel-body">
                    <div class="row">
                        <label style="margin-left:10px;margin-bottom:15px">คำค้นหา : </label>
                        <input type="text" id="txt-serch" class="inputs" size="20px" >
                        <div class="btn-group btn-group-sm" style="margin-left:10px">
                            <a class="btn  btn-primary btn-search" ><i class="glyphicon glyphicon-search" style="margin-right:5px" ></i>ค้นหา</a>
                        </div>
                        <div class="btn-group btn-group-sm" >
                            <a class="btn  btn-default btn-total" ><i class="glyphicon glyphicon-list-alt" style="margin-right:5px" ></i>ดูรายการทั้งหมด</a>
                        </div>
                    </div>
                    <div calss="col-md-12">
                        </br><div class="content" ></div>
                    </div>
                </div>
            </div>
        </div>
        <!--  end content -->
    </div>
</div>       
                    <input type="hidden" name="url" value="<?php echo base_url(); ?>"> 
                    <input type="hidden" name="detail" value="">
                    <?php if($status == "back"){ ?>
                        <input type="hidden" name="status" value="<?php echo $status; ?>">
                        <input type="hidden" name="b-detail" value="<?php echo $detail; ?>">
                    <?php } ?>

<script type="text/javascript">

    $(document).ready(function(){

        if($("input[name=status]").val() == "back"){
            if($("input[name=b-detail]").val() == "total"){  
                $("input[name='detail']").val("total");  
                search_all();
            }else{
                $("input[name='detail']").val($("input[name=b-detail]").val());
                $("#txt-serch").val($("input[name=b-detail]").val());
                search_find($("input[name=b-detail]").val());
            }   
        }

        $("input").keypress(function(event) {
            if (event.which == 13) {
                if($("#txt-serch").val() == ""){
                    alert("กรุณากรอกข้อมุลให้ครบ");
                }else{
                    $("input[name='detail']").val($("#txt-serch").val());
                    search_find($("#txt-serch").val());
                }
            }
        });

        
        $(".btn-search").click(function(){
            if($("#txt-serch").val() == ""){
                alert("กรุณากรอกข้อมุลให้ครบ");
            }else{
                $("input[name='detail']").val($("#txt-serch").val());
                search_find($("#txt-serch").val());
            }
        });

        $(".btn-total").click(function(){
            $("#txt-serch").val("");
            $("input[name='detail']").val("total");
            search_all();
        });
    });

function search_find(data){
    $.ajax({
        url: $("input[name='url']").val()+"subject_controller/list_table/"+data,
        type: "post",
        success : function(rs){
            $(".content").html("");
            $(".content").append(
                                    " <div class='progress'> "+
                                    "   <div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='80' aria-valuemin='0' aria-valuemax='100' style='width: 80%'> "+
                                    "       <span class='sr-only'>45% Complete</span> "+
                                    "   </div>"+
                                    " </div>"
                                 );
            $(".content").html(rs);
        }  
    });
}

function search_all(){
    $.ajax({
        url: $("input[name='url']").val()+"subject_controller/list_table/all",
        type: "post",
        success : function(rs){
            $(".content").html("");
            $(".content").append(
                                    " <div class='progress'> "+
                                    "   <div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='80' aria-valuemin='0' aria-valuemax='100' style='width: 80%'> "+
                                    "       <span class='sr-only'>45% Complete</span> "+
                                    "   </div>"+
                                    " </div>"
                                 );
            $(".content").html(rs);
        }  
    });
}
</script>
<style>
.inputs {
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
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