<?php date_default_timezone_set('America/Los_Angeles'); ?>
<table class="table table-bordered  table-historydetail" style="size:2px;">
    <thead>
        <tr class="info">
            <th colspan="5"> <?php echo $header; ?> </th>
        </tr>
        <?php if( $max > 0 ){?>
        <tr class="active">
            <th> ลำดับ </th>
            <th> ชื่อ - นามสกุล </th>
            <th> จำนวนการใช้ห้องทั้งหมด</br>(ครั้ง) </th>
            <th> จำนวนที่ใช้ </br>(ครั้ง)</th>
            <th> คิดเป็น % </th>
        </tr>
        <?php }?>
    </thead>
	<tbody>
        <?php
            if( $max > 0 ){
                for ($i=1; $i <= $round; $i++) { 
                    echo "<tr>";
                    echo "<td>".$i."</td>";
                    echo "<td>".$user[$i]."</td>";
                    echo "<td>".$max."</td>";
                    echo "<td>".$val[$i]."</td>";
                    echo "<td>".number_format((intval($val[$i])*100)/intval($max), 2, '.', '')."</td>";
                    echo "</tr>";
                }
                echo "<tr bgcolor='#FFFF99'>";
                echo "<td colspan='3' align='right'>รวม</td>";
                echo "<td >".$max."</td>";
                echo "<td >100</td>";
                echo "</tr>";
            }else{
                echo "<td colspan='5' align='center'> ไม่พบข้อมูล </td>";
            }
        ?>
	</tbody>
</table>
<input type="hidden" name="ck" value="<?php echo $term;?>">
<script type="text/javascript">
    $(document).ready(function(){

        if( $("input[name='ck']").val() != "auto" ){
            if( $("input[name='ck']").val() == "1"){
                $("#term1").css("color","red");
                $("#term2").css("color","black");
                $("#term3").css("color","black");
            }else if( $("input[name='ck']").val() == "2" ){
                $("#term1").css("color","black");
                $("#term2").css("color","red");
                $("#term3").css("color","black");
            }else if( $("input[name='ck']").val() == "3" ){
                $("#term1").css("color","black");
                $("#term2").css("color","black");
                $("#term3").css("color","red");
            }
        }

        $(".btn-save").click(function(){
            $.ajax({
                url: $("input[name='url']").val()+"historydetail_controller/edit",
                type: "post", 
                data: {
                    no: no,
                    detail: detail
                },
                success: function(){
                    window.location.href = $("input[name='url']").val()+"historydetail_controller/view_add"; 
                },
                error: function(jqXHR) {
                    alert(jqXHR.status);
                }
            });
        });
    });
</script>


