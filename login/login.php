<?php
require '../config/config.php';

if(!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'])
{
	if(isset($_POST['username']) && isset($_POST['password']))
	{
		if(empty($_POST['username']) || empty($_POST['password']))
		{
			$error = 'Please enter username and password.';
		}
		else
		{
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

			if($mysqli->connect_errno)
			{
				echo $mysqli->connect_error;
				exit();
			}

			$passwordInput = hash('sha256', $_POST['password']);
			$statement_login = $mysqli->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
			$statement_login->bind_param('ss', $_POST['username'], $passwordInput);
			$executed_login = $statement_login->execute();

			if(!$executed_login)
			{
				echo $mysqli->error;
				exit();
			}
			$statement_login->store_result();
			

			if($statement_login->num_rows == 1)
			{
				$_SESSION['logged_in'] = true;
				$_SESSION['username'] = $_POST['username'];
				header('Location: ../trivia/index.php');
			}
			else
			{
				$error = 'Invalid username or password.';
			}
			$statement_login->close();
		}
	}
}
else
{
	header('Location: ../trivia/index.php');
}
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
			<h1 class="col-12 mt-4 mb-4">Login</h1>
		</div> 
	</div> 

	<div class="container">

		<form action="login.php" method="POST">

			<div class="row mb-3">
				<div class="font-italic text-danger col-sm-9 ml-sm-auto">
					
					<?php
						if ( isset($error) && !empty($error) ) {
							echo $error;
						}
					?>
				</div>
			</div> 
			

			<div class="form-group row d-flex justify-content-center">
				<div class="col-8 col-md-6 col-lg-5">
					<input type="text" class="form-control" id="username-id" name="username" placeholder='Username'>
				</div>
			</div> 

			<div class="form-group row d-flex justify-content-center">
				<div class="col-8 col-md-6 col-lg-5">
					<input type="password" class="form-control" id="password-id" name="password" placeholder='Password'>
				</div>
			</div> 

			<div class="form-group row d-flex justify-content-center">
				<div class="col-8 col-md-6 col-lg-5">
					<button type="submit" class="btn btn-custom btn-block">Login</button>
				</div>
			</div>
			<div class='form-group row d-flex justify-content-center'>
				<div class='col-8 col-md-6 col-lg-5'>
					<a href="../trivia/index.php" role="button" class="btn btn-light btn-block">Cancel</a>
				</div>

			</div> 
		</form>

		<div class="row d-flex justify-content-center">
			<div>
				<h6>Don't have an account? <a class="link-custom" href="register_form.php">Create an account</a></h6>
			</div>
		</div> 

	</div> 
    
</body>
</html>