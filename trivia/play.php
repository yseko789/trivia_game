<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play | Trivia</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel = 'stylesheet' href = 'play.css'/>
</head>
<body>
    <div class='screen'>
        <?php include 'nav.php';?>
        <div class="container question-container d-flex justify-content-center align-items-center my-4">
            <h3 class='question-text p-4'>Loading...</h3>
        </div>
        
        <div class="container answer-container" id = 'answer-row'>
            
        </div> 
    </div>
    <form id = 'sendCorrect' action='results.php' method='POST'>
        <input id = 'correct' name = 'correct' type = 'hidden' value=''>
        <input id = 'category' name = 'category' type = 'hidden' value=''>
        <input id = 'level' name = 'level' type = 'hidden' value = ''>
    </form>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"　integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="　crossorigin="anonymous">
    </script>

    <script>

        


        function shuffleArray(array) 
        {
            for (var i = array.length - 1; i > 0; i--) {
            
                // Generate random number
                var j = Math.floor(Math.random() * (i + 1));
                            
                var temp = array[i];
                array[i] = array[j];
                array[j] = temp;
            }
            return array;
        }

        let index = 1;
        let questions = [];
        let answers = [];
        let correct = 0;
        let url = 'https://opentdb.com/api.php?amount=10&type=multiple';
        let params = new URLSearchParams(document.location.search);
        let level = params.get('level');
        let category = params.get('category');

        if(level !== null)
        {
            url = url+'&difficulty='+level;
        }
        if(category!== null)
        {
            url = url+'&category=' + category;
        }

        console.log(url);
        let httpRequest = new XMLHttpRequest();
        httpRequest.open("GET", url);
        httpRequest.send();
        httpRequest.onreadystatechange = function () {
            if (httpRequest.readyState == 4) {
                if (httpRequest.status == 200) {
                    //response text is a json
                    questions = JSON.parse(httpRequest.responseText).results;
                    console.log(questions);
                    $(".question-text").html(questions[index - 1].question);
                    answers = questions[index-1].incorrect_answers;
                    answers.push(questions[index-1].correct_answer);
                    answers = shuffleArray(answers);
                    for(let i = 0; i<4; i++)
                    {
                        $('#answer-row').append(`<button class = 'answer-text answer-btn btn btn-lg'>${answers[i]}</button>`);
                    }
                }
                else {
                    alert('AJAX error!!');
                    console.log(httpRequest.status);
                }
            }
        }

        $(".answer-container").on('mouseover', '.answer-btn', function(){
            $(this).addClass('hover');
        });
        $(".answer-container").on('mouseout', '.answer-btn', function(){
            $(this).removeClass('hover');
        })


        $(".answer-container").on('click','.answer-text', function(){
            if(questions[index-1].correct_answer === $(this).html().trim())
            {
                correct = correct +1;
                console.log("correct");
            }
            if(index ==10)
            {
                //save correct# to database

                //redirect to results page
                $('#correct').val(correct);
                $('#category').val(category);
                if(level === 'easy')
                {
                    $('#level').val(0);
                }
                else if(level === 'medium')
                {
                    $('#level').val(1);
                }
                else if(level === 'hard')
                {
                    $('#level').val(2);
                }
                
                $('#sendCorrect').submit();
                

                

                
                


                // let htmlString = `
                // <h1>You got ${correct} correct!</h1>
                // <a href='play.php'>Click here to play again</a>
                // <a href='index.php'>Click here to go home</a>
                // `
                // $(".screen").html(htmlString);
            }
            else
            {   
                $('#answer-row').empty();
                index = index +1;
                $(".question-text").html(questions[index - 1].question);
                answers = questions[index-1].incorrect_answers;
                answers.push(questions[index-1].correct_answer);
                answers = shuffleArray(answers);
                for(let i = 0; i<4; i++)
                {
                    $('#answer-row').append(`<button class = 'answer-text answer-btn btn btn-lg'>${answers[i]}</button>`);
                    
                }

            }
           
        })




    </script>
    
</body>
</html>