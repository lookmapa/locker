<?php date_default_timezone_set('America/Los_Angeles'); ?>
<table class="table table-bordered  table-history" style="size:2px;">
    <thead>
        <tr class="info">
            <th colspan="6"> <?php echo $header; ?> </th>
        </tr>
        <?php if( $sum > 0 ){?>
        <tr class="active">
            <th> ลำดับ </th>
            <th> ชื่อ - นามสกุล </th>
            <th> เข้าสอนทั้งหมด</br>(ครั้ง) </th>
            <th> เข้าสอนตรงเวลา </br>(ครั้ง)</th>
            <th> เข้าสอนสาย </br>(ครั้ง)</th>
            <th> ขาดสอน </br>(ครั้ง)</th>
        </tr>
        <?php }?>
    </thead>
	<tbody>
        <?php
            if( $sum > 0 ){
                for ($i=0; $i < $round; $i++) { 
                    echo "<tr>";
                    echo "<td>".($i+1)."</td>";
                    echo "<td>".$user[$i]."</td>";
                    if( $max[$i] == 0 ){ echo "<td>".$max[$i]." ( 0.00 % )</td>"; }else{ echo "<td>".$max[$i]." ( 100.00 % )</td>"; }
                    echo "<td>".$c_come[$i]." ( ".number_format($percent_come[$i], 2, '.', '')." % )</td>";
                    echo "<td>".$c_late[$i]." ( ".number_format($percent_late[$i], 2, '.', '')." % )</td>";
                    echo "<td>".$c_absent[$i]." ( ".number_format($percent_absent[$i], 2, '.', '')." % )</td>";
                    echo "</tr>";
                }
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

    });
</script>


