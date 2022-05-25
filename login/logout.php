<?php
	session_start();
	session_destroy(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Trivia</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel='stylesheet' href='login.css'>
</head>
<body>
	<?php include 'nav.php';?>
    <div class="container">
		<div class="row text-center">
			<h1 class="col-12 mt-4 mb-4">You are now logged out.</h1>
		</div> 
	</div> 

	<div class="container">
		<div class='form-group row d-flex justify-content-center'>
				<div class='col-8 col-md-6 col-lg-5'>
					<a href="../trivia/index.php" role="button" class="btn btn-light btn-block">Home</a>
				</div>
		</div> 
		<div class='form-group row d-flex justify-content-center'>
				<div class='col-8 col-md-6 col-lg-5'>
					<a href="login.php" role="button" class="btn btn-custom btn-block">Login</a>
				</div>
		</div> 

	</div> 
    
</body>
</html>