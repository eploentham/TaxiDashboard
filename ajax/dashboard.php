<?php 
require_once("inc/init.php"); 
$conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " .DB_HOST." ".DB_USER." ".DB_PASSWORD." ".DB_NAME." ". mysqli_connect_error();
}
mysqli_set_charset($conn, "UTF8");
$tr="";
$trS5="";
$trS6="";
$gr="";
$grCnt="";
$agTrip=0;
$agTrip1=0;
$agTrip2=0;
$agTripOld=0;
$agTrip3=0;
$agTrip4="";
$trip="";
$cnt="";
$income="";
$taTrip="";
$taCnt="";
$taIncome="";
$taDist="";
$agCnt=0;
$agCnt1=0;
$agincome=0;
$agincomeOld=0;
$agIncome1=0;
$agIncome2="";
$agDist=0;
$agDistFree=0;
$total=0;
$totalIncome=0;
$totalCar=0;
$agTrip1=0;
$row1=0;
$colorGr="['#E979BB', '#57889C']";
$curDate = date("Y-m-d");
//echo getdate("Y.m.d");
$maxTrip=0;
$maxTripDate="";
$linkDailyDate="";
$sql="SELECT daily_date, count(1) as cnt, sum(income) as income, sum(trip_cnt) as trip_cnt, sum(trip_distance) as trip_distance, sum(distance) as distance FROM car_daily "
    ."Where daily_date <= '".$curDate."' and daily_date >= date_add('".$curDate."',INTERVAL -90 day) and income > 0 "
    ."Group By daily_date "
    ."Order By daily_date desc;";
if ($result=mysqli_query($conn,$sql) or die(mysqli_error($conn))){
    while($row = mysqli_fetch_array($result)){
        $row1++;
        $agTrip = ($row["trip_distance"] / $row["distance"])*100;
        if($agTrip>$agTripOld) {$agTripOld=$agTrip;$agTrip3++;}$agTrip3--;
        $agTrip2 = ($row["trip_distance"] / $row["cnt"]);
        $agCnt = ($row["trip_cnt"] / $row["cnt"]);
        $agincome = ($row["income"] / $row["cnt"]);
        if($agincome>$agincomeOld) {$agincomeOld=$agincome;$agIncome1++;}else$agIncome1--;
        $agDist = ($row["distance"] / $row["cnt"]);
        $agDistFree = $agDist - $agTrip2;
        $agTrip1 = 100-$agTrip;
        $agCnt1 = 100-$agCnt;
        $trip = number_format($agTrip,0,",","").",".number_format($agTrip1,0,",","");
        $cnt = number_format($agCnt,0,",","");
        $income = number_format($agincome,2,",","");
        $dailyDate = $row['daily_date'];
        $linkDailyDate = "<a href='#ajax/taxiDailyView.php?daily_date=$dailyDate'>$dailyDate</a>";
        $cnt1 = number_format($row['cnt']);
        $sparkline .= $row["income"].", ";
        $total += $row["income"];
        $sparkcar .= $row["cnt"].", ";
        $totalCar += $row["cnt"];
        $agTrip3 += $agTrip;
        $sparkIncome .= number_format($agincome,2,'.','').", ";
        $totalIncome += number_format($agincome,2,".",",");
        if($maxTrip<$row["trip_cnt"]){
            $maxTrip = $row["trip_cnt"];
            $maxTripDate = $dailyDate;
        }
        $in="<input type='hidden' id='in".$row1."' value='".$row["trip_cnt"]."'>";
        $inCnt="<input type='hidden' id='inCnt".$row1."' value='".$row["cnt"]."'>";
        $inDistAll="<input type='hidden' id='inDistAll".$row1."' value='".$row["distance"]."'>";
        $inDistTrip="<input type='hidden' id='inDistTrip".$row1."' value='".$row["trip_distance"]."'>";
        $gr='<div class="sparkline display-inline" data-sparkline-type="pie" data-sparkline-piecolor=""'.$colorGr.'"" data-sparkline-offset="90" data-sparkline-piesize="23px">'.$trip.'</div>';
        $grCnt='<div class="sparkline display-inline" data-sparkline-type="pie" data-sparkline-piecolor=""'.$colorGr.'"" data-sparkline-offset="90" data-sparkline-piesize="23px">'.$cnt.'</div>';
        $taTrip = '<table><tr><td width=20%>'.number_format($row["trip_distance"],2,'.',',').'</td><td>&nbsp;&nbsp;เฉลี่ย&nbsp;'.number_format($agTrip2,2,'.',',')
            .' กิโลเมตร '.number_format($agTrip,2,'.',',').'%&nbsp;</td><td> วิ่งรถเปล่า '.number_format($agDistFree,2,'.',',').' &nbsp;&nbsp;&nbsp;'.$gr.'</td></tr></table>';
        $taCnt = "<table><tr><td width='40%'>".number_format($row["trip_cnt"])."</td><td>&nbsp;&nbsp;เฉลี่ย&nbsp;".number_format($agCnt)."&nbsp;เที่ยว</td><td>&nbsp;&nbsp;&nbsp;</td></tr></table>";
        $taIncome = "<table><tr><td width='40%'>".number_format($row["income"],2,".",",")."</td><td>&nbsp;&nbsp;เฉลี่ย&nbsp;".number_format($agincome,2,".",",")."&nbsp;บาท</td><td>&nbsp;&nbsp;&nbsp;</td></tr></table>";
        $taDist = '<table><tr><td width=40%>'.number_format($row['distance'],2,'.',',').'</td><td>&nbsp;&nbsp;เฉลี่ย&nbsp;'.number_format($agDist,2,'.',',').'&nbsp;กิโลเมตร</td><td>&nbsp;&nbsp;&nbsp;</td></tr></table>';
        
        $tr.="<tr id='tr$row1'><td>$linkDailyDate$in$inCnt$inDistAll$inDistTrip</td><td>$cnt1</td><td>$taDist</td><td>$taTrip</td><td>$taCnt</td><td>$taIncome</td><td>$gr</td></tr>";
        
//        $tr.="<tr><td>".$row["daily_date"]."</td><td>".number_format($row["cnt"])."</td><td>".$taDist."</td><td>"
//            .$taTrip."</td><td>".$taCnt."</td><td>"
//            .$taIncome."</td><td>".$gr."</td></tr>";
        //$tr.="<tr><td>$dailyDate</td><td>$cnt1</td><td>$taDist</td><td>$gr</td><td></td><td></td><td></td></tr>";
//        $tr.="<tr><td>".$row["daily_date"]."</td><td>".number_format($row["cnt"])."</td><td>".$taDist."</td><td>"
//            .$taTrip."</td><td>".$taCnt."</td><td>"
//            .$taIncome."</td><td>".$gr."</td></tr>";
    }
    //$tr = str_replace('<tr id='.$maxTripDate.'', '<tr id='.$dailyDate,'', $tr);
    $inMax="<input type='hidden' id='inmax' value=$row1>";
    $agCar = $totalCar / $row1;
    $agIncome1 = $totalIncome / $row1;
    $agTrip3 = $agTrip3 / $row1;
    $agIncome1>0?$agIncome2="fa fa-arrow-circle-up":$agIncome2="fa fa-arrow-circle-down";
    $agTrip3>0?$agTrip4="fa fa-caret-up icon-color-bad":$agTrip4="fa fa-caret-down icon-color-bad";
}else{
    echo mysqli_error($conn);
}
$sql="SELECT hour(t_start_time) as hour, count(1) as cnt, sum(t_distance) as t_distance, sum(t_taxi_fare) as t_taxi_fare "
    ."FROM taxi_meter "
    ."where t_start_time <= '".$curDate."' and t_start_time >= date_add('".$curDate."',INTERVAL -90 day) "
    ."GROUP by hour(t_start_time)";
