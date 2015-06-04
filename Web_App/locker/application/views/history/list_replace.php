<?php date_default_timezone_set('America/Los_Angeles'); ?>
<table class="table table-bordered  table-historydetail" style="size:2px;">
    <thead>
        <tr class="info">
            <th> ลำดับ </th>
            <th> ชื่อ - นามสกุล </th>
            <th> วันที่ </th>
            <th> เวลาเริ่ม </th>
            <th> เวลาจบ </th>
            <th> ห้อง </th>
            <th> คนเปิดแทน </th>
        </tr>
    </thead>
	<tbody>
		<?php
            if( $max > 0){
                for( $i = 1; $i <= $max; $i++){
                    echo "<tr>";
                    echo "<td>".$i."</td>";
                    echo "<td>".$Buser[$i]."</td>";
                    echo "<td>".$date[$i]."</td>";
                    echo "<td>".$timeb[$i]."</td>";
                    echo "<td>".$timee[$i]."</td>";
                    echo "<td>".$room[$i]."</td>";
                    echo "<td>".$Euser[$i]."</td>";
                    echo "</tr>";
                }
            }else{
                echo "<tr><td colspan='7'  style='text-align: center' > ไม่มีประวัติการเปิดห้องแทน </td></tr>";
            }
        ?>
	</tbody>
</table>



