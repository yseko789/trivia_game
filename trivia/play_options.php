<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Options | Trivia</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel='stylesheet' href="play_options.css">
</head>
<body>
    <?php include 'nav.php';?>
    <div class="options-container container mt-5">
        <div class='container'>
            <div class="row">
                <h4>Pick the category and the level you want to play!</h4>
            </div>
        </div>
        <div class="container">
            <form action = 'play.php?' method = 'GET'>
                <div class = 'form-group row'>
                    <label for = 'category-id' class = 'col-sm-3 col-form-label text-sm-right'>Category:</label>
                    <div class="col-sm-9">
                        <select name = 'category' id = 'category-id' class="form-control">
                            <!-- <option value="" selected>-- Any Category --</option> -->
                        </select>
                    </div>
                </div>
                <div class='form-group row'>
                    <label for='category-id' class='col-sm-3 col-form-label text-sm-right'>Level:</label>
                    <div class="col-sm-9">
                        <select name='level' id='level-id' class="form-control">
                            <!-- <option value="" selected>-- Any Level --</option> -->
                            <option value = 'easy'>Easy</option>
                            <option value = "medium">Medium</option>
                            <option value="hard">Hard</option>
                        </select>
                    </div>
                </div>

                <!--
                    use js to get back list of categories
                    use those to fill up select options

                    user can choose level and genre
                    kind of like a ranked game
                -->
                <div class="form-group row d-flex justify-content-center">
                    <div class="col-12 col-md-6">
                        <button type='submit' class="btn btn-custom btn-lg btn-block mt-4 mt-md-2">
                            Play
                        </button>
                    </div>
                </div>
            </form>
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
    
</body>
</html>