<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trivia</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel='stylesheet' href='../login/login.css'>
</head>
<body>
    <?php include 'nav.php';?>
    
    <div class="container mt-3">
        <div class="row">
            <div class="col-12 col-md-6">
                <h3 class="mt-4 mt-md-2 text-center">Answer Any 10 Questions!</h3>
            </div>
            <div class="col-12 col-md-6">
                <a href="play.php" class="btn btn-custom btn-lg btn-block mt-4 mt-md-2">
                    Play
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <h3 class="mt-4 mt-md-2 text-center">Pick a category and a level!</h3>
            </div>
            <div class="col-12 col-md-6">
                <a href="play_options.php" role = 'button' class="btn btn-custom btn-lg btn-block mt-4 mt-md-2">
                    Play Options
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <h3 class="mt-4 mt-md-2 text-center">Look at the rankings!</h3>
            </div>
            <div class="col-12 col-md-6">
                <a href="rankings.php" class="btn btn-custom btn-lg btn-block mt-4 mt-md-2">
                    Rankings
                </a>
            </div>
        </div>
    </div>
    
</body>
</html>