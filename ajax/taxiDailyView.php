<?php
require_once("inc/init.php"); 
$conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
mysqli_set_charset($conn, "UTF8");
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_GET["daily_date"])){
    $dailyDate = $_GET["daily_date"];
}
$tr="";
$row1=0;
$rowGcar=0;
$trLink="";
$imeiOld="";
$timeStart="";
$timeEnd="";
$tDist=0;
$tFare=0;
$tDistSum=0;
$tFareSum=0;
$income=0;
$tripDist=0;
$dist=0;
//$sql="SELECT cd.daily_date, cd.car_id, cd.imei, cd.distance "
//        ."FROM car_daily cd "
//        ." Left Join taxi_meter tm on tm.t_imei = cd.imei and date(tm.t_start_time) = cd.daily_date "
//        ."Where cd.daily_date = '".$dailyDate."' and cd.income >0 "
//        ."Order By cd.car_id, tm.t_start_time ;";
$sql="SELECT cd.daily_date, cd.car_id, cd.imei, cd.trip_distance, cd.income, cd.distance  "
        ."FROM car_daily cd "        
        ."Where cd.daily_date = '".$dailyDate."' and cd.income >0 "
        ."Order By cd.car_id ;";
if ($result=mysqli_query($conn,$sql) or die(mysqli_error($conn))){
    while($row = mysqli_fetch_array($result)){
        $row1++;
        $rowGcar=0;
        $trlink="";
        $tDistSum=0;
        $tFareSum=0;
        $imei=$row["imei"];
        $carId=$row["car_id"];
        $tripDist=$row["trip_distance"];
        $income=$row["income"];
        $dist=$row["distance"];
        $tr.='<tr><td>'.$row1.'</td><td>'.$carId.'</td><td>'.$dist.'</td><td>'.$tripDist.'</td><td>'.$income.'</td></tr>';
        $sql='Select time(t_start_time) as t_start_time, time(t_off_time) as t_off_time, t_distance, t_taxi_fare '
            . 'From taxi_meter '
            . 'Where date(t_start_time) = "'.$dailyDate.'" and t_imei ='.$imei.' Order By t_start_time';
        if ($resultC=mysqli_query($conn,$sql) or die(mysqli_error($conn))){
            while($rowC = mysqli_fetch_array($resultC)){
                $rowGcar++;
                $timeStart=$rowC["t_start_time"];
                $timeEnd=$rowC["t_off_time"];
                $tDist=$rowC["t_distance"];
                $tFare=$rowC["t_taxi_fare"];
                $tDistSum+=$tDist;
                $tFareSum+=$tFare;
                $trlink.='<tr><td>'.$rowGcar.'</td><td>'.$timeStart.'</td><td>'.$timeEnd.'</td><td>'.$tDist.'</td><td>'.$tFare.'</td></tr>';
                //$trlink.='<div class="col-sm-3 col-xs-3"><h6>'.$rowGcar.'</h6></div><div class="col-sm-3 col-xs-3"><h6>'.$timeStart.'</h6></div><div class="col-sm-2 col-xs-2"><h6>'.$timeEnd.'</h6></div><div class="col-sm-2 col-xs-2"><h6>'.$tDist.'</h6></div><div class="col-sm-2 col-xs-2"><h6>'.$tFare.'</h6></div>';
                
                //$trlink.='<tr><td colspan="4"><ul><li>'.$rowGcar.'</li><li>'.$timeStart.'</li><li>'.$timeEnd.'</li><li>'.$tDist.'</li><li>'.$tFare.'</li></ul></td></tr>';
            }
            //$trlink.='<tr><td colspan="3">รวม</td><td>'.$tDistSum.'</td><td>'.$tFareSum.'</td></tr>';
            $tr.='<tr ><td colspan="7">'
                . '<table width="60%" align="center"><thead><tr><th>ลำดับ</th><th>เวลาเริ่ม</th><th>เวลาสิ้นสุด</th><th>ระยะทาง</th><th>ค่าโดยสาร</th></tr></thead><tbody>'.$trlink.'</tbody></table></td></tr>';
//            $tr.='<tr><td colspan="3">'
//                    . '<div class="container content package collapse in"><div class="row"><div class="col-sm-3 col-xs-3"><h6>ลำดับ</h6></div><div class="col-sm-3 col-xs-3"><h6>เวลาเริ่ม</h6></div><div class="col-sm-2 col-xs-2"><h6>เวลาสิ้นสุด</h6></div><div class="col-sm-2 col-xs-2"><h6>ระยะทาง</h6></div><div class="col-sm-2 col-xs-2"><h6>ค่าโดยสาร</h6></div>'.$trlink.'</div>';
        }
        $resultC->free();
    }
}else{
    echo mysqli_error($conn);
}
?>
<section id="widget-grid" class="">
    <div class="row">
        <article class="col-sm-12">
            <div class="col-sm-12 well">
                <table width="70%" class="table table-hover table-expandable table-striped table-sticky-header">
                    <caption></caption>
                    <thead>
                        <tr>
                        <th>ลำดับ</th>
                        <th>ทะเบียนรถ</th>
                        <th>ระยะทางทั้งหมด</th>
                        <th>ระยะทางรับผู้โดยสาร</th>
                        <th>income</th>
                        <th></th>
                        </tr>
                        </thead>
                    <tbody>
                        <?php echo $tr;?>
                    </tbody>
                    
                </table>
                
            </div>
        </article>
    </div>
</section>
<script type="text/javascript">
    loadScript("js/plugin/jquery-plugin-for-expandable-bootstrap-table-rows/bootstrap-table-expandable.js", function(){
    });    
</script>