if ($result=mysqli_query($conn,$sql) or die(mysqli_error($conn))){
    while($row = mysqli_fetch_array($result)){
        $trS5 .="<tr><td>".$row["hour"]."</td><td>".$row["cnt"]."</td><td>".number_format($row["t_distance"],2,'.',',')."</td><td>".$row["t_taxi_fare"]."</td></tr>";
    }
}else{
    echo mysqli_error($conn);
}
$distGs6=0;
$incomeGs6=0;
$sql="select  count(1) as cnt,sum(t_taxi_fare) as t_taxi_fare, dayofweek(t_start_time) as dayofweek, sum(t_distance) as t_distance From taxi_meter "
    ."Where t_start_time <= '".$curDate."' and t_start_time >= date_add('".$curDate."',INTERVAL -90 day) "
    ."Group By dayofweek(t_start_time) order By dayofweek(t_start_time)";
if ($result=mysqli_query($conn,$sql) or die(mysqli_error($conn))){
    while($row = mysqli_fetch_array($result)){
        $distGs6 = ($row["t_distance"]/10);
        $incomeGs6 = ($row["t_taxi_fare"]/100);
        $trS6 .="<tr><td>".getDayName($row["dayofweek"])."</td><td>".$row["cnt"]."</td><td>".number_format($distGs6,2,'.',',')."</td><td>".$incomeGs6."</td></tr>";
    }
}else{
    echo mysqli_error($conn);
}
$max=0;
$modeofmean1 ="";
$sql="select count(1) as cnt, ceil_income from car_daily where ceil_income >0 and daily_date <= '".$curDate."' and daily_date >= date_add('".$curDate."',INTERVAL -90 day) group by ceil_income order by ceil_income";
if ($modeofmean=mysqli_query($conn,$sql) or die(mysqli_error($conn))){
    while($row = mysqli_fetch_array($modeofmean)){
        if(($row["ceil_income"]>=200)&&($row["ceil_income"]<=3400)){
            $modeofmean1 .= "[".$row["ceil_income"].",".$row["cnt"]."],";
            $trCeil .="<tr><td>".$row["ceil_income"]."</td><td>".$row["cnt"]."</td></tr>";
        }
        
        if($max<$row["ceil_income"]){
            $max = $row["ceil_income"];
        }
    }
}else{
    echo mysqli_error($conn);
}
$trG="";
$m="";
$cntG=0;
$inComeG=0;
$tripCntG=0;
$distG=0;
$tripDistG=0;
$sql="SELECT YEAR(daily_date) as year, MONTH(daily_date) as month, count(1) as cnt, sum(income) as income, sum(trip_cnt) as trip_cnt, sum(trip_distance) as trip_distance, sum(distance) as distance FROM car_daily "
    ."Where daily_date <= '".$curDate."' and daily_date >= date_add('".$curDate."',INTERVAL -90 day) and income > 0 "
    ."Group By  YEAR(daily_date), MONTH(daily_date) "
    ."Order By YEAR(daily_date), MONTH(daily_date) asc;";
