<?php
    if(!isset($_SESSION['loggedin'])) {
        header('Location: /index.php');
        exit;
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Rumbly Tumbly</title>
    <meta charset="UTF-8">
    <meta name="author" content="Mitchell Hudson">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/style/style.css">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark red-back">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/common/nav.php'; ?>
    </nav>

    <div class="container margin-top">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Create New Recipe</h1><br>
                <?php 
                    if(isset($message)) {
                        echo "<div class='alert alert-danger' role='alert'>$message</div>";
                    }
                ?>
                <form action="/recipe/index.php" method="post">
                    <label for="recipeName">Recipe Name:</label><br>
                    <input type="text" id="recipeName" name="recipeName" placeholder="Recipe Name"><br><br>

                    <label for="description">Short Description:<small class="text-muted">*50 character limit</small></label><br>
                    <textarea id="description" name="description" class="recipe-textarea-size" maxlength="50" placeholder="Short description here..."></textarea><br><br>

                    <p>Ingredients:</p>
                    <table class="table table-borderless" id="ingredientsTable">
                        <tr id="row1">
                            <td>Ingredient: <input type="text" name="ingredient[1][name]"></td>
                            <td>Quantity: <input type="number" name="ingredient[1][amount]"></td>
                            <td>Measurement: <input type="text" name="ingredient[1][measurement]"></td>
                        </tr>
                    </table>
                    <button type="button" name="addInput" id="addInput" class="btn btn-success">Add Another Ingredient</button><br><br>

                    <label for="instructions">Instructions:</label><br>
                    <textarea id="instructions" name="instructions" class="recipe-textarea-size" placeholder="Instructions here..."></textarea><br><br>

                    <input type="hidden" name="userId" value="<?=$_SESSION['userData']['userid']?>">
                    <input type="hidden" name="action" value="createRecipe">
                    <input type="submit" name="submit" value="Create!" id="createRecipe">
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="/library/recipeCreate.js" type="text/javascript"></script>
</body>

<footer class="footer mt-auto py-3">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php'; ?>
</footer>

</html>