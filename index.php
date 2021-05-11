	<?php

	// grab the form values from $_HTTP_POST_VARS hash	  
	extract($_POST);

	// League Table
	$leagueTable = file_get_contents("https://api.footystats.org/league-tables?key=example&league_id=1625");
	$leagueTable = json_decode($leagueTable, true);
	$leagueTable = $leagueTable['data']['all_matches_table_overall'];
		
	// GENERATION COMPUTATION - defines how many times the program manipulates data to calculate a prediction;
	// its not tested if this value will result in increased accuracy. 
	// 3 is the default - goes with the saying 'always try 3 times before giving up' xD
	$NumOfGenerations = 3;

	?>

<html>
<head>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
<style>
   
  

h1 {
  color: white;
  text-align: center;
}

p {
  font-family: verdana;
  font-size: 20px;
  color: white;
}

body {
 background-image: url("draft.jpg");
 color: white;
}


div.a {
  text-align: center;
      background-color: white;
  color: black;
  border: 10px solid white; /* Green */
}

div.b {
  text-align: center;
  color: black;
}


.a1 {
  border: 1px solid white; /* Green */
}

.a2 {
  border: 1px solid white; /* Green */
}

.a3 {
  border: 1px solid white; /* Green */
}

.a4 {
  border: 1px solid white; /* Green */
}



::-webkit-input-placeholder {
   text-align: center;
}

:-moz-placeholder { /* Firefox 18- */
   text-align: center;  
}

::-moz-placeholder {  /* Firefox 19+ */
   text-align: center;  
}

:-ms-input-placeholder {  
   text-align: center; 
}


/* width */
::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #888; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555; 
}

.b1 {
  text-align: center;
  color: black;
}

textarea {
  width: 50%;
  height: 150px;
  padding: 12px 20px;
  box-sizing: border-box;
  border: 2px solid #ccc;
  border-radius: 4px;
  background-color: #f8f8f8;
  resize: none;
  color: black;
}

/* Center the loader */
#loader {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 120px;
  height: 120px;
  margin: -76px 0 0 -76px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
}

#myDiv {
  display: none;
  text-align: center;
}
</style>
</head>
<body>
      <form method="post" action="<?php print $_SERVER['PHP_SELF']; ?>">	 
		<div class="a">	
	 
			<input class="a1" type="text" id="txtDate" name="txtDate" placeholder="DDMMYYYY">
			 
			<select class="a2" name="txtTeam1">
					<?php
					foreach ($leagueTable as $key => $team):
						//echo $team['name'];
						echo "<option>$team[name]</option>";
					endforeach
					?>	
			</select>
			
			<select class="a3" name="txtTeam2">
					<?php
					foreach ($leagueTable as $key => $team):
						//echo $team['name'];
						echo "<option>$team[name]</option>";
					endforeach
					?>
			</select>
			
			<input class="a4" type="submit" name="getDate" value="AI Predictor"/>
		</div>
      </form>
