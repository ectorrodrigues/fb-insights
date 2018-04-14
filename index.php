<?php

	require('Facebook/autoload.php');

	$object_id = '593412144015732';
	$access_token = 'EAACEdEose0cBAKQotI1pFNtoB4ysX1oOVDuyVXzMCVkm8nLVBxJ4EDgoHia5C0F5hAqLbgiYMvQoTH0k2IG38yZCkVeb28ZCXpByBpclAg4RLvSvfK0v4ikW4VfcvKzIZC0qCUEKZBtrAdQQLxG49iT5H0qB1xhdku3sxaXIrvWjTYCEGGDAYs7tD1MGChDA10rfFZBL7rQZDZD';
	$metric = 'page_impressions';
	$since = '2018-04-01';
	$until = '2018-04-14';

	$url = 'https://graph.facebook.com/'.$object_id.'/insights/'.$metric.'/day/?since='.$since.'&until='.$until.'&access_token='.$access_token;

	$requestedInsights = file_get_contents($url);     
	$decodedObject = json_decode($requestedInsights);


	foreach ( $decodedObject->data as $key=>$rows ){
      $val = $rows->values; 

      foreach ( $val as $key2=>$rows2 ){

      		$val2 = $rows2; 
      		echo $val2->end_time.' - '.$val2->value;
      		echo '<br>';
      }

	};















?>