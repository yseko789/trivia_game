<?php
    require '../config/config.php';
    if(isset($_GET['category']))
    {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if($mysqli->connect_errno)
        {
            echo $mysqli->connect_error;
            exit();
        }
        $statement = $mysqli->prepare(
                    "SELECT username, score, level_id 
                    FROM rankings 
                    WHERE rankings.category_id= ?
                    ORDER BY rankings.level_id");

        $statement->bind_param('i', $_GET['category']);

        $executed = $statement->execute();
        if(!$executed)
        {
            echo $mysqli->error;
        }
        //store results 
        $result = $statement->get_result();
        //number of rows back
        $numrows = $result->num_rows;
        $usernameArr = array();
        $scoreArr = array();
        $levelArr = array();

        if($numrows > 0) 
        {     
            while ($data = $result->fetch_assoc()) 
            {
                // echo $data['username'];
                array_push($usernameArr, $data['username']);
                array_push($scoreArr, $data['score']);
                array_push($levelArr, $data['level_id']);
            }
        }
            while(sizeof($usernameArr)<3)
            {
                if(!in_array(0, $levelArr))
                {
                    array_unshift($usernameArr,"empty");
                    array_unshift($scoreArr,0);
                }
                if(!in_array(1, $levelArr))
                {
                    array_splice($scoreArr, 1, 0, 0);
                    array_splice($usernameArr, 1, 0, 'empty');
                }
                if(!in_array(2, $levelArr))
                {
                    array_push($usernameArr, 'empty');
                    array_push($scoreArr, 0);
                }
                
            }
            
        $statement->close();
        $mysqli->close();
    }
    else
    {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if($mysqli->connect_errno)
        {
            echo $mysqli->connect_error;
            exit();
        }
        $statement =  "SELECT  username, daily_score FROM users ORDER BY daily_score DESC LIMIT 3";

        // $statement->bind_param('i', $_GET['category']);

        $results = $mysqli->query($statement);
        
       if ( $results == false ) {
            echo $mysqli->error;
            exit();
        }
        //number of rows back
        
        $scoreArr = array();
        $usernameArr = array();

            while ($data = $results->fetch_assoc()) 
            {
                // echo $data['username'];
                array_push($usernameArr, $data['username']);
                array_push($scoreArr, $data['daily_score']);
            }
            while(sizeof($usernameArr)<3)
            {
                array_unshift($usernameArr,"empty");
            }
            while(sizeof($scoreArr)<3)
            {
                array_unshift($scoreArr,0);
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
    <title>Trivia | Rankings</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&display=swap" rel="stylesheet">
</head>
<body>
    <div class='screen'>
        <?php include 'nav.php';?>
        <div class="container">
            <div class="row my-4">
                <h1>Rankings</h1>
            </div>
        </div>
        <div class="container">
            <form action = 'rankings.php?' method="GET">
                <div class='form-group row'>
                    <label for='category-id' class='col-sm-3 col-form-label text-sm-right'>Category:</label>
                    <div class="col-sm-9">
                        <select name='category' id='category-id' class="form-control" onchange="this.form.submit()">
                            <option value="">Any Ten</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class = "container">
            <div class = "row d-flex justify-content-around">
                <?php if(!isset($_GET["category"]) || !$_GET["category"]) :?>
                    <h1>First</h1>
                    <h1>Second</h1>
                    <h1>Third</h1>
                <?php else: ?>
                    <h1>Easy</h1>
                    <h1>Medium</h1>
                    <h1>Hard</h1>
                <?php endif;?>
            </div>
    </div>
        <div class="container">
            <div class='row'>
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        　integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 　crossorigin="anonymous">
    </script>
    <script>
        const url = 'https://opentdb.com/api_category.php';
        let httpRequest = new XMLHttpRequest();
        httpRequest.open("GET", url);
        httpRequest.send();
        httpRequest.onreadystatechange = function () {
            if (httpRequest.readyState == 4) {
                if (httpRequest.status == 200) {
                    let categories = JSON.parse(httpRequest.responseText).trivia_categories;
                    console.log(categories);
                    for(let i = 0; i<categories.length;i++)
                    {
                        $('#category-id').append(new Option(categories[i].name, categories[i].id));
                    }
                }
                else {
                    alert('AJAX error!!');
                    console.log(httpRequest.status);
                }
            }
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script>
        //bar
        
        let scores = <?php echo json_encode($scoreArr)  ?>;
        let usernames = <?php echo json_encode($usernameArr)  ?>;
        // console.log(data1);
        // console.log(data2);
        var ctxB = document.getElementById("barChart").getContext('2d');
        var myBarChart = new Chart(ctxB, {
        type: 'bar',
        data: {
            labels: usernames,
            datasets: [{
            label: '# Correct',
            data: scores,
            backgroundColor: [
                'rgba(253, 253, 150, 1)',
                'rgba(167, 199, 231,1)',
                'rgba(255, 105,97,1)'
                
                
                
            ]
            }]
        },
        options: {
            scales: {
                xAxes: [{
                    gridLines: {
                        display:false
                    },
                    categoryPercentage: 1.0,
                    barPercentage: 1.0,
                    ticks:{
                        fontFamily: "Abril Fatface",
                        fontSize: 35

                    }
                }],
                yAxes: [{
                    gridLines: {
                        display:false
                    },
                    ticks:{
                        beginAtZero: true,
                        display:false
                    }
                    
                }]
            },
            legend:{
                display: false
            }
        },
        
        });
    </script>
</body>
</html>