<?php 
	
	if(isset($getDate)) { 
	
   /* 
	* In this part of the code we process data that is sent though html form,
	* this part is essential for the functionally of  the entire program.
	*/
	$date_format = preg_split('//', $txtDate, -1, PREG_SPLIT_NO_EMPTY);
		
	//print_r($date_format);
	$date_formatx = $date_format[0].$date_format[1]."-".$date_format[2].$date_format[3]."-".$date_format[4].$date_format[5].$date_format[6].$date_format[7];
		
	//echo $date_formatx;
	$unix_date = strtotime($date_formatx);
	//echo $unix_date;

	$leagueTable2 = file_get_contents("https://api.footystats.org/league-tables?key=example&league_id=1625&max_time=".$unix_date);
	$leagueTable2 = json_decode($leagueTable2, true);
	$leagueTable2 = $leagueTable2['data']['all_matches_table_overall'];
		
	// keep select box value
	$selectOption1 = $_POST["txtTeam1"];
	$selectOption2 = $_POST["txtTeam2"];

	
 ?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<style>
	body {
		color: white;
	}
 
	table {
		width: 50%;
		font-size: 12px;
		color: white;
	    background-color: white;
	}
	table td {
		width: 50%;
		font-size: 12px;
		color: black;

	}
	
	table th {
		width: 50%;
		font-size: 12px;
		color: black;

	}
	
	.mb2 {
		margin-bottom: 1rem;
		color: red;
		  text-align: center;
	}


	

</style>

	<?php 
		
		
   /*
	*	In this part of the code we start to collect data, information that is based on the users input.
	*/
	$COUNTER = 0;
	$TEST_COUNTER = 0;
	$teams_storage = array();
	$L_G = 0;
	$L_C = 0;
	foreach ($leagueTable2 as $key => $team):
	$COUNTER++;
	?>
	
		<?php 
		$b1 = $team['seasonGoals_home'];
		$b2 = $team['seasonGoals_away']; 
		$TEMP_G = $b1 + $b2;

		if ($TEMP_G > $L_G) {
			$L_G = $TEMP_G;
		}
		else 
		{
			$L_G = $L_G;
		}
				
		$c1 = $team['seasonConceded_home'];
		$c2 = $team['seasonConceded_away']; 
		$TEMP_C = $c1 + $c2;

		if ($TEMP_C > $L_C) {
			$L_C = $TEMP_C;
		}
		else 
		{
			$L_C = $L_C;
		}

		if ($txtTeam1 == $team['name']) { 

			$T1_G = $TEMP_G;
			$T1_C = $TEMP_C;
			$T1_P = $COUNTER;
				 
		?>
		
			<?php 
			} else if ( $txtTeam2 == $team['name']) {
					
			$T2_G = $TEMP_G;
			$T2_C = $TEMP_C;
			$T2_P = $COUNTER;

			?>
				
			
			
				
	
			<?php 
				
			}
			else 
			{
				$TEST_COUNTER++;
				array_push($teams_storage, "$team[name],"."$team[matchesPlayed],"."$TEMP_G,"."$TEMP_C");
			}
				
			?>	

	<?php 
	endforeach ;
		
	/* 
	 *	create function avoid code duplication -> get team performances for each team. 
	 */
	function getPerformance(int $team_G, int $team_C, int $league_G, int $league_C ) {
					
		$attack_style = ($team_G/$league_G) * 100;		
		$defence_style = ($team_C/$league_C) * -100;
		$style_perf = $attack_style + $defence_style;
				
		return $style_perf;
				
	}
			
			
   /*
	* create threshold -> data is not useful if it cannot be compared to anything else
	* this threshold is used to measure the data and help to produce a relevant output.
	*
	*/
	$hello = array ();
	for ( $x = 0; $x <= $TEST_COUNTER - 1; $x++ ) {
		array_push($hello, explode(",", $teams_storage[$x]));
				
	}			
			
	$rnd_test1 = range(0, 8);
	shuffle($rnd_test1);
			
	$rnd_test2 = range(9, 17 );
	shuffle($rnd_test2);
			
	$TOTAl_test = 0;
	$hello2 = array();
	for ( $x = 0; $x <= $TEST_COUNTER - 8; $x++ ) {
				
		if ($x <= 8) {
			$T1_perf2 = getPerformance($hello[$rnd_test1[$x]][2],$hello[$rnd_test1[$x]][3],$L_G,$L_C);	
			$T2_perf2 = getPerformance($hello[$rnd_test2[$x]][2],$hello[$rnd_test2[$x]][3],$L_G,$L_C);
					
			if (($hello[$rnd_test1[$x]][2] - $hello[$rnd_test1[$x]][3]) <= 9) {	
				$perf1 = ($T1_perf2) + (($T2_perf2) / 2);
				$perf2 = ($T2_perf2) + (($T1_perf2) / 2);	
			}
			else 
			{			
				$perf1 = ($T1_perf2);
				$perf2 = ($T2_perf2);			
			}
					
			if ($perf1 > $perf2) {		
				$c = $perf1 - $perf2;
				array_push($hello2, $c);
			}
			else 
			{
				$c = $perf2 - $perf1;
				array_push($hello2, $c);
			}
		}	
	}
			
	// SET THRESHOLD 
	$league_profile = array_sum($hello2) / 8;
				
	// get team 1 statistics
	$T1_perf = getPerformance($T1_G,$T1_C,$L_G,$L_C);
			
	// get team 2 statistics
	$T2_perf = getPerformance($T2_G,$T2_C,$L_G,$L_C);
			
			
	$result = array();
	$winner_percentage = 0;
	$favourite_team = 0;
	$getT1_C_ex = 0;
	$getT1_G_ex = 0;
			
			
	for ($w = 0; $w < $NumOfGenerations; $w++) {
			
		// compare team 1 and 2 performances
		if (($T1_G - $T1_C) <= 9) {
					
			$perf1 = ($T1_perf) + (($T2_perf) / 2);
			$perf2 = ($T2_perf) + (($T1_perf) / 2);
			
		}
		else {
							
			$perf1 = ($T1_perf);
			$perf2 = ($T2_perf);
							
		}
					
		if ($perf1 > $perf2) {
					
			$Match_sim = $perf1 - $perf2;

		}
		else {
					
			$Match_sim = $perf2 - $perf1;
					
		}
					
		// set mutation rate 
		$mutate_test = rand(0,($league_profile));
		$mutate_test2 = rand(0,($league_profile));
				
		if ($mutate_test > $mutate_test2) {
					
			$Match_sim = $Match_sim + $mutate_test;
			
		}	
		else {
					
			$Match_sim = $Match_sim - $mutate_test2;
					
		}	
						
		// set bias 
		if ($T1_P > $T2_P) {
					
			if (($T1_P - $T2_P) >= 5 ) {
				$Match_sim = $Match_sim - ($mutate_test + $mutate_test2) * 0.10;
			}
			else if (($T1_P - $T2_P) >= 10 ) {
				$Match_sim = $Match_sim;
			}
			else if (($T1_P - $T2_P) >= 15 ) {
				$Match_sim = $Match_sim + ($mutate_test + $mutate_test2) * 0.50;
			}
		}
		else {
					
			if (($T2_P - $T1_P) >= 5 ) {
				$Match_sim = $Match_sim - ($mutate_test + $mutate_test2) * 0.10;
			}
			else if (($T2_P - $T1_P) >= 10 ) {
				$Match_sim = $Match_sim;
			}
			else if (($T2_P - $T1_P) >= 15 ) {
				$Match_sim = $Match_sim + ($mutate_test + $mutate_test2) * 0.50;
			}	
					
		}	
					
		// analyze statistics	 
					
		$getT1_CP = ($T1_C / $L_C) * 100;	
		$getT1_GP = ($T1_G / $L_G) * 100;	
					
		$getT2_CP = ($T2_C / $L_C) * 100;	
		$getT2_GP = ($T2_G / $L_G) * 100;		
					
							
					
		$set_threshold_check = 50;
					
			if ($T1_C < $T2_C ) {
				if ($getT1_CP > $set_threshold_check ) {
									
					if ($getT1_GP > $set_threshold_check) {
						$getT1_C_ex = "Expect ".$txtTeam1." to defend using a higher defensive line, but to remain strong defensively. ";
					}
					else 
					{
						$getT1_C_ex = "Expect ".$txtTeam1." to defend using a slightly deeper defensive line, this team balances attack/defence. ";								;
					}
				}
				else 
				{	
					if ($getT1_GP > $set_threshold_check) {
						$getT1_C_ex = "Expect ".$txtTeam1." to defend using a higher defensive line, this results in a very vulnerable defence. ";
					}
					else 
					{
						$getT1_C_ex = "Expect ".$txtTeam1." to defend using a slightly deeper defensive line, but the defence is still very vulnerable to better quality opposition. ";								;
					}
				}
			}
			else 
			{
				if ($getT2_CP < $set_threshold_check ) {
									
					if ($getT2_GP > $set_threshold_check) {
						$getT1_C_ex = "Expect ".$txtTeam2." to defend using a higher defensive line, but to remain strong defensively. ";
					}
					else 
					{
						$getT1_C_ex = "Expect ".$txtTeam2." to defend using a slightly deeper defensive line, this team balances attack/defence. ";								;
					}
				}
				else 
				{
					if ($getT2_GP > $set_threshold_check) {
						$getT1_C_ex = "Expect ".$txtTeam2." to defend using a higher defensive line, this results in a very vulnerable defence. ";
					}
					else 
					{
						$getT1_C_ex = "Expect ".$txtTeam2." to defend using a slightly deeper defensive line, but the defence is still very vulnerable to better quality opposition. ";								;
					}
				}
			}
						
			if ($T1_G > $T2_G ) {
				if ($getT1_GP > $set_threshold_check ) {		
					if ($getT1_CP < $set_threshold_check) {
						$getT1_G_ex = "Expect ".$txtTeam1." to pressure aggressively, with more ball possession and be dangerous on most attacks. ";
					}
					else 
					{
						$getT1_G_ex = "Expect ".$txtTeam1." to pressure conservatively, with more ball possession and be dangerous on most attacks. ";
					}
				}
				else 
				{
					if ($getT1_CP < $set_threshold_check) {
						$getT1_G_ex = "Expect ".$txtTeam1." to pressure aggressively, with more ball possession but fewer dangerous attacks. ";
					}
					else 
					{
						$getT1_G_ex = "Expect ".$txtTeam1." to pressure conservatively, with more ball possession but  fewer dangerous attacks. ";
					}
				}
			}
			else 
			{
				if ($getT2_GP > $set_threshold_check ) {
					if ($getT2_CP < $set_threshold_check) {
						$getT1_G_ex = "Expect ".$txtTeam2." to pressure aggressively, with more ball possession and be dangerous on most attacks. ";
					}
					else 
					{
						$getT1_G_ex = "Expect ".$txtTeam2." to pressure conservatively, with more ball possession and be dangerous on most attacks. ";
					}
				}
				else 
				{			
					if ($getT2_CP < $set_threshold_check) {
						$getT1_G_ex = "Expect ".$txtTeam2." to pressure aggressively, with more ball possession but fewer dangerous attacks. ";
					}
					else 
					{
						$getT1_G_ex = "Expect ".$txtTeam2." to pressure conservatively, with more ball possession but fewer dangerous attacks. ";
					}
				}
			}
						
		if ($T1_perf > $T2_perf) {
			$favourite_team = $txtTeam1;
		}		
		else
		{	
			$favourite_team = $txtTeam2;
		}
						

		$winner_percentage = round((abs($Match_sim - $league_profile)));
		$result[$w] = $winner_percentage;
		
	}
		?>
	
	<body onload="myFunction()" style="margin:0;">

<div id="loader"></div>

<div style="display:none;" id="myDiv" class="animate-bottom">


	<?php 
	// print results
	$FINAL_RESULT = abs(round(array_sum($result) / $NumOfGenerations));
	echo "<br>";
	echo "<br>";	
	echo "Tips: ";
	echo $getT1_C_ex."<br>".$getT1_G_ex;
	echo "<br>";
	echo "<br>";
	echo "<br>";
	echo $favourite_team." statistically is the favourite in this fixture.";
	echo "<br>";
	echo "This prediction measures that there is a ".$FINAL_RESULT."% chance of there being a winner in this fixture.";
	
}
	?>
 
<div class="container">

			<?php if(isset($getDate)) { ?>

			<h4 class="mb2">League Table
			<small class="mb2">EPL 2018/2019 Example run</small>
			</h4>
			
			<?php echo $selectOption1." vs ".$selectOption2;

			}			
			?>
				
			
</div>

<script>
var myVar;

function myFunction() {
  myVar = setTimeout(showPage, 1000);
}

function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("myDiv").style.display = "block";
}

</script>

</body>
</html>
