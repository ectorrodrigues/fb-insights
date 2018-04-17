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
    
    <script src="https://use.fontawesome.com/a0bf7d3b26.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    
    <title>FB Insights</title>
</head>


<?php

	require('Facebook/autoload.php');

	$object_id = '593412144015732';
	$access_token = 'EAACEdEose0cBAC8BGhgBge0RRAVFZAqulTuxSxCpkMVc9r5TkKVofAJEpCwnAZAcQc66ITdNaf3FvQDKedurYN7lxZCYWqCY95uDPCDdVFzDbMJRujXiAc4Cte6z4kreNq4NsdAXRpTfJYYPebWvHkJymETv8fTKYE7dPFpMzzzJiS9mjvkdLCia0P2mKV3bvnuZCMOUkwZDZD';
	$metric = 'page_impressions';
	$since = '2018-04-01';
	$until = '2018-04-16';

	$date1 = date_create($until);
	$date2 = date_create($since);
	$date_diff = date_diff($date1, $date2);
	// echo $date_diff->days;

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

	$i = 0;
	$values = '0% 100%, ';
	foreach ($values_array as $row) {
		$x_pos = ($i*100)/($numrows-1);
		$y_pos = ($row*100)/$highest;
		$i++;

		$values .= $x_pos.'% '.(100-$y_pos).'%, ';
	}

	$values = 'clip-path: polygon('.$values.'100% 100%);';


?>


<style type="text/css">
	body{
		font-family: 'Montserrat', sans-serif;
		font-weight: 400;
		color: #666;
	}

	.row{
		padding: 20px 0;
	}

	.default-width{
		width: 700px;
		display: inline-table;
	}

	.graph{
		display: inline-block;
  		position: relative;
		width: 702px;
		height: 150px;
		margin-bottom: -140px;
		background: -webkit-linear-gradient(top, #52a5e5 0%,#57f28a 100%);
  		box-sizing: border-box;
	}

	.graph:before {
	  	content: '';
	  	width: 700px;
	  	height: 150px;
	  	<?=$values?>
	  	display: block;
	  	position: absolute;
	  	top: 2px;
	  	left: 1px;

	  	background: -webkit-linear-gradient(top, #52a5e5 0%,#57f28a 100%);
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

	.chart {
	    width:700px;
	    height: 1px;
	    margin: 5px 10px 50px 0px;
	    position: relative;
	  }
	.chart:after {
	    content:' ';
	    display:block;
	    border:0.5px solid #999;
	    position:relative;
	    top:1px;
	    left: -2px;
	}

	.tick {
	  	border-left: 1px solid #999;
	  	height: 5px;
	  	top: 1px;
	  	position: absolute;
	}

	.tick > span {
	  position:relative;
	  left: -10px;
	  top: 26px;
	  font: 0.6em Arial, Helvetica, sans-serif;
	  transform: rotate(-90deg);
	}

	.separator_dash{
		padding: 0 30px;
	}

</style>


<div class="container text-center">
	<div class="row text-center default-width">

		<div class="y-axis">
			<div class="y-axis-label">
				<span class="start"><?=$highest?></span>
			</div>
			<div class="y-axis-label">
				<span class="center"><?=($highest-($highest*0.25))?></span>
			</div>
			<div class="y-axis-label">
				<span class="center"><?=($highest/2)?></span>
			</div>
			<div class="y-axis-label">
				<span class="center"><?=($highest-($highest*0.75))?></span>
			</div>
			<div class="y-axis-label">
				<span class="end">0</span>
			</div>

			<?php
				
			?>

		</div>

		<div class="graph" style="<?=$values?>">
		</div>

		<div class="x-axis text-left">
			<?php

				$x = 1;

				$chart_x_style = '<style>';
				$divisions = (700/($numrows-1));
				$divisions_result = '-2';
				$tick = '';

				foreach ($label_bottom_array as $row) {
					
					$chart_x_style .= ' .tick:nth-child('.$x.'){ left: '.($divisions_result-1.66).'px ; }';
					$divisions_result = $divisions*$x;
					$tick .= '<div class="tick"><span>'.$row.'</span></div>';
					$x++;
				}

				$chart_x_style .= '</style>';
			?>
		</div>

		<?= $chart_x_style ?>

		<div class="chart">
			<?= $tick ?>
		</div>

	</div>

	<div class="infos default-width text-right">
		Total: <strong><?= $total ?></strong>
		<span class="separator_dash"> | </span>    
		Média: <strong><?= str_replace(".", ",", number_format(($total/$numrows), 2)); ?></strong><br />
	</div>

</div>