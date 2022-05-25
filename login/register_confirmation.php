<?php
    require '../config/config.php';

    // var_dump($_POST);

    if ( !isset($_POST['email']) || empty($_POST['email']) || !isset($_POST['username']) || empty($_POST['username']) || !isset($_POST['password']) || empty($_POST['password']) ) 
    {
	    $error = "Please fill out all required fields.";
    }
    else
    {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if($mysqli->connect_errno)
        {
            echo $mysqli->connect_error;
            exit();
        }

        $statement_registered = $mysqli->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $statement_registered->bind_param('ss', $_POST['username'], $_POST['email']);
        $executed_registered = $statement_registered->execute();
        if(!$executed_registered)
        {
            echo $mysqli->error;
        }
        $statement_registered->store_result();
        $numrows = $statement_registered->num_rows;
        $statement_registered->close();

        if($numrows>0)
        {
            $error = 'Username or email address has already been taken. Please choose another one.';
        }
        else
        {
            $password = hash('sha256', $_POST['password']);

            $statement = $mysqli->prepare('INSERT INTO users(username, email, password) VALUES(?,?,?)');

            $statement->bind_param('sss', $_POST['username'], $_POST['email'], $password);
            $executed = $statement->execute();
            if(!$executed)
            {
                echo $mysqli->error;
            }
            $statement->close();
        }
        $mysqli->close();
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Confirmation | Trivia</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel='stylesheet' href='login.css'>
</head>
<body>
    <?php include 'nav.php';?>
    <div class='container'>
        <div class = 'row text-center'>
            <h1 class='col-12 mt-4 mb-4'>Registration</h1>
        </div>
    </div>
    
	<div class="container">
		<div class="row mt-4 text-center">
			<div class="col-12">
				<?php if ( isset($error) && !empty($error) ) : ?>
					<h1 class="text-danger"><?php echo $error; ?></h1>
				<?php else : ?>
					<h1 class="text-success"><?php echo $_POST['username']; ?> was successfully registered.</h1>
				<?php endif; ?>
            </div> 
        </div> 

        <div class="row mt-4 mb-4 d-flex justify-content-center">
            <div class="col-8 col-md-6 col-lg-5">
                <a href="login.php" role="button" class="btn btn-block btn-custom">Login</a>
            </div> 
        </div> 
        <div class="row mt-4 mb-4 d-flex justify-content-center">
            <div class="col-8 col-md-6 col-lg-5">
                <a href="../trivia/index.php" role="button" class="btn btn-block btn-light">Home</a>
            </div> 
        </div> 
        

    </div> 
</body>
</html>