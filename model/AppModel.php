<?php

function create_chart($chart_number, $title, $metric){

	global $company;
	global $since;
	global $until;
	global $pageid;

	//APP Authentication
	//$object_id = '549965328730238';
	//$access_token = 'EAABxYZCBczmkBAF8iYYPLDIcWKTZBVLrhNl1xAjSjJObtg08HsZBZCekCyVunMLaBPSilj28uMwPAeQRGpWfd3eFSg7qMZCadqwPDMivtCZBL4MYIiYjoQOAvFDkNucJmfEXG5rRRdTecodrVqfUEsrkrdCZAZBp1vVor3jDse118gZDZD';

	$object_id = $pageid;
	$access_token = 'EAACEdEose0cBAIWZBLGPHmw4UJZCZBXRRs20n5ZCsxUTbcii54QnJWonsTZCuMlj7jWRTTUqhKyDCT0jthPvfqys4UpEdrdFM9Oq2IRf7ZBj6BdQDmDYZBSP1S40OdL2sGtlHZCZCfuPvo6CPb22KZBLsZCmJZBgmFVU8O6sYwHyNTLOu0IUb3CcHWLw1uHC5xPz12fV2CS4MpZBvigZDZD';
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

      		if($metric == 'page_actions_post_reactions_total'){
      			$added_value = ($val2->value->like)+($val2->value->love)+($val2->value->like)+($val2->value->wow)+($val2->value->haha)+($val2->value->sorry)+($val2->value->anger);
      			$values_array[] = $added_value;
			}
			elseif($metric == 'page_positive_feedback_by_type' && $title == 'Compartilhamentos'){
				$values_array[] = $val2->value->link;
			}
			elseif($metric == 'page_positive_feedback_by_type' && $title == 'Comentários'){
				$values_array[] = $val2->value->comment;
			}
			elseif($metric == 'page_fan_adds_by_paid_non_paid_unique'){
				$values_array[] = $val2->value->total;
			}
			else {
				$values_array[] = $val2->value;
			}

      		$label_bottom_array[] = $date;

      		if($metric == 'page_actions_post_reactions_total'){
	      		if($added_value > $highest){
	      			$highest = $added_value;
	      		}
	      	}
	      	elseif($metric == 'page_positive_feedback_by_type' && $title == 'Compartilhamentos'){
	      		if($val2->value->link > $highest){
	      			$highest = $val2->value->link;
	      		}
	      	}
	      	elseif($metric == 'page_positive_feedback_by_type' && $title == 'Comentários'){
	      		if($val2->value->comment > $highest){
	      			$highest = $val2->value->comment;
	      		}
	      	}
	      	elseif($metric == 'page_fan_adds_by_paid_non_paid_unique'){
	      		if($val2->value->total > $highest){
	      			$highest = $val2->value->total;
	      		}
	      	}
	      	else{
	      		if($val2->value > $highest){
	      			$highest = $val2->value;
	      		}
	      	}
      	}

	}
	
	$total = array_sum($values_array);
	$average = number_format(($total/$numrows), 2);

	$i = 0;
	$values = '0% 100%, ';
	foreach ($values_array as $row) {

		if($highest == '0'){ $highest = '100';}

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

      		if($metric == 'page_actions_post_reactions_total'){
      			$added_value = ($val2_past->value->like)+($val2_past->value->love)+($val2_past->value->like)+($val2_past->value->wow)+($val2_past->value->haha)+($val2_past->value->sorry)+($val2_past->value->anger);
      			$values_array_past[] = $added_value;
			}
			elseif($metric == 'page_positive_feedback_by_type' && $title == 'Compartilhamentos'){
				$values_array_past[] = $val2_past->value->link;
			}
			elseif($metric == 'page_positive_feedback_by_type' && $title == 'Comentários'){
				$values_array_past[] = $val2_past->value->comment;
			}
			elseif($metric == 'page_fan_adds_by_paid_non_paid_unique'){
				$values_array_past[] = $val2_past->value->total;
			}
			else {
				$values_array_past[] = $val2_past->value;
			}

      	}

	}

	$total_past = array_sum($values_array_past);
	$average_past = number_format(($total_past/$numrows_past), 2);

	$results = file_get_contents('result.php');

	ob_start();
	echo eval($results);

	file_put_contents('output.php', ob_get_contents(), FILE_APPEND);

	ob_flush();

}

?>