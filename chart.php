<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="cache-control" content="no-store, no-cache, must-revalidate, Post-Check=0, Pre-Check=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,400i,500,600,700,700i,900" rel="stylesheet">
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    
    <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <style type="text/css">
    	body{
			font-family: "Montserrat", sans-serif;
			font-weight: 400;
			color: #666;
		}

		.row{
			padding: 25px 0 50px 0;
		    border-bottom: solid;
		    border-bottom-width: 2px;
		}

		.w-100{
			width: 100%;
		}

		.default-width{
			width: 700px;
			display: inline-table;
		}

		small{
			font-size: 75%;
			font-style: italic;
			color:#bbb;
		}

		h2{
			font-size: 20px;
			font-weight: 700;
			margin-bottom: 40px;
		}

		.media-body{
			vertical-align: middle;
			padding-left: 15px;
		}

		.title{
			font-size: 23px;
			font-weight: 700;
			margin: 0 !important;
		}

		.mt{
			margin-top:30px;
		}

		.x-axis{
			width: 700px;
			height: auto;
			text-align: justify;
		}

		.y-axis{
			width: 15px;
			height: 150px;
			margin-left: -40px;
			padding-right: 5px;
			display: inline-table;
			text-align: -webkit-right;
			border-right: solid;
			border-right-style: solid;
			border-right-width: 1px;
			border-right-color: #ccc;
		}

		.y-axis-label{
			height: 20%;
			display: table;
			text-align: right;
			font-size: 10px;
		}

		.y-axis-label .start{
			align-self: flex-start;
			text-align: right;
		}

		.y-axis-label .center{
			text-align: right;
			display: table-cell;
			vertical-align: middle;
		}

		.y-axis-label .end{
			display: table-cell;
			vertical-align: bottom;
			text-align: right;
		}

		.x_pos_label{
			position: relative;
			display: inline-block;
			transform: rotate(-90deg);
			font-size: 10px;
			margin-top: 15px;
		}

		.chart_labels {
		    width:700px;
		    height: 1px;
		    margin: 5px 10px 50px 0px;
		    position: relative;
		 }

		.chart_labels:after {
		    content:' ';
		    display:block;
		    border:0.5px solid #999;
		    position:relative;
		    top:1px;
		    left: -2px;
		}

		[class^="tick"] {
		  	border-left: 1px solid #999;
		  	height: 5px;
		  	top: 1px;
		  	position: absolute;
		}

		[class^="tick"] > span {
		  position:relative;
		  left: -10px;
		  top: 15px;
		  font: 0.6em Arial, Helvetica, sans-serif;
		}

		.separator_dash{
			padding: 0 30px;
		}

		.trend_line{
			position: absolute;
			margin-left: -700px;
		}
    </style>
    
    
    <title>FB Insights</title>
</head>


<body>

	<script>
	  window.fbAsyncInit = function() {
	    FB.init({
	      appId      : '124674048314985',
	      cookie     : true,
	      xfbml      : true,
	      version    : 'v2.12'
	    });
	      
	    FB.AppEvents.logPageView();   
	      
	  };

	  (function(d, s, id){
	     var js, fjs = d.getElementsByTagName(s)[0];
	     if (d.getElementById(id)) {return;}
	     js = d.createElement(s); js.id = id;
	     js.src = "https://connect.facebook.net/en_US/sdk.js";
	     fjs.parentNode.insertBefore(js, fjs);
	   }(document, 'script', 'facebook-jssdk'));
	</script>

<?php

require('Facebook/autoload.php');

$page		= $_POST['page'];
$since 		= $_POST['since'];
$until 		= $_POST['until'];

