<html>
<head>
<style>
	.big{
		padding:30px;
	}
.set_goals_water{
	display: flex;
  flex-direction: column;
  align-items: center; 
  box-sizing: border-box;
padding: 10px;
position: absolute;
width: 329px;
height: 379px;
  background: #FFFFFF;
border: 1px solid #EFEFEF;
border-radius: 31px;
}
.set_goals_water>img{
  margin-top: 0px;
  margin-bottom: -20px;
  margin-right: 80px;
}
.set_goals_water>h3{
  
  font-style: normal;
  font-weight: 400;
  font-size: 32px;
  line-height: 68px;
  color: #000000;
  }
  .water_btn_selected{
  display: flex;
  flex-direction: column;
  align-items:center;
  justify-content:space-evenly;
  background: linear-gradient(216.13deg, #5CA7F8 9.2%, #ABB3F0 91.57%);
border: 1px solid #52A4FF;
border-radius: 10px;
width: 81.1px;
height: 96.19px;
}
.heart_btn_unselected{
	display: flex;
  flex-direction: column;
  align-items:center;
  justify-content:space-evenly;
  width: 81.1px;
height: 96.19px;

background: #FFFFFF;
border: 1px solid #E266A9;
border-radius: 10px;
}

/* circualrProgressBar */

</style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar menu With Sub-menus | Using HTML, CSS & JQuery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./styles/event_calendar.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="css/Recipies.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
		
</head>
<body>
  <?php include 'event_calendar.php'; ?>
  <div class="big">
  		<div class="row">
				<div class="col-sm-7">
					<div class="row">
						<div class="col-sm-6">
							<div class="heart">
								<div class="step_btn">
									<img src="images/steps.svg"> 
									<span>Step</span>
								</div>
								<div class="heart_btn_unselected">
									<img src="images/heart_unselected.svg"> 
									<span>Heart </span>
									<span>Rate</span>
								</div>
								<div class="water_btn_selected">
									<img src="images/water_selected.svg"> 
									<span>Water</span>
								</div>
							</div>
							
						</div>
						<div class="col-sm-6">
							<div class="heart">
								<div class="sleep_btn">
									<img src="images/sleep.svg"> 
									<span>Sleep</span>
								</div>
								<div class="weight_btn">
									<img src="images/weight.svg"> 
									<span>Heart </span>
									<span>Rate</span>
								</div>
								<div class="step_btn">
									<img src="images/steps.svg"> 
									<span>Sleep</span>
								</div>
							</div>
						</div>
					  </div>
					  <div class="graph">
					  
                        <br>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
            
                        <canvas id="myChart" ></canvas>
					</div>
                        <script>
                            var xValues = ['Sun', 'Mon','Tue','Wed','Thu','Fri','Sat'];
                            var yValues = [1000, 2000, 3000, 5000, 2000, 5000, 6000];
                
                            new Chart("myChart", {
                            type: "line",
                            data: {
                                labels: xValues,
                                datasets: [{
                                fill: false,
                                lineTension: 0,
                                backgroundColor: "#FF8B8B",
                                borderColor: "#FF8B8B",
                                data: yValues
                                }]
                            },
                            options: {
                                legend: {display: false},
                                scales: {
                                yAxes: [{ticks: {min: 1000, max:9000}}],
                                }
                            }
                        });
                        </script>
					
				</div>
				<div class="col-sm-5">
					<div class="goals_right">
						<div class="set_goals_water">
							<h3>Set Goals</h3>
							<img src="images/man_drinking_water.svg">
							<h2>Daily Water Consumption</h2>
							<div class="num_box">
								<p>0000</p>
							</div>
							<button id="set_goals_button" class="btn btn-primary" type="submit">Set</button>
						</div>
					</div>
				</div>
			  </div>
			  </div>
				
			</div>
			<div class="row">	
				<div class="col-sm-7">
						<div class="row">
							<div class="col-sm-6">
								<div class="heart_bottom">
									<div class="heart_info">
										<span>Daily Count</span>
										<span>72 BPM</span>
									</div>
									<div class="heart_info">
										
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="heart_bottom">
									<div class="heart_info">

									</div>
									<div class="heart_info">
										
									</div>
								</div>
							</div>
							
												
						</div>

					</div>
				<div class="col-sm-5">
					
					
				</div>	
			</div>			
	</div>
				
				
  </div>

 

</body>

</html>