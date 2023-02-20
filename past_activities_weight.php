<?php
if(isset($_SESSION['name'])){
    header('location: login.php');
}
// Client Id
if(isset($_GET['id']) AND $_GET['id'] != ""){
    $clientId = $_GET['id'];
}else{
    header("Location: index.php");
}
// Configure Dates
date_default_timezone_set("Asia/Calcutta");
$today = new DateTime();

function fetchPastActivity($clientId,$query){
    // Connect to Database
    $conn = new mysqli("localhost", "root", "", "infits");
    if($conn->connect_error){
        die("Connection failed :" . $conn->connect_error);
    }
    
    // echo($query);
    $result = $conn->query($query) or die("Query Failed");
    $data = array();
    while($row = $result->fetch_assoc()){
        $data[] =  $row;
    }
    $conn->close();
    return ($data);
}

if(isset($_POST['dates'])){
     $list = '
     <div class="row">
        <div class="col">';
    $Custom_Day1 = new DateTime(substr($_POST['dates'][0],4,11));
    $Custom_Day2 = new DateTime(substr($_POST['dates'][1],4,11));
        while($Custom_Day2 >= $Custom_Day1){
            $query="SELECT * FROM weighttracker WHERE clientID= '$clientId' AND 
                    `date` >= '".$Custom_Day1->format('Y-m-d')." 00:00:00'
                    AND `date` <= '".$Custom_Day1->format('Y-m-d')." 23:59:59';";
            $CustomData = fetchPastActivity($clientId,$query);
            
            $count = count($CustomData);
            $i = 0;
    
            $list .= '<div class="activity-container">
                <p class="date">'. $Custom_Day1->format('d M Y') .'</p>';
                
                $Custom_Day1->modify("+1 day");
                if(empty($CustomData)){
                    $list.='<p> NO DATA FOUND </p></div>';
                    continue;
                }
                
                $list .= 
                '<div class="flex-box">';
                
                while($i<$count){ 
                    $I_date = new DateTime($CustomData[$i]['date']);
                
                $list .='<div class="meal-box">
                        <div class="left">
                            <img src="images/weight_meter.svg" alt="">
                            <div class="meal-title">
                                <p>BMI ' .$CustomData[$i]['bmi'] . '</p>
                                <span>'.$I_date->format('h:i A').'</span>
                            </div>
                        </div>
                        <div class="right">
                            <img src="images/weight_small.svg" alt="">
                            <p class="kcal">'.$CustomData[$i]['weight'].' Kg</p>
                        </div>
                    </div>';
                $i++; }
            $list.='</div>
            </div>';
         }
    
    $list .=
        '</div>
    </div>';
    echo ($list);
    exit();

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<?php include 'navbar.php' ?>
<style>
    .heading p {
    font-family: 'NATS';
    font-style: normal;
    font-weight: 400;
    font-size: 44px;
    line-height: 70px;
}
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
  position: relative;
}
#daterange {
    border: none;
    background: transparent;
    height: 0px;
    width: 0px;
    z-index: -1;
    position: absolute;
    left: 90px;
    top: 20px;
}
#daterange-btn{
    position: absolute;
    top: 5px;
    left: 92px;
}
.tab_button_side{
   border-radius: 12px;
}
/* Style the buttons that are used to open the tab content */
.tab {
  overflow: hidden;
  /* border: 1px solid #ccc;
  background-color: #f1f1f1; */
  border: 1px solid #F8F5F5;
  width: 365px;
height: 27px;
border-top-left-radius: 1em!important;
border-bottom-left-radius: 1em!important;
border-top-right-radius: 1em!important;
  border-bottom-right-radius: 1em!important;
}
.tab button {
    background: #FFFFFF;
    border: 1px solid #FCFBFB;
    border-radius: 0px;
    width: 85.35px;
height: 24px;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  /* padding: 14px 16px; */
  transition: 0.3s;
  font-family: 'NATS';
font-style: normal;
font-weight: 400;
font-size: 13px;
line-height: 27px;

color: #4D4D4D;
}
.graph_button_side{
    border: 1px solid #F8F5F5;
  border-top-right-radius: 1em!important;
  border-bottom-right-radius: 1em!important;
}
.graph_button_left{
  width: 106.69px !important;
border-top-left-radius: 1em!important;
border-bottom-left-radius: 1em!important;
}
/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #9CD1D0;
}
.tab button.active {
  background-color: #9CD1D0;
  color: white !important;
}

