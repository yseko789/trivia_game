<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Trivia</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel='stylesheet' href='login.css'>
</head>
<body>
	<?php include 'nav.php';?>
    <div class="container">
		<div class="row text-center">
			<h1 class="col-12 mt-4 mb-4">Registration</h1>
		</div> 
	</div> 

	<div class="container">

		<form action="register_confirmation.php" method="POST"> 
			<div class="form-group row d-flex justify-content-center">
				<div class="col-8 col-md-6 col-lg-5">
					<input type="text" class="form-control" id="username-id" name="username" placeholder='Username'>
					<small id='username-error' class='invalid-feedback'>Username Required</small>
				</div>
			</div> 

            <div class="form-group row d-flex justify-content-center">
				<div class="col-8 col-md-6 col-lg-5">
					<input type="text" class="form-control" id="email-id" name="email" placeholder='Email Address'>
					<small id='username-error' class='invalid-feedback'>Email Required</small>
				</div>
			</div> 

			<div class="form-group row d-flex justify-content-center">
				<div class="col-8 col-md-6 col-lg-5">
					<input type="password" class="form-control" id="password-id" name="password" placeholder='Password'>
					<small id='username-error' class='invalid-feedback'>Password Required</small>
				</div>
			</div> 

			<div class="form-group row d-flex justify-content-center">
				<!-- <div class="col-sm-3"></div> -->
				<div class="col-8 col-md-6 col-lg-5 mt-2">
					<button type="submit" class="btn btn-custom btn-block">Register</button>
				</div>
			</div>
			<div class='form-group row d-flex justify-content-center'>
				<div class='col-8 col-md-6 col-lg-5 mt-2'>
					<a href="../trivia/index.php" role="button" class="btn btn-light btn-block">Cancel</a>
				</div>

			</div> 
		</form>

		<div class="row d-flex justify-content-center">
			<div>
				<h6>Already have an account? <a class="link-custom" href="login.php">Login</a></h6>
			</div>
		</div> 

	</div> 
	<script>
		document.querySelector('form').onsubmit = function(){
			if(document.querySelector('#username-id').value.trim().length === 0)
			{
				document.querySelector('#username-id').classList.add('is-invalid');
			}
			else
			{
				document.querySelector('#username-id').classList.remove('is-invalid');
			}
			if(document.querySelector('#email-id').value.trim().length === 0)
			{
				document.querySelector('#email-id').classList.add('is-invalid');
			}
			else
			{
				document.querySelector('#email-id').classList.remove('is-invalid');
			}
			if(document.querySelector('#password-id').value.trim().length === 0)
			{
				document.querySelector('#password-id').classList.add('is-invalid');
			}
			else
			{
				document.querySelector('#password-id').classList.remove('is-invalid');
			}

			return (!document.querySelectorAll('.is-invalid').length>0);
		}
	</script>
    
</body>
</html>