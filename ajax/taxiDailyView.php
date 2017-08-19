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
//$sql="SELECT cd.daily_date, cd.car_id, cd.imei, cd.distance "
//        ."FROM car_daily cd "
//        ." Left Join taxi_meter tm on tm.t_imei = cd.imei and date(tm.t_start_time) = cd.daily_date "
//        ."Where cd.daily_date = '".$dailyDate."' and cd.income >0 "
//        ."Order By cd.car_id, tm.t_start_time ;";
$sql="SELECT cd.daily_date, cd.car_id, cd.imei, cd.trip_distance, cd.income "
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
        $tr.='<tr><td>'.$row1.'</td><td>'.$carId.'</td><td>'.$tripDist.'</td><td>'.$income.'</td></tr>';
        $sql='Select time(t_start_time) as t_start_time, time(t_off_time) as t_off_time, t_distance, t_taxi_fare From taxi_meter Where date(t_start_time) = "'.$dailyDate.'" and t_imei ='.$imei;
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
            }
            $trlink.='<tr><td colspan="3">รวม</td><td>'.$tDistSum.'</td><td>'.$tFareSum.'</td></tr>';
            $tr.='<tr><td>&nbsp;</td><td colspan="3"><table width="100%"><thead><tr><th>ลำดับ</th><th>เวลาเริ่ม</th><th>เวลาสิ้นสุด</th><th>ระยะทาง</th><th>ค่าโดยสาร</th></tr></thead>'.$trlink.'</td></tr></table>';
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
                <table width="70%">
                    <caption></caption>
                    <thead>
                        <tr>
                        <th>ลำดับ</th>
                        <th>ทะเบียนรถ</th>
                        <th>ระยะทางทั้งหมด</th>
                        <th>income</th>
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
