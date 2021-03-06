<?php

	include_once "global.php";

	if (isset($_POST['score'])) {
		$_SESSION['score'] = $_POST['score'];
	}

	unset($_SESSION['nameErr']);

	if (!isset($_SESSION['score'])) {
		$success = false;
		$nameErr = " No score to submit";
		$_SESSION['nameErr'] = $nameErr;
	}
	
 //check to see that the form has been submitted
if(isset($_POST['submit-form']) && isset($_SESSION['score'])) { 
 
    //retrieve the $_POST variables
    $name = $_REQUEST['name'];
    $score = $_SESSION['score'];

    //initialize variables for form validation
    if (!preg_match('/^[A-Za-z0-9_]+$/', $name)) {
    	$success = false;
        $nameErr = " Only alphanumeric characters and '_' are allowed";
        $_SESSION['nameErr'] = $nameErr;
    } 
    else if (strlen($name) > 10) {
    	$success = false;
    	$nameErr = " Maximum 10 characters";
    	$_SESSION['nameErr'] = $nameErr;
    }
    elseif (strlen($name) == 0) {
    	$success = false;
    	$nameErr = " Name cannot be blank";
    	$_SESSION['nameErr'] = $nameErr;
    }
    else {
        $success = true;
        unset($_SESSION['nameErr']);
    }
 
    if($success)
    {
        $query = "INSERT INTO flappybird_leaderboard (name,score) VALUES ('$name', '$score')";

        $result = $conn->query($query);
        unset($_SESSION['score']);

  		$_SESSION['name'] = $name;

        //redirect them to a welcome page
        header("Location: leaderboard.php");
 
    }

    $conn->close();

}


?>


<!-- Flappy Bird -->

<html>
<head>
	<meta charset="ISO-8859-1">
	<title>Leaderboards</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<style type="text/css">
		#h2obj {
			padding-bottom: 15px;
		}
	</style>
</head>
<body>
	<div class="container">
		<nav class="navbar navbar-default">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		        <li><a href="index.php">Flappy Bird Online</a></li>
		        <li><a href="leaderboard.php">Leaderboard</a></li>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>

		<div class="row">
		<div class="page-header">
			<h2>Leaderboard</h2>
		</div>
		</div>

		<div class="well">
		<div class="row">

			<h3 id="h2obj">Enter a name to be added to the leaderboards.</h3>
		</div>
		<div class="row">
			<form class="form-horizontal" method='post'>
			  <div class="form-group">
			    <label for="inputName3" class="col-sm-4 control-label">Name</label>
			    <div class="col-sm-4">
			      <input type="name" class="form-control" id="inputName3" placeholder="Name" name="name" method="post">
			    </div>
			  </div>
			  <?php
			  	if (isset($_SESSION['nameErr'])) {
			  		echo "\t\t\t<div class=\"form-group\">";
			  		echo "\t\t\t<label for=\"inputName3\" class=\"col-sm-4 control-label\"></label>";
			  		echo "\t\t\t\t<div class=\"alert alert-danger col-md-4\" role=\"alert\">";
					echo "\t\t\t\t\t<span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>";
					echo "\t\t\t\t\t<span class=\"sr-only\">Error:</span>";
					echo "\t\t\t\t\t" . $_SESSION['nameErr'];
					echo "\t\t\t\t</div>";
					echo "\t\t\t</div>";
					unset($_SESSION['nameErr']);
			  	}

			  ?>
			  <div class="form-group">
			    <div class="col-sm-offset-3 col-sm-6">
			      <button type="submit" class="btn btn-primary" value="submit" name="submit-form" method="post">Submit</button>
			    </div>
			  </div>
			</form>
		</div>
		</div>
	</div>
</body>
</html>	