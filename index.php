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
    		background-color: #eee;
    	}
    	.p-3{
    		padding: 10% 0;
    	}

    	.separator{
    		width: 100%;
    		height: 1px;
    		margin:20px 0;
    		border-bottom: solid;
    		border-bottom-width: 2px;
    	}
    </style>
    
    
    <title>FB Insights</title>
</head>

<body>

<div class="container p-3">

	<div class="row col-lg-8 col-lg-offset-2">

		<form action="chart.php" method="post" enctype="multipart/form-data">

			<div class="form-group col-lg-12">
				<label>Page</label>

				<select name="page" class="form-control" >
				<?php
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

					foreach($conn->query("SELECT * FROM pages ORDER BY title ASC") as $row) {
						$id = $row['id'];
						$title = $row['title'];

						echo '<option value="'.$id.'">'.$title.'</option>';
					}

				?>
				</select>

			   	
			</div>

			<div class="form-group col-lg-12">
				<label>Since Date</label>
				<input type="date" name="since" class="form-control" >
			</div>

			<div class="form-group col-lg-12">
				<label>Until Date</label>
				<input type="date" name="until" class="form-control" >
			</div>

			<div class="form-group col-md-12 padding-top-bottom text-right">
				<button type="submit" class="btn btn-primary transition">Generate</button>
			</div>

		</form>

	</div>

	<div class="row col-lg-8 col-lg-offset-2 separator"></div>

	<div class="row col-lg-8 col-lg-offset-2">

		<form action="add.php" method="post" enctype="multipart/form-data">

			<div class="form-group col-lg-12">
				<label>Page Name</label>
			   	<input type="text" name="name" class="form-control" >
			</div>

			<div class="form-group col-lg-12">
				<label>Page ID</label>
				<input type="text" name="pageid" class="form-control" >
			</div>

			<div class="form-group col-lg-12">
				<label>Logo</label>
				<input type="file" name="img" class="form-control" >
			</div>

			<div class="form-group col-md-12 padding-top-bottom text-right">
				<button type="submit" class="btn btn-primary transition">Add Page</button>
			</div>

		</form>

	</div>

</div>	
	
</body>

</html>