if ($modeofmean=mysqli_query($conn,$sql) or die(mysqli_error($conn))){
    while($row = mysqli_fetch_array($modeofmean)){
        $m= getMonthName($row["month"]);
        $cntG = ($row["cnt"]/30);
        $inComeG = ($row["income"]/1000);
        $tripCntG = ($row["trip_cnt"]/100);
        $tripDistG = ($row["trip_distance"]/1000);
        $distG = ($row["distance"]/1000);
        $trG.="<tr><td>$m</td><td>$cntG</td><td>$distG</td><td>$tripDistG</td><td>$tripCntG</td><td>$inComeG</td></tr>";
    }
}else{
    echo mysqli_error($conn);
}
//foreach ($modeofmean as $key => $value) {
//    $trCeil .="<tr><td>".$key["ceil_income"]."</td><td>".$key["cnt"]."</td></tr>";
//}
$result->free();
mysqli_close($conn);
?>
<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i> Dashboard <span>> Taxi Dashboard</span></h1>
	</div>
	<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
            <ul id="sparks" class="">
                <li class="sparks-info">
                    <h5>รวมรายได้ <span class="txt-color-blue">&nbsp;<?php echo  number_format($total, 2);?></span></h5>
                    <div class="sparkline txt-color-blue hidden-mobile hidden-md hidden-sm">
                            <?php echo $sparkline;?>
                    </div>
                </li>
                <li class="sparks-info">
                    <h5> เฉลี่ยรายได้ต่อวัน <span class="txt-color-purple"><i class="<?php echo $agIncome2?>"></i>&nbsp;<?php echo number_format($agIncome1);?></span></h5>
                    <div class="sparkline txt-color-purple hidden-mobile hidden-md hidden-sm">
                            <?php echo $sparkIncome;?>
                    </div>
                </li>
                <li class="sparks-info">
                    <h5> เฉลี่ยจำนวนรถวิ่ง <span class="txt-color-greenDark"><i class="fa fa-shopping-cart"></i>&nbsp;<?php echo number_format($agCar);?></span></h5>
                    <div class="sparkline txt-color-greenDark hidden-mobile hidden-md hidden-sm">
                            <?php echo $sparkcar;?>
                    </div>
                </li>
            </ul>
	</div>