function db () {
	static $conn;

	$servername	= 'localhost';
	$dbname		= 'fb_insights';
	$username	= 'root';
	$password	= '';
							
	$conn = new PDO("mysql:host=".$servername.";dbname=".$dbname, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	return $conn;
}

$conn = db();

foreach($conn->query("SELECT * FROM pages WHERE id = '".$page."' ") as $row) {
	$pageid 	= $row['page_id'];
	$pagetitle 	= $row['title'];
	$pageimg 	= $row['img'];
}

?>
<div class="w-100 text-center mt">

	<div class="media text-left default-width">
  		<img class="align-self-center mr-3" src="img/<?= $pageimg ?>" alt="Logo" width="90">
  		<div class="media-body">
    		<div class="col-lg-12 text-left">
	    		Relatório de Mídias Sociais<br>
	    		<div class="title"><?= $pagetitle ?></div>
	    		<small class="mt-0 pt-0">
	    			<?= date('d/m/Y', strtotime($since)) ?> à <?= date('d/m/Y', strtotime($until)) ?>
	    		</small>
	    	</div>

	    	<div class="col-lg-6 text-right">
	    		
	    	</div>

    	</div>
	</div>

</div>

<?php

function create_chart($chart_number, $title, $metric){

	global $company;
	global $since;
	global $until;
	global $pageid;

	$object_id = $pageid;
	$access_token = 'EAABxYZCBczmkBABhfhcukA2KZC8xbxqwUkH69pUenulFdVFZAlssNXv4VDCrk9ZBspbrbfxurddknVsMisnoZAUZC9fxcWDNiM4wQ8RjFVi4T7UJwRoZCLCMQkOAc6ZCjLas68gmO5uat0oxflqFGcGHBHeZCwNoV8qSZCT6n6NlQooJBpath7GwPE';
	$metric = $metric;
	$since = $since;
	$until = $until;

	$datetime1 = date_create($since);
    $datetime2 = date_create($until);
    $diff = date_diff($datetime1, $datetime2);
    $diff = $diff->days;

	$url = 'https://graph.facebook.com/'.$object_id.'/insights/'.$metric.'/day/?since='.$since.'&until='.$until.'&access_token='.$access_token;

	$requestedInsights = file_get_contents($url);     
	$decodedObject = json_decode($requestedInsights);

	foreach ( $decodedObject->data as $key=>$rows ){

    	$val 				= $rows->values; 
    	$numrows 			= 0;
    	$highest 			= 0;
		$values_array 		= array();
		$label_bottom_array	= array();

      	foreach ( $val as $key2=>$rows2 ){

      		$val2 = $rows2; 
      		$date = str_replace("-", "/", substr($val2->end_time, 0, -14));
      		$date = date('d/m', strtotime('-1 day', strtotime($date)));
      		$numrows++;

      		$values_array[] = $val2->value;
      		$label_bottom_array[] = $date;

      		if($val2->value > $highest){
      			$highest = $val2->value;
      		}
      	}

	}

	$total = array_sum($values_array);
	$average = number_format(($total/$numrows), 2);

	$i = 0;
	$values = '0% 100%, ';
	foreach ($values_array as $row) {
		$x_pos = ($i*100)/($numrows-1);
		$y_pos = ($row*100)/$highest;
		$i++;

		$values .= $x_pos.'% '.(100-$y_pos).'%, ';
	}

	$values = 'clip-path: polygon('.$values.'100% 100%);';


    $since_past = date('Y-m-d', strtotime('-'.$diff.' day', strtotime($since)));
	$until_past = $since;

	$url_past = 'https://graph.facebook.com/'.$object_id.'/insights/'.$metric.'/day/?since='.$since_past.'&until='.$until_past.'&access_token='.$access_token;

	$requestedInsights_past = file_get_contents($url_past);     
	$decodedObject_past = json_decode($requestedInsights_past);

	foreach ( $decodedObject_past->data as $key=>$rows_past ){

    	$val_past 				= $rows_past->values; 
    	$numrows_past 			= 0;
		$values_array_past 		= array();

      	foreach ( $val_past as $key2=>$rows2_past ){

      		$val2_past = $rows2_past; 
      		$numrows_past++;
      		$values_array_past[] = $val2_past->value;
      	}

	}

	$total_past = array_sum($values_array_past);
	$average_past = number_format(($total_past/$numrows_past), 2);


echo '

<style type="text/css">

	.chart_body'.$chart_number.'{
		display: inline-block;
  		position: relative;
		width: 702px;
		height: 150px;
		margin-bottom: -140px;
  		box-sizing: border-box;
	}

	.chart_body'.$chart_number.':before {
	  	content: "";
	  	width: 700px;
	  	height: 150px;
	  	'.$values.'
	  	display: block;
	  	position: absolute;
	  	top: 2px;
	  	left: 1px;
	  	background: -webkit-linear-gradient(top, #52a5e5 0%,#57f28a 100%);
	}
	
';
	
if($diff > 32){
	echo '.tick'.$chart_number.':nth-child(2n+1) > span { top:5px; }';
}
	
echo '
</style>
';


echo '
	<div class="row text-center default-width">

		<h2 class="text-left"><i class="fas fa-angle-double-right"></i> '.$title.'</h2>

		<div class="y-axis">
			<div class="y-axis-label">
				<span class="start">'.$highest.'</span>
			</div>
			<div class="y-axis-label">
				<span class="center">'.($highest-($highest*0.25)).'</span>
			</div>
			<div class="y-axis-label">
				<span class="center">'.($highest/2).'</span>
			</div>
			<div class="y-axis-label">
				<span class="center">'.($highest-($highest*0.75)).'</span>
			</div>
			<div class="y-axis-label">
				<span class="end">0</span>
			</div>

		</div>

		<div class="chart_body'.$chart_number.'" style="'.$values.'">
		</div>
';

		echo '
		<svg class="trend_line" height="150" width="700">
		';

		$ytrend = (150-(($average_past*150)/$highest)); if($ytrend < 0 ){ $ytrend = '0'; }

		echo '	
		  	<line x1="0" y1="'.$ytrend.'" x2="700" y2="'.(150-(($average*150)/$highest)).'" style="stroke:rgb(128,128,128);stroke-width:0.5" />
		</svg>
		';

		echo '
		<div class="x-axis text-left">
		';
				$x = 1;

				$chart_x_style = '<style>';
				$divisions = (700/($numrows-1));
				$divisions_result = '-2';
				$tick = '';

				foreach ($label_bottom_array as $row) {
					
					$chart_x_style .= ' .tick'.$chart_number.':nth-child('.$x.'){ left: '.($divisions_result-1.66).'px ; }';
					$divisions_result = $divisions*$x;
					$tick .= '<div class="tick'.$chart_number.'"><span>'.$row.'</span></div>';
					$x++;
				}

				$chart_x_style .= '</style>';
		echo '	
		</div>
		';

		echo $chart_x_style;

		echo '
		<div class="chart_labels">
			'.$tick.'
		</div>
		';

		echo '
		<div class="infos default-width text-right">
			Total: <strong>'.$total.'</strong>
			<span class="separator_dash"> | </span>    
			Média: <strong>'.str_replace(".", ",", number_format(($total/$numrows), 2)).'</strong>
			<span class="separator_dash"> | </span> 
			%Variação <small>(mesmo período)</small>: 
		';

				if($total == 0){ $total = 1; }
				if($total_past == 0){ $total_past = 1; }
				
				$variation = str_replace(".", ",", number_format((($total*100)/$total_past)-100, 2)); 

				if($variation < 0){
					$variation_style = 'style="color:#f00;"';
					$variation_icon = '<i class="fas fa-caret-down"></i>';
				}
				else {
					$variation_style = 'style="color:#00d02d;"';
					$variation_icon = '<i class="fas fa-caret-up"></i>';
				}

				echo '
				<strong '.$variation_style.'> '.$variation.' '.$variation_icon.'</strong>
				';
		echo '		
		</div>

	</div>
		';

}

echo '<div class="container text-center">';

create_chart('1', 'Impressões', 'page_impressions');
create_chart('2', 'Alcance', 'page_impressions_unique');
create_chart('3', 'Consumos', 'page_consumptions');

echo '</div>';

//create_chart('4', 'Reações', 'page_actions_post_reactions_total');


?>

</body>

</html>