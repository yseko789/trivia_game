<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account | Trivia</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <?php include 'nav.php';?>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="form">
                <h1>Click to delete your account</h1>
                <div class="col-8 ">
                    <a href="delete.php" class="btn btn-danger btn-lg btn-block mt-4 mt-md-2">
                        Delete
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>