</div>
<!-- widget grid -->
<section id="widget-grid" class="">

	<!-- row -->
	<div class="row">
		<article class="col-sm-12">
			<!-- new widget -->
			<div class="jarviswidget" id="wid-id-0" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
				<!-- widget options:
				usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

				data-widget-colorbutton="false"
				data-widget-editbutton="false"
				data-widget-togglebutton="false"
				data-widget-deletebutton="false"
				data-widget-fullscreenbutton="false"
				data-widget-custombutton="false"
				data-widget-collapsed="true"
				data-widget-sortable="false"

				-->
				<header>
                                    <span class="widget-icon"> <i class="glyphicon glyphicon-stats txt-color-darken"></i> </span>
                                    <h2>Live Feeds </h2>

                                    <ul class="nav nav-tabs pull-right in" id="myTab">
                                        <li class="active">
                                            <a data-toggle="tab" href="#s1"><i class="fa fa-clock-o"></i> <span class="hidden-mobile hidden-tablet">Live Stats</span></a>
                                        </li>

                                        <li>
                                            <a data-toggle="tab" href="#s2"><i class="fa fa-facebook"></i> <span class="hidden-mobile hidden-tablet">สถิติ</span></a>
                                        </li>

                                        <li>
                                            <a data-toggle="tab" href="#s3"><i class="fa fa-dollar"></i> <span class="hidden-mobile hidden-tablet">Revenue</span></a>
                                        </li>
                                    </ul>

				</header>

				<!-- widget div-->
				<div class="no-padding">
                                    <!-- widget edit box -->
                                    
                                    <!-- end widget edit box -->

                                    <div class="widget-body">
                                        <!-- content -->
                                        <div id="myTabContent" class="tab-content">
                                            <div class="tab-pane fade active in padding-10 no-padding-bottom" id="s1">
                                                <div class="row no-space">
                                                        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                                                <!--<span class="demo-liveupdate-1"> <span class="onoffswitch-title">Live switch</span> <span class="onoffswitch">
                                                                                <input type="checkbox" name="start_interval" class="onoffswitch-checkbox" id="start_interval">
                                                                                <label class="onoffswitch-label" for="start_interval"> 
                                                                                        <span class="onoffswitch-inner" data-swchon-text="ON" data-swchoff-text="OFF"></span> 
                                                                                        <span class="onoffswitch-switch"></span> </label> </span> </span>
                                                                <div id="updating-chart" class="chart-large txt-color-blue"></div>-->
                                                            
                                                            <!--<table class="table table-striped table-hover table-condensed">-->
                                                            <div id="div31">
                                                            <table class="highchart table table-hover table-bordered" data-graph-container=".. .. .highchart-container3" data-graph-type="line">
                                                                <caption>ยอดสรุป รายวัน</caption>
                                                            <thead>
                                                                <tr>
                                                                    <th>ช่วงเวลา</th>
                                                                    <th class="text-align-center">จำนวนรถ</th>
                                                                    <th class="text-align-center hidden-xs">ระยะทาง รับผู้โดยสาร</th>
                                                                    <th class="text-align-center">รวมรายได้</th>
                                                                </tr>
                                                            </thead>
                                                                <tbody><tr><td>
                                                                <?php echo $trS6;?>
                                                                    </td></tr>
                                                                </tbody>
                                                            </table>
                                                            </div>
                                                            <div class="col-sm-12" id="div3">
                                                                    <div class="highchart-container3"></div>
                                                            </div>

                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 show-stats">

                                                                <div class="row">
                                                                        <div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> My Tasks <span class="pull-right">130/200</span> </span>
                                                                                <div class="progress">
                                                                                        <div class="progress-bar bg-color-blueDark" style="width: 65%;"></div>
                                                                                </div> </div>
                                                                        <div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> Transfered <span class="pull-right">440 GB</span> </span>
                                                                                <div class="progress">
                                                                                        <div class="progress-bar bg-color-blue" style="width: 34%;"></div>
                                                                                </div> </div>
                                                                        <div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> Bugs Squashed<span class="pull-right">77%</span> </span>
                                                                                <div class="progress">
                                                                                        <div class="progress-bar bg-color-blue" style="width: 77%;"></div>
                                                                                </div> </div>
                                                                        <div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> User Testing <span class="pull-right">7 Days</span> </span>
                                                                                <div class="progress">
                                                                                        <div class="progress-bar bg-color-greenLight" style="width: 84%;"></div>
                                                                                </div> </div>

                                                                        <span class="show-stat-buttons"> <span class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> <a href="javascript:void(0);" class="btn btn-default btn-block hidden-xs">Generate PDF</a> </span> <span class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> <a href="javascript:void(0);" class="btn btn-default btn-block hidden-xs">Report a bug</a> </span> </span>

                                                                </div>

                                                        </div>
                                                </div>

                                                <div class="show-stat-microcharts">
                                                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">

                                                                <div class="easy-pie-chart txt-color-orangeDark" data-percent="<?php echo $agTrip3;?>" data-pie-size="50">
                                                                        <span class="percent percent-sign">35</span>
                                                                </div>
                                                                <span class="easy-pie-title"> เฉลี่ยรับผู้โดยสาร <i class="<?php echo $agTrip4;?>"></i> </span>
                                                                <ul class="smaller-stat hidden-sm pull-right">
                                                                        <li>
                                                                                <span class="label bg-color-greenLight"><i class="fa fa-caret-up"></i> 97%</span>
                                                                        </li>
                                                                        <li>
                                                                                <span class="label bg-color-blueLight"><i class="fa fa-caret-down"></i> 44%</span>
                                                                        </li>
                                                                </ul>
                                                                <div class="sparkline txt-color-greenLight hidden-sm hidden-md pull-right" data-sparkline-type="line" data-sparkline-height="33px" data-sparkline-width="70px" data-fill-color="transparent">
                                                                        130, 187, 250, 257, 200, 210, 300, 270, 363, 247, 270, 363, 247
                                                                </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                                <div class="easy-pie-chart txt-color-greenLight" data-percent="78.9" data-pie-size="50">
                                                                        <span class="percent percent-sign">78.9 </span>
                                                                </div>
                                                                <span class="easy-pie-title"> Disk Space <i class="fa fa-caret-down icon-color-good"></i></span>
                                                                <ul class="smaller-stat hidden-sm pull-right">
                                                                        <li>
                                                                                <span class="label bg-color-blueDark"><i class="fa fa-caret-up"></i> 76%</span>
                                                                        </li>
                                                                        <li>
                                                                                <span class="label bg-color-blue"><i class="fa fa-caret-down"></i> 3%</span>
                                                                        </li>
                                                                </ul>
                                                                <div class="sparkline txt-color-blue hidden-sm hidden-md pull-right" data-sparkline-type="line" data-sparkline-height="33px" data-sparkline-width="70px" data-fill-color="transparent">
                                                                        257, 200, 210, 300, 270, 363, 130, 187, 250, 247, 270, 363, 247
                                                                </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                                <div class="easy-pie-chart txt-color-blue" data-percent="23" data-pie-size="50">
                                                                        <span class="percent percent-sign">23 </span>
                                                                </div>
                                                                <span class="easy-pie-title"> Transfered <i class="fa fa-caret-up icon-color-good"></i></span>
                                                                <ul class="smaller-stat hidden-sm pull-right">
                                                                        <li>
                                                                                <span class="label bg-color-darken">10GB</span>
                                                                        </li>
                                                                        <li>
                                                                                <span class="label bg-color-blueDark"><i class="fa fa-caret-up"></i> 10%</span>
                                                                        </li>
                                                                </ul>
                                                                <div class="sparkline txt-color-darken hidden-sm hidden-md pull-right" data-sparkline-type="line" data-sparkline-height="33px" data-sparkline-width="70px" data-fill-color="transparent">
                                                                        200, 210, 363, 247, 300, 270, 130, 187, 250, 257, 363, 247, 270
                                                                </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                                <div class="easy-pie-chart txt-color-darken" data-percent="36" data-pie-size="50">
                                                                        <span class="percent degree-sign">36 <i class="fa fa-caret-up"></i></span>
                                                                </div>
                                                                <span class="easy-pie-title"> Temperature <i class="fa fa-caret-down icon-color-good"></i></span>
                                                                <ul class="smaller-stat hidden-sm pull-right">
                                                                        <li>
                                                                                <span class="label bg-color-red"><i class="fa fa-caret-up"></i> 124</span>
                                                                        </li>
                                                                        <li>
                                                                                <span class="label bg-color-blue"><i class="fa fa-caret-down"></i> 40 F</span>
                                                                        </li>
                                                                </ul>
                                                                <div class="sparkline txt-color-red hidden-sm hidden-md pull-right" data-sparkline-type="line" data-sparkline-height="33px" data-sparkline-width="70px" data-fill-color="transparent">
                                                                        2700, 3631, 2471, 2700, 3631, 2471, 1300, 1877, 2500, 2577, 2000, 2100, 3000
                                                                </div>
                                                        </div>
                                                </div>

                                            </div>
                                                <!-- end s1 tab pane -->

            <div class="tab-pane fade" id="s2">
                <div class="widget-body-toolbar bg-color-white">

                    <form class="form-inline" role="form">

                        <div class="form-group">
                            <label class="sr-only" for="s123">Show From</label>
                            <input type="email" class="form-control input-sm" id="s123" placeholder="Show From">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control input-sm" id="s124" placeholder="To">
                        </div>

                        <div class="btn-group hidden-phone pull-right">
                            <a class="btn dropdown-toggle btn-xs btn-default" data-toggle="dropdown"><i class="fa fa-cog"></i> More <span class="caret"> </span> </a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                        <a href="javascript:void(0);"><i class="fa fa-file-text-alt"></i> Export to PDF</a>
                                </li>
                                <li>
                                        <a href="javascript:void(0);"><i class="fa fa-question-sign"></i> Help</a>
                                </li>
                            </ul>
                        </div>

                    </form>
                </div>
                <div class="padding-10">
                    <div id="statsChart" class="chart-large has-legend-unique"></div>
                </div>

            </div>
                                                <!-- end s2 tab pane -->

            <div class="tab-pane fade" id="s3">

                    <div class="widget-body-toolbar bg-color-white smart-form" id="rev-toggles">

                            <div class="inline-group">

                                    <label for="gra-0" class="checkbox">
                                            <input type="checkbox" name="gra-0" id="gra-0" checked="checked">
                                            <i></i> Target </label>
                                    <label for="gra-1" class="checkbox">
                                            <input type="checkbox" name="gra-1" id="gra-1" checked="checked">
                                            <i></i> Actual </label>
                                    <label for="gra-2" class="checkbox">
                                            <input type="checkbox" name="gra-2" id="gra-2" checked="checked">
                                            <i></i> Signups </label>
                            </div>

                            <div class="btn-group hidden-phone pull-right">
                                    <a class="btn dropdown-toggle btn-xs btn-default" data-toggle="dropdown"><i class="fa fa-cog"></i> More <span class="caret"> </span> </a>
                                    <ul class="dropdown-menu pull-right">
                                            <li>
                                                    <a href="javascript:void(0);"><i class="fa fa-file-text-alt"></i> Export to PDF</a>
                                            </li>
                                            <li>
                                                    <a href="javascript:void(0);"><i class="fa fa-question-sign"></i> Help</a>
                                            </li>
                                    </ul>
                            </div>

                    </div>

                    <div class="padding-10">
                            <div id="flotcontainer" class="chart-large has-legend-unique"></div>
                    </div>
            </div>
                                                <!-- end s3 tab pane -->
                                        </div>

                                        <!-- end content -->
                                    </div>

				</div>
				<!-- end widget div -->
			</div>
			<!-- end widget -->

		</article>
	</div>

	<!-- end row -->

	<!-- row -->
        <div class="row">
            <article class="col-sm-12 ">
                <div class="jarviswidget" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-map-marker"></i> </span>
                        <h2>Daily report</h2>
                    </header>
                    <div>
                        <div class="col-sm-12 well"> 
                            <div class="col-sm-6" id="div1">
                            <table class="highchart table table-hover table-bordered" data-graph-container=".. .. .highchart-container2" data-graph-type="column">
                              <caption>ยอดสรุปประจำเดือน</caption>
                              <thead>
                                <tr>
                                  <th>Month</th>
                                  <th class="">จำนวนรถ</th>
                                  <th class="">ระยะทางทั้งหมดที่วิ่ง</th>
                                  <th class="">ระยะทาง รับผู้โดยสาร</th>
                                  <th class="">จำนวนครั้งในการรับผู้โดยสาร</th>
                                  <th class="">รวมรายได้</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php echo $trG;?>
                              </tbody>
                            </table>
                            </div>
                                <div class="col-sm-12" id="div2">
                                        <div class="highchart-container2"></div>
                                </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
	<div class="row">

		<article class="col-sm-12 ">

			<!-- new widget -->
			<div class="jarviswidget" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false">
                            <header>
                                    <span class="widget-icon"> <i class="fa fa-map-marker"></i> </span>
                                    <h2>Daily report</h2>

                            </header>
				<!-- widget options:
				usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

				data-widget-colorbutton="false"
				data-widget-editbutton="false"
				data-widget-togglebutton="false"
				data-widget-deletebutton="false"
				data-widget-fullscreenbutton="false"
				data-widget-custombutton="false"
				data-widget-collapsed="true"
				data-widget-sortable="false"

				-->
                                <div>
                                    <div class="widget-body no-padding " id="s4">
                                    <!--<div class="tab-pane fade active in padding-10 no-padding-bottom" id="s4">-->
                                            <!-- content goes here -->
                                        <table class="table table-striped table-hover table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>วันที่</th>
                                                    <th>จำนวนรถ</th>
                                                    <th class="text-align-center">ระยะทางทั้งหมดที่วิ่ง</th>
                                                    <th class="text-align-center hidden-xs">ระยะทาง รับผู้โดยสาร</th>
                                                    <th class="text-align-center hidden-xs">จำนวนครั้งในการรับผู้โดยสาร</th>
                                                    <th class="text-align-center">รวมรายได้</th>
                                                    <th class="text-align-center">Graphic</th>
                                                </tr>
                                            </thead>
                                                <tbody><tr><td>
                                                <?php echo $tr;?>
                                                    </td></tr>
                                                <?php echo $inMax;?>
                                                </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan=5>
                                                    <ul class="pagination pagination-xs no-margin">
                                                        <li class="prev disabled">
                                                            <a href="javascript:void(0);">Previous</a>
                                                        </li>
                                                        <li class="active">
                                                            <a href="javascript:void(0);">1</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);">2</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);">3</a>
                                                        </li>
                                                        <li class="next">
                                                            <a href="javascript:void(0);">Next</a>
                                                        </li>
                                                    </ul></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <!-- end content -->
                                    </div>
                                </div>
        
                                <!--<div>
                                    <div class="widget-body no-padding " id="s41">
                                        <table class="table table-striped table-hover table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>ceil</th>
                                                    <th>value</th>
                                                    
                                                </tr>
                                            </thead>
                                                <tbody><tr><td>
                                                        <?php// echo $trCeil;?>
                                                    </td></tr>
                                                </tbody>
                                        </table>
                                    </div>
                                </div>-->
                                
				<!-- widget div-->
				
					<!-- widget edit box -->
                                
					<!-- end widget edit box -->

                                    <!--<div class="widget-body no-padding" id="s4">-->
                                    
                                    <!--<div class="widget-body no-padding" id="s5">-->
                                    
                                    
				
				<!-- end widget div -->
			</div>
			<!-- end widget -->

			<!-- new widget -->
			
			<!-- end widget -->
		</article>
	</div>
	<!-- end row -->
        
