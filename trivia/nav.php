<head>
	<link rel='stylesheet' href='../trivia/nav.css'/>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?&family=Source+Code+Pro:ital@1&display=swap" rel="stylesheet">
</head>
<nav class="container-fluid p-2">
	<div class="row">
		<div class="col-12 d-flex justify-content-between">
			<a class = 'p-2 text-left nav-text' href='../trivia/index.php'>Trivia</a>
			<?php if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) :?>
				<div>
					<a class="nav-text p-2 text-right" href="../login/login.php">Login</a>
					<!-- <a class="nav-text p-2 text-right" href="../login/register_form.php">Sign up</a> -->
				</div>
			<?php else: ?>
				<div class='d-flex justify-content-end'>
					<a class="p-2 nav-text" href="account.php"><?php echo $_SESSION["username"];?></a>
					
					<a class="p-2 nav-text" href="../login/logout.php">Logout</a>
				</div>
			<?php endif; ?>

		</div>
	</div> <!-- .row -->
</nav>