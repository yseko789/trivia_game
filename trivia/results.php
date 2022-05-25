<?php
    require '../config/config.php';

    

    if ( !isset($_POST['correct'])) 
    {
	    $error = "You don't have access here.";
    }
    else
    {   
        //only update the database if the user is logged in
        if(isset($_SESSION['logged_in']) && !empty($_SESSION['logged_in']))
        {
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if($mysqli->connect_errno)
            {
                echo $mysqli->connect_error;
                exit();
            }

            //if the user didn't select any category or level
            if((!isset($_POST['level']) || empty($_POST['level']))&& (!isset($_POST['category']) || empty($_POST['category'])))
            {
                $statement= $mysqli->prepare("UPDATE users SET daily_score=? WHERE username = ?");


                $statement->bind_param('is', $_POST['correct'], $_SESSION['username']);

                $executed = $statement->execute();
                if(!$executed)
                {
                    echo $mysqli->error;
                }
                if($statement->affected_rows>1)
                {
                    $error = 'Can not be updated';
                }
                $statement->close();
                $mysqli->close();
            }
            else
            {
                //check if ranking exists
                $statement = $mysqli->prepare(
                    "SELECT * 
                    FROM rankings 
                    WHERE rankings.category_id= ? AND rankings.level_id = ?");

                $statement->bind_param('is', $_POST['category'], $_POST['level']);

                $executed = $statement->execute();
                if(!$executed)
                {
                    echo $mysqli->error;
                }
                $statement->store_result();
                $numrows = $statement->num_rows;
                $statement->close();

                //if the ranking doesn't exist
                if($numrows==0)
                {
                    $statement = $mysqli->prepare("INSERT INTO rankings(username, category_id, level_id, score) VALUES(?,?,?,?)");
                    $statement->bind_param('siii',$_SESSION["username"], $_POST["category"], $_POST["level"], $_POST['correct']);
                    $executed = $statement->execute();
                    if(!$executed)
                    {
                        echo $mysqli->error;
                    }
                    $statement->close();
                }
                //if the ranking does exist
                else
                {
                    $statement = $mysqli->prepare("UPDATE rankings SET username=?, score=? WHERE category_id = ? AND level_id=?");
                    $statement->bind_param('siii', $_SESSION["username"], $_POST['correct'], $_POST['category'], $_POST['level']);
                    $executed = $statement->execute();
                    if(!$executed)
                    {
                        echo $mysqli->error;
                    }
                    $statement->close();
                }
                $mysqli->close();
            }

            
            
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trivia | Rankings</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='../login/login.css'>

</head>
<body>
    <div class='screen'>
        <?php include 'nav.php';?>
        <div class="container question-container">
            <div class='row d-flex justify-content-center align-items-center my-4'>
                <?php if ( isset($error) && !empty($error) ) : ?>
					<h1 class="text-danger"><?php echo $error; ?></h1>
				<?php else : ?>
                    <h3 class = 'question-text p-4'>You got <?php echo $_POST['correct'];?> correct!</h3>
				<?php endif; ?>

                
            </div>
        </div>
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-6">
                    <a href="play.php" class="btn btn-custom btn-lg btn-block mt-4 mt-md-2">
                        Play Again
                    </a>
                </div>
                <div class="col-12 col-md-6">
                    <a href="index.php" class="btn btn-light btn-lg btn-block mt-4 mt-md-2">
                        Home
                    </a>
                </div>
            </div>
        </div>
        
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        　integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 　crossorigin="anonymous">
    </script>
    <script>
        //fetch correct #
        // let correct = 0;
        // $('#numCorrect').text(correct);
    </script>
    
        
</body>
</html>