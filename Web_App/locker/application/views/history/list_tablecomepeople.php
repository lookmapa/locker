<?php date_default_timezone_set('America/Los_Angeles'); ?>
<table class="table table-bordered  table-history" style="size:2px;">
    <thead>
        <tr class="info">
            <th colspan="6"> <?php echo $header; ?> </th>
        </tr>
        <?php if( $sum > 0 ){?>
        <tr class="active">
            <th> ลำดับ </th>
            <th> ชื่อ </th>
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
                for ($i=0; $i < 1; $i++) { 
                    echo "<tr>";
                    echo "<td>1</td>";
                    echo "<td>".$user."</td>";
                    if( $max == 0 ){ echo "<td>".$max." ( 0.00 % )</td>"; }else{ echo "<td>".$max." ( 100.00 % )</td>"; }
                    echo "<td>".$c_come." ( ".number_format($percent_come, 2, '.', '')." % )</td>";
                    echo "<td>".$c_late." ( ".number_format($percent_late, 2, '.', '')." % )</td>";
                    echo "<td>".$c_absent." ( ".number_format($percent_absent, 2, '.', '')." % )</td>";
                    echo "</tr>";
                }
            }else{
                echo "<td colspan='5' align='center'> ไม่พบข้อมูล </td>";
            }
        ?>
	</tbody>
</table>
<input type="hidden" id="max" value="<?php echo $sum;?>">
<input type="hidden" id="header" value="<?php echo $header;?>">
<input type="hidden" id="come" value="<?php echo number_format($percent_come, 2, '.', '');?>">
<input type="hidden" id="late" value="<?php echo number_format($percent_late, 2, '.', '');?>">
<input type="hidden" id="absent" value="<?php echo number_format($percent_absent, 2, '.', '');?>">
<script type="text/javascript">
    $(document).ready(function(){

        var come = parseFloat($("#come").val());
        var late = parseFloat($("#late").val());
        var absent = parseFloat($("#absent").val());
        
        if( parseInt($("#max").val()) > 0 ){
            $('#container').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                },
                title: {
                    text: $("#header").val()
                },
                tooltip: {
                    pointFormat: '<span style="font-size: 15px">{series.name}: <b>{point.percentage:.2f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.2f} %',
                            style: {
                                fontSize: "15px",
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'back'
                            }
                        }
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'จำนวน',
                    data: [
                        {name : 'เข้าสอนตรงเวลา',color:'#00FF00',y:come,sliced: true,selected: true},
                        {name : 'เข้าสอนสาย',color:'yellow',y:late},
                        {name : 'ขาดสอน',color:'#99FFFF',y:absent},
                    ]
                }]
            });
        }else{
            $('#container').html("");
        }
    });
</script>

