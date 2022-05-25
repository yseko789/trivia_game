<?php
    require '../config/config.php';
    if(isset($_SESSION['logged_in']) && !empty($_SESSION['logged_in']))
    {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if($mysqli->connect_errno)
        {
            echo $mysqli->connect_error;
            exit();
        }

        //if the user didn't select any category or level
            $statement = $mysqli->prepare("DELETE FROM rankings WHERE username = ?");
            $statement->bind_param('s', $_SESSION['username']);

            $executed = $statement->execute();
            if(!$executed)
            {
                echo $mysqli->error;
            }
            if($statement->affected_rows!=1)
            {
                $error = 'Can not be updated';
            }
            $statement->close();


        
            $statement= $mysqli->prepare("DELETE FROM users WHERE username = ?");
            $statement->bind_param('s', $_SESSION['username']);
            $executed = $statement->execute();
            if(!$executed)
            {
                echo $mysqli->error;
            }
            if($statement->affected_rows!=1)
            {
                $error = 'Can not be updated';
            }
            $statement->close();
            $mysqli->close();
    }
	session_destroy(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Deletion | Trivia</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel='stylesheet' href='../login/login.css'>
</head>
<body>
    <?php include '../login/nav.php';?>
    <div class="container mt-4">
        <div class='row d-flex justify-content-center'>
            <div class="form">
                <h1>Account was deleted</h1>
                <div class="col-18">
                    <a href="index.php" class="btn btn-custom btn-lg btn-block mt-4 mt-md-2">
                        Home
                    </a>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>