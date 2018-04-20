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