</section>
<!-- end widget grid -->

<script type="text/javascript">
	/* DO NOT REMOVE : GLOBAL FUNCTIONS!
	 *
	 * pageSetUp(); WILL CALL THE FOLLOWING FUNCTIONS
	 *
	 * // activate tooltips
	 * $("[rel=tooltip]").tooltip();
	 *
	 * // activate popovers
	 * $("[rel=popover]").popover();
	 *
	 * // activate popovers with hover states
	 * $("[rel=popover-hover]").popover({ trigger: "hover" });
	 *
	 * // activate inline charts
	 * runAllCharts();
	 *
	 * // setup widgets
	 * setup_widgets_desktop();
	 *
	 * // run form elements
	 * runAllForms();
	 *
	 ********************************
	 *
	 * pageSetUp() is needed whenever you load a page.
	 * It initializes and checks for all basic elements of the page
	 * and makes rendering easier.
	 *
	 */

        var flot_updating_chart, flot_statsChart, flot_multigraph, calendar;

	pageSetUp();
        
        $("#div1").hide();
        $("#div31").hide();
	var inmax = $("#inmax").val();
        var max = 0, maxDist=100000;
        var cnt=0;
        var row="";
        var rowDist="";
        if(inmax>0){
            for(var i=0;i<inmax;i++){
                var tripcnt = parseInt($("#in"+i).val());
                var cnt = parseInt($("#inCnt"+i).val());
                var distAll = parseInt($("#inDistAll"+i).val());
                var distTrip = parseInt($("#inDistTrip"+i).val());
                var tripcnt1 = tripcnt/cnt;
                var dist = (distAll - distTrip)/cnt;
                if(tripcnt1>max){
                    max = tripcnt1;
                    row = i;
                    //alert("max  "+max);
                }
                if(dist<maxDist){
                    maxDist = dist;
                    rowDist = i;
                }
            }
        }
        $("#tr"+row).css({backgroundColor: "#AAC3CD", color: "#000"});
        $("#tr"+rowDist).css({backgroundColor: "#C8D0D3", color: "#000"});
        //$("#tr"+row).addClass("label bg-color-darken");
        //alert("max1 "+max);
	/*
	 * PAGE RELATED SCRIPTS
	 */

	// pagefunction
	
	var pagefunction = function() {
			
		$(".js-status-update a").click(function () {
		    var selText = $(this).text();
		    var $this = $(this);
		    $this.parents('.btn-group').find('.dropdown-toggle').html(selText + ' <span class="caret"></span>');
		    $this.parents('.dropdown-menu').find('li').removeClass('active');
		    $this.parent().addClass('active');
		});
		
		/*
		 * TODO: add a way to add more todo's to list
		 */
		
		// initialize sortable
		
	    $("#sortable1, #sortable2").sortable({
	        handle: '.handle',
	        connectWith: ".todo",
	        update: countTasks
	    }).disableSelection();
		
		
		// check and uncheck
		$('.todo .checkbox > input[type="checkbox"]').click(function () {
		    var $this = $(this).parent().parent().parent();
		
		    if ($(this).prop('checked')) {
		        $this.addClass("complete");
		
		        // remove this if you want to undo a check list once checked
		        //$(this).attr("disabled", true);
		        $(this).parent().hide();
		
		        // once clicked - add class, copy to memory then remove and add to sortable3
		        $this.slideUp(500, function () {
		            $this.clone().prependTo("#sortable3").effect("highlight", {}, 800);
		            $this.remove();
		            countTasks();
		        });
		    } else {
		        // insert undo code here...
		    }
		
		})
		// count tasks
		function countTasks() {
		
		    $('.todo-group-title').each(function () {
		        var $this = $(this);
		        $this.find(".num-of-tasks").text($this.next().find("li").size());
		    });
		
		}
		
		/*
		 * RUN PAGE GRAPHS
		 */
                getCar();
                function getCar(){
                    $.ajax({
                        type: 'GET', url: 'getAmphur.php', contentType: "application/json", dataType: 'text', 
                        data: { 'flagPage':"checkUser"
                        ,'staff_username': $("#username").val()}, 
                        success: function (data) {
            //                alert('bbbbb'+data);
                            var json_obj = $.parseJSON(data);
                            for (var i in json_obj){
                                if((json_obj[i].staff_name_t!="") && (json_obj[i].rows!="0")) {
                                    $("#compAlert").removeClass("alert alert-block alert-success");
                                    $("#compAlert").addClass("alert alert-block alert-danger");
                                    $("#compAlert").empty();
                                    $("#compAlert").append("มี username นี้ ได้ถูกใช้งานแล้ว "+json_obj[i].staff_name_t);
                                    $("#compAlert").show();
                                }else{
                                    $("#compAlert").removeClass("alert alert-block alert-danger");
                                    $("#compAlert").addClass("alert alert-block alert-success");
                                    $("#compAlert").empty();
                                    $("#compAlert").append(" username นี้ OK ");
                                    $("#compAlert").show();
                                }
                            }
                        }
                    });
                }
		// load all flot plugins
		loadScript("js/plugin/flot/jquery.flot.cust.min.js", function(){
			loadScript("js/plugin/flot/jquery.flot.resize.min.js", function(){
				loadScript("js/plugin/flot/jquery.flot.time.min.js", function(){
					loadScript("js/plugin/flot/jquery.flot.tooltip.min.js", generatePageGraphs);
                                        loadScript("js/plugin/highChartCore/highcharts-custom.min.js", function(){
                                                loadScript("js/plugin/highchartTable/jquery.highchartTable.min.js", pagefunction1); 
                                        });
				});
			});
		});

		var pagefunction1 = function() {
                        // clears the variable if left blank
                        //alert("aaaa");
                        $('table.highchart').highchartTable();
                        //console.log("execute highchart")
                };
		function generatePageGraphs() {
		
		    /* TAB 1: UPDATING CHART */
		    // For the demo we use generated data, but normally it would be coming from the server
		
//		    var data = [],
//		        totalPoints = 200,
//		        $UpdatingChartColors = $("#updating-chart").css('color');
//		
//		    function getRandomData() {
//		        if (data.length > 0)
//		            data = data.slice(1);
//		
//		        // do a random walk
//		        while (data.length < totalPoints) {
//		            var prev = data.length > 0 ? data[data.length - 1] : 50;
//		            var y = prev + Math.random() * 10 - 5;
//		            if (y < 0)
//		                y = 0;
//		            if (y > 100)
//		                y = 100;
//		            data.push(y);
//		        }
//		
//		        // zip the generated y values with the x values
//		        var res = [];
//		        for (var i = 0; i < data.length; ++i)
//		            res.push([i, data[i]])
//		        return res;
//		    }
//		
//		    // setup control widget
//		    var updateInterval = 1500;
//		    $("#updating-chart").val(updateInterval).change(function () {
//		
//		        var v = $(this).val();
//		        if (v && !isNaN(+v)) {
//		            updateInterval = +v;
//		            $(this).val("" + updateInterval);
//		        }
//		
//		    });
//		
//		    // setup plot
//		    var options = {
//		        yaxis: {
//		            min: 0,
//		            max: 100
//		        },
//		        xaxis: {
//		            min: 0,
//		            max: 100
//		        },
//		        colors: [$UpdatingChartColors],
//		        series: {
//		            lines: {
//		                lineWidth: 1,
//		                fill: true,
//		                fillColor: {
//		                    colors: [{
//		                        opacity: 0.4
//		                    }, {
//		                        opacity: 0
//		                    }]
//		                },
//		                steps: false
//		
//		            }
//		        }
//		    };
//		
//		    flot_updating_chart = $.plot($("#updating-chart"), [getRandomData()], options);
//		
//		    /* live switch */
//		    $('input[type="checkbox"]#start_interval').click(function () {
//		        if ($(this).prop('checked')) {
//		            $on = true;
//		            updateInterval = 1500;
//		            update();
//		        } else {
//		            clearInterval(updateInterval);
//		            $on = false;
//		        }
//		    });
//		
//		    function update() {
//
//				try {
//			        if ($on == true) {
//			            flot_updating_chart.setData([getRandomData()]);
//			            flot_updating_chart.draw();
//			            setTimeout(update, updateInterval);
//			
//			        } else {
//			            clearInterval(updateInterval)
//			        }
//				}
//				catch(err) {
//				    clearInterval(updateInterval);
//				}
//		
//		    }
		
		    var $on = false;
		
		    /*end updating chart*/
		
		    /* TAB 2: Social Network  */
		
		    $(function () {
		        // jQuery Flot Chart
                        
		        var twitter = [ <?php echo $modeofmean1; ?>]
		        var facebook = [
		                [1, 25],
		                [2, 31],
		                [3, 45],
		                [4, 37],
		                [5, 38],
		                [6, 40],
		                [7, 47],
		                [8, 55],
		                [9, 43],
		                [10, 50],
		                [11, 47],
		                [12, 39],
		                [13, 47]
		            ],
		            data = [{
		                label: "Twitter",
		                data: twitter,
		                lines: {
		                    show: true,
		                    lineWidth: 1,
		                    fill: true,
		                    fillColor: {
		                        colors: [{
		                            opacity: 0.1
		                        }, {
		                            opacity: 0.13
		                        }]
		                    }
		                },
		                points: {
		                    show: true
		                }
		            }, {
		                label: "Facebook",
		                data: facebook,
		                lines: {
		                    show: true,
		                    lineWidth: 1,
		                    fill: true,
		                    fillColor: {
		                        colors: [{
		                            opacity: 0.1
		                        }, {
		                            opacity: 0.13
		                        }]
		                    }
		                },
		                points: {
		                    show: true
		                }
		            }];
		
		        var options = {
		            grid: {
		                hoverable: true
		            },
		            colors: ["#568A89", "#3276B1"],
		            tooltip: true,
		            tooltipOpts: {
		                //content : "Value <b>$x</b> Value <span>$y</span>",
		                defaultTheme: false
		            },
		            xaxis: {
		                ticks: [
		                    [1, "JAN"],
		                    [2, "FEB"],
		                    [3, "MAR"],
		                    [4, "APR"],
		                    [5, "MAY"],
		                    [6, "JUN"],
		                    [7, "JUL"],
		                    [8, "AUG"],
		                    [9, "SEP"],
		                    [10, "OCT"],
		                    [11, "NOV"],
		                    [12, "DEC"],
		                    [13, "JAN+1"]
		                ]
		            },
		            yaxes: {
		
		            }
		        };
		
		        flot_statsChart = $.plot($("#statsChart"), data, options);
		    });
		
		    // END TAB 2
		
		    // TAB THREE GRAPH //
		    /* TAB 3: Revenew  */
		
		    $(function () {
		
		        var trgt = [
		            [1354586000000, 153],
		            [1364587000000, 658],
		            [1374588000000, 198],
		            [1384589000000, 663],
		            [1394590000000, 801],
		            [1404591000000, 1080],
		            [1414592000000, 353],
		            [1424593000000, 749],
		            [1434594000000, 523],
		            [1444595000000, 258],
		            [1454596000000, 688],
		            [1464597000000, 364]
		        ],
		            prft = [
		                [1354586000000, 53],
		                [1364587000000, 65],
		                [1374588000000, 98],
		                [1384589000000, 83],
		                [1394590000000, 980],
		                [1404591000000, 808],
		                [1414592000000, 720],
		                [1424593000000, 674],
		                [1434594000000, 23],
		                [1444595000000, 79],
		                [1454596000000, 88],
		                [1464597000000, 36]
		            ],
		            sgnups = [
		                [1354586000000, 647],
		                [1364587000000, 435],
		                [1374588000000, 784],
		                [1384589000000, 346],
		                [1394590000000, 487],
		                [1404591000000, 463],
		                [1414592000000, 479],
		                [1424593000000, 236],
		                [1434594000000, 843],
		                [1444595000000, 657],
		                [1454596000000, 241],
		                [1464597000000, 341]
		            ],
		            toggles = $("#rev-toggles"),
		            target = $("#flotcontainer");
		
		        var data = [{
		            label: "Target Profit",
		            data: trgt,
		            bars: {
		                show: true,
		                align: "center",
		                barWidth: 30 * 30 * 60 * 1000 * 80
		            }
		        }, {
		            label: "Actual Profit",
		            data: prft,
		            color: '#3276B1',
		            lines: {
		                show: true,
		                lineWidth: 3
		            },
		            points: {
		                show: true
		            }
		        }, {
		            label: "Actual Signups",
		            data: sgnups,
		            color: '#71843F',
		            lines: {
		                show: true,
		                lineWidth: 1
		            },
		            points: {
		                show: true
		            }
		        }]
		
		        var options = {
		            grid: {
		                hoverable: true
		            },
		            tooltip: true,
		            tooltipOpts: {
		                //content: '%x - %y',
		                //dateFormat: '%b %y',
		                defaultTheme: false
		            },
		            xaxis: {
		                mode: "time"
		            },
		            yaxes: {
		                tickFormatter: function (val, axis) {
		                    return "$" + val;
		                },
		                max: 1200
		            }
		
		        };
		
		        flot_multigraph = null;
		
		        function plotNow() {
		            var d = [];
		            toggles.find(':checkbox').each(function () {
		                if ($(this).is(':checked')) {
		                    d.push(data[$(this).attr("name").substr(4, 1)]);
		                }
		            });
		            if (d.length > 0) {
		                if (flot_multigraph) {
		                    flot_multigraph.setData(d);
		                    flot_multigraph.draw();
		                } else {
		                    flot_multigraph = $.plot(target, d, options);
		                }
		            }
		
		        };
		
		        toggles.find(':checkbox').on('change', function () {
		            plotNow();
		        });

		        plotNow()
		
		    });
		
		}
		/*
		 * VECTOR MAP
		 */
		
		data_array = {
		    "US": 4977,
		    "AU": 4873,
		    "IN": 3671,
		    "BR": 2476,
		    "TR": 1476,
		    "CN": 146,
		    "CA": 134,
		    "BD": 100
		};
		
		
	
	};
	
	// end pagefunction

	// destroy generated instances 
	// pagedestroy is called automatically before loading a new page
	// only usable in AJAX version!
        
	var pagedestroy = function(){
		
		// destroy calendar
		calendar.fullCalendar('destroy');
		calendar = null;

		//destroy flots
		flot_updating_chart.shutdown();  
		flot_updating_chart=null;
		flot_statsChart.shutdown(); 
		flot_statsChart = null;

		flot_multigraph.shutdown(); 
		flot_multigraph = null;

		// destroy vector map objects
		$('#vector-map').find('*').addBack().off().remove();

		// destroy todo
		$("#sortable1, #sortable2").sortable("destroy");
		$('.todo .checkbox > input[type="checkbox"]').off();

		// destroy misc events
		$("#rev-toggles").find(':checkbox').off();
		$('#chat-container').find('*').addBack().off().remove();

		// debug msg
		if (debugState){
			root.console.log("✔ Calendar, Flot Charts, Vector map, misc events destroyed");
		} 

	}

	// end destroy
	
	// run pagefunction on load
	pagefunction();
	
	
</script>
