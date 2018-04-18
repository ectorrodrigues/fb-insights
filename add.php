<?php

	$name 	= $_POST['name'];
	$pageid = $_POST['pageid'];

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

	$file	= $_FILES['img']['name'];
	$img	= uniqid().$file;

	$_UP['folder']	= 'img/';
	move_uploaded_file($_FILES['img']['tmp_name'], $_UP['folder'] . $img);

	$sql = "INSERT INTO pages (title, page_id, img) VALUES ('".$name."', '".$pageid."', '".$img."')" ;
	$query = $conn->prepare($sql);
	$query->execute();

	header('Location:index.php');

?>