/* Style the tab content */
.tab-content {
  display: none;
  padding: 6px 12px;
  /* border: 1px solid #ccc; */
  border-top: none;
}

.content{
    padding:10px;
   
}
.top_bar{
    display: flex;
   flex-wrap:wrap;
}
.client-card {
        width: 70px;
        height: auto;
        margin: 10px;
        text-align: center;
        font-size: 20px;
        border-radius: 14px;
        padding: 5px;
}

.client-card p {
    font-size: 15px;
}

.client-card i {
    font-size: 15px;
}
.client-card-heart{
    background: linear-gradient(38.98deg, #768B93 7.65%, #8FC4C3 87.93%);
    border: 1px solid #E266A9;
    border-radius: 10px;
    margin: 10px 0 0 0;
    width: 97px;
    height: 114px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 15px;
}
.client-card-heart p{
    margin-bottom: 0;
    font-family: 'NATS';
    font-style: normal;
    font-weight: 400;
    font-size: 19px;
    line-height: 120%;
    /* or 23px */

    text-align: center;

    color: #FFFFFF;
}
/* -------------------Calorie Tab Content------------------- */
.activity-container{
    /* margin: 3%; */
    padding: 3%;
}
.activity-container p{
    font-family: 'NATS';
font-style: normal;
font-weight: 400;
font-size: 25px;
line-height: 30px;
/* identical to box height */
color: #000000;
}
.flex-box {
    display: flex;
    gap: 25px;
    flex-wrap: wrap;
    padding: 5px 30px;
}
.meal-box {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 311px;
    height: 67px;
    padding: 20px;
    background: linear-gradient(181.98deg, rgba(218, 240, 240, 0.2) 1.67%, rgba(86, 107, 115, 0.2) 98.33%);
    border-radius: 10px;
}
.meal-box p{
    margin-bottom: 0;
}
.left,
.right{
    display: flex;
    gap: 20px;
    /* flex-direction: row; */
}
.left span{
    font-family: 'NATS';
font-style: normal;
font-weight: 400;
font-size: 17px;
/* line-height: 36px; */
/* identical to box height */


color: #000000;

}
.right p{
    font-size: 20px;
    line-height: 42px;
}
/* -----------------------Resposnive New----------------------- */
.ph-left{
    padding-left: 3%;
}
.ph-right {
    display: flex;
    justify-content: flex-end;
    padding-right: 5%;
}
@media (max-width:576px){
    .tab{
        display:flex;
        width: 100%;
        flex-wrap:wrap;
    }
    .tab button {
    width: 25%;
}
    .graph_button_left{
        width:25% !important;
    }
    /* anothr */
    .past-header{
        position:relative;
    }
    .ph-right{
        position:absolute;
        top: -45px;
        right: 5px;
        scale: 0.9;
        padding: 0;
    }
}
@media (max-width:330px){
    .past-header{
        position:relative;
    }
    .ph-right{
        position:absolute;
        top: -59px;
        right: -40px;
        scale: 0.65;
        padding: 0;
    }
}
</style>
<body>

    <div class="content">
        <!-- tab_links -->
        
        <div class="row past-header">
            <div class="col-sm-8 ph-left">
                <div class="heading">
                    <p>Past Activities</p>
                </div>
                <div class="tab">
                    <button id="custombtn" class="tablinks graph_button_left" onclick="openCity(event, 'London')">Custom Dates</button>
                    <input id="daterange"  type="date-range">
                    <i id="daterange-btn" class="drop fa-solid fa-caret-down"></i>
                    
                    
                    <button class="tablinks" onclick="openCity(event, 'Year')">Year</button>
                    <button class="tablinks" onclick="openCity(event, 'Month')">Month</button>
                    <button id="defauttab" class="tablinks graph_button_side" class="tab_button_side" onclick="openCity(event, 'Week')">Week</button>
                </div>
            </div>
            <div class="col-sm-4 ph-right">
                <!-- metric_button -->
                <a href="track_stats_weight.php?id=<?php echo($clientId) ?>">
                <div class="client-card client-card-heart " style="color:#7D5DE6; border: 1px solid #7D5DE6;">
                    <img src="images/weight_selected.svg" alt="">
                    <p>Weight</p>
                </div>
                </a>
            </div>
        </div>
                
        <!-- past_activities -->
        <div class="graph">

         <!-- Tab content -->
                                <!-- Custom Data -->
                                <div id="London" id="defaultOpen" class="tab-content">
                                    <div class="row">
                                        <div class="col">
                                        <?php
                                        $yearly_month = new DateTime();
                                        $yearly_last_month = new DateTime();
                                        $yearly_month->setDate($yearly_month->format('Y'),01,01);
                                        if($today->format('m') == '01'){
                                            $yearly_month->setDate($yearly_month->format('Y')-1,01,01);
                                            $yearly_last_month->setDate($yearly_last_month->format('Y')-1,12,31);
                                        }
                                        
                                        while($yearly_last_month >= $yearly_month){
                                            $yearly_Month_1 = $yearly_month->format('Y-m')."-"."01";
                                            $yearly_Month_2 =  $yearly_month->format('Y-m')."-". $yearly_month->format('t');
                                            $query="SELECT * FROM weighttracker WHERE clientID= '$clientId' AND 
                                                    `date` >= '".$yearly_Month_1." 00:00:00'
                                                    AND `date` <= '".$yearly_Month_2." 23:59:59';";
                                            $yearly_Data = fetchPastActivity($clientId,$query);
                                            
                                            $count = count($yearly_Data);
                                            $i = 0;
                                        ?>
                                            <div class="activity-container">
                                                <p class="date"><?php echo ($yearly_month->format('M Y')); ?></p>
                                                <?php 
                                                $yearly_month->modify("+1 Month");
                                                if(empty($yearly_Data)){
                                                    echo ("<p> NO DATA FOUND </p>");
                                                    echo ('</div>');
                                                    // echo('<br>');
                                                    continue;
                                                }
                                                ?>
                                                <div class="flex-box">
                                                <?php  
                                                while($i<$count){ 
                                                    $I_date = new DateTime($yearly_Data[$i]['date']);
                                                ?>
                                                    <div class="meal-box">
                                                        <div class="left">
                                                            <img src="images/weight_meter.svg" alt="">
                                                            <div class="meal-title">
                                                                <p>BMI <?php echo($yearly_Data[$i]['bmi']) ?></p>
                                                                <span><?php echo($I_date->format('h:i A d M')) ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="right">
                                                            <img src="images/weight_small.svg" alt="">
                                                            <p class="kcal"><?php echo($yearly_Data[$i]['weight']) ?> Kg</p>
                                                        </div>
                                                    </div>
                                                <?php $i++; } ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- Yearly Data -->
                                <div id="Year" class="tab-content">
                                    <div class="row">
                                        <div class="col">
                                        <?php
                                        $yearly_month = new DateTime();
                                        $yearly_last_month = new DateTime();
                                        $yearly_month->setDate($yearly_month->format('Y'),01,01);
                                        if($today->format('m') == '01'){
                                            $yearly_month->setDate($yearly_month->format('Y')-1,01,01);
                                            $yearly_last_month->setDate($yearly_last_month->format('Y')-1,12,31);
                                        }
                                        
                                        while($yearly_last_month >= $yearly_month){
                                            $yearly_Month_1 = $yearly_month->format('Y-m')."-"."01";
                                            $yearly_Month_2 =  $yearly_month->format('Y-m')."-". $yearly_month->format('t');
                                            $query="SELECT * FROM weighttracker WHERE clientID= '$clientId' AND 
                                                    `date` >= '".$yearly_Month_1." 00:00:00'
                                                    AND `date` <= '".$yearly_Month_2." 23:59:59';";
                                            $yearly_Data = fetchPastActivity($clientId,$query);
                                            
                                            $count = count($yearly_Data);
                                            $i = 0;
                                        ?>
                                            <div class="activity-container">
                                                <p class="date"><?php echo ($yearly_month->format('M Y')); ?></p>
                                                <?php 
                                                $yearly_month->modify("+1 Month");
                                                if(empty($yearly_Data)){
                                                    echo ("<p> NO DATA FOUND </p>");
                                                    echo ('</div>');
                                                    // echo('<br>');
                                                    continue;
                                                }
                                                ?>
                                                <div class="flex-box">
                                                <?php  
                                                while($i<$count){ 
                                                    $I_date = new DateTime($yearly_Data[$i]['date']);
                                                ?>
                                                    <div class="meal-box">
                                                        <div class="left">
                                                            <img src="images/weight_meter.svg" alt="">
                                                            <div class="meal-title">
                                                                <p>BMI <?php echo($yearly_Data[$i]['bmi']) ?></p>
                                                                <span><?php echo($I_date->format('h:i A d M')) ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="right">
                                                            <img src="images/weight_small.svg" alt="">
                                                            <p class="kcal"><?php echo($yearly_Data[$i]['weight']) ?> Kg</p>
                                                        </div>
                                                    </div>
                                                <?php $i++; } ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- Monthly Data -->
                                <div id="Month" class="tab-content">
                                    <div class="row">
                                        <div class="col">
                                        <?php
                                        $monthly_Month = new DateTime();
                                        $monthly_LastDay = new DateTime();
                                        $monthly_Month->modify("first day of this month");
                                        if($today->format('d') == '01'){
                                            $monthly_Month->modify("first day of previous month");
                                            $monthly_LastDay->modify("last day of previous month");
                                        }
                                        
                                        while($monthly_LastDay >= $monthly_Month){
                                            $query="SELECT * FROM weighttracker WHERE clientID= '$clientId' AND 
                                                    `date` >= '".$monthly_Month->format('Y-m-d')." 00:00:00'
                                                    AND `date` <= '".$monthly_Month->format('Y-m-d')." 23:59:59';";
                                            $monthly_Data = fetchPastActivity($clientId,$query);
                                            
                                            $count = count($monthly_Data);
                                            $i = 0;
                                        ?>
                                            <div class="activity-container">
                                                <p class="date"><?php echo ($monthly_Month->format('d M Y')); ?></p>
                                                <?php 
                                                $monthly_Month->modify("+1 day");
                                                if(empty($monthly_Data)){
                                                    echo ("<p> NO DATA FOUND </p>");
                                                    echo ('</div>');
                                                    // echo('<br>');
                                                    continue;
                                                }
                                                ?>
                                                <div class="flex-box">
                                                <?php  
                                                while($i<$count){ 
                                                    $I_date = new DateTime($monthly_Data[$i]['date']);
                                                ?>
                                                    <div class="meal-box">
                                                        <div class="left">
                                                            <img src="images/weight_meter.svg" alt="">
                                                            <div class="meal-title">
                                                                <p>BMI <?php echo($monthly_Data[$i]['bmi']) ?></p>
                                                                <span><?php echo($I_date->format('h:i A')) ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="right">
                                                            <img src="images/weight_small.svg" alt="">
                                                            <p class="kcal"><?php echo($monthly_Data[$i]['weight']) ?> Kg</p>
                                                        </div>
                                                    </div>
                                                <?php $i++; } ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- Weekly Data -->
                                <div id="Week" class="tab-content">
                                    <div class="row">
                                        <div class="col">
                                        <?php
                                        $weekly_Day = new DateTime();
                                        $weekly_Day->modify('previous monday');
                                        $weekly_lastDay =new DateTime();
                                        
                                        if($today->format('l')== "Monday"){
                                            $weekly_lastDay->modify('previous sunday');
                                        }
                                        
                                        while($weekly_Day <= $weekly_lastDay){
                                            $query="SELECT * FROM weighttracker WHERE clientID= '$clientId' AND 
                                                    `date` >= '".$weekly_Day->format('Y-m-d')." 00:00:00'
                                                    AND `date` <= '".$weekly_Day->format('Y-m-d')." 23:59:59';";
                                            $weekly_Data = fetchPastActivity($clientId,$query);
                                            
                                            $count = count($weekly_Data);
                                            $i = 0;
                                        ?>
                                            <div class="activity-container">
                                                <p class="date"><?php echo ($weekly_Day->format('d M Y')); ?></p>
                                                <?php 
                                                $weekly_Day->modify("+1 day");
                                                if(empty($weekly_Data)){
                                                    echo ("<p> NO DATA FOUND </p>");
                                                    echo ('</div>');
                                                    // echo('<br>');
                                                    continue;
                                                }
                                                ?>
                                                <div class="flex-box">
                                                <?php  
                                                while($i<$count){ 
                                                    $I_date = new DateTime($weekly_Data[$i]['date']);
                                                ?>
                                                    <div class="meal-box">
                                                        <div class="left">
                                                            <img src="images/weight_meter.svg" alt="">
                                                            <div class="meal-title">
                                                                <p>BMI <?php echo($weekly_Data[$i]['bmi']) ?></p>
                                                                <span><?php echo($I_date->format('h:i A')) ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="right">
                                                            <img src="images/weight_small.svg" alt="">
                                                            <p class="kcal"><?php echo($weekly_Data[$i]['weight']) ?> Kg</p>
                                                        </div>
                                                    </div>
                                                <?php $i++; } ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                       <script>
                                            function openCity(evt, cityName) {
                                                /* Declare all variables */
                                                var i, tabcontent, tablinks;
                    
                                                /* // Get all elements with class="tab-content" and hide them */
                                                tabcontent = document.getElementsByClassName("tab-content");
                                                for (i = 0; i < tabcontent.length; i++) {
                                                    tabcontent[i].style.display = "none";
                                                }
                    
                                                /* // Get all elements with class="tablinks" and remove the class "active" */
                                                tablinks = document.getElementsByClassName("tablinks");
                                                for (i = 0; i < tablinks.length; i++) {
                                                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                                                }
                    
                                                /* // Show the current tab, and add an "active" class to the button that opened the tab */
                                                document.getElementById(cityName).style.display = "block";
                                                evt.currentTarget.className += " active";
                                            }
                    
                                            /* // Get the element with id="defaultOpen" and click on it */
                                            // document.getElementById("defaultOpen").click();
                                            document.getElementById("defauttab").click();
                                            </script> 
            </div>
        </div>
<script>
const customTab = document.getElementById('London');
function Custom_Data(dates){
    $.ajax({
        type: "POST",
        url: "past_activities_weight.php?id=<?php echo ($clientId) ?>",
        data: {dates: dates},
        success: function(result) {
            customTab.innerHTML = "";
            customTab.innerHTML = result;
            document.getElementById("custombtn").click();
        }
    }
)}
            const date_btn = document.getElementById('daterange-btn');
            date_btn.addEventListener('click' , ()=>{
                fp.toggle();
            });
            const fp = flatpickr("input[type = date-range]", {
                maxDate: "today",
                dateFormat: "Y-m-d",
                mode: "range",
                onClose:[
                    function(selectedDates){
                        Custom_Data(selectedDates);
                    }
                ]
            });
</script>
</body>
</html>