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

    <div class="jumbotron jumbo-cheese">
        <?php
        if (!isset($_SESSION['loggedin'])) {
            echo <<<EOL
            <h1 class="display-4">Welcome to Rumbly Tumbly Recipes!</h1>
            <p class="lead">We are a free to use webstie where you can either store your recipes or browse for new ones!</p>
            <hr class="my-4">
            <p>To get started, why not create a new account? Or if you have one just log in!</p>
            <a class="btn btn-primary btn-lg" href="/users/index.php?action=createPage" role="button">Create Account</a>
            <a class="btn btn-primary btn-lg" href="/users/index.php?action=loginPage" role="button">Login</a>
            EOL;
        } else {
            echo <<<EOL
            <h1 class="display-4">Welcome Back to Rumbly Tumbly Recipes!</h1>
            <p class="lead">We are a free to use webstie where you can either store your recipes or browse for new ones!</p>
            <hr class="my-4">
            <p>Would you like to browse our recipe selection? Or perhaps create a new one?</p>
            <a class="btn btn-primary btn-lg" href="/recipe/index.php?action=browse" role="button">Browse</a>
            <a class="btn btn-primary btn-lg" href="/recipe/index.php?action=createPage" role="button">Create New Recipe</a>
            EOL;
        }
        echo "</div>";

        $db = recipeConnect();
        $sql = 'SELECT recipes.*, users.username FROM recipes INNER JOIN users ON recipes.userid = users.userid ORDER BY userId DESC LIMIT 3';
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        echo "<h2 class='text-center'>Look at what's new!</h2>";
        echo "<div class='container margin-top'>";
        echo "<div class='row'>";
        foreach ($recipes as $r) {
            // TODO: Write code for building recipe cards
            echo <<<EOL
            <div class='col'>
            <a href='/recipe/index.php?action=recipeDetail&recipeid=$r[recipeid]' class='remove-link-style'>
            <div class='card card-space-sides card-same-height' style='width: 18rem;'>
            <div class='card-body shadow card-background-highlight'>
            <h5 class='card-title'>$r[recipename]</h5>
            <h6 class='card-subtitle mb-2 text-muted'>Created By: $r[username]</h6>
            <p class='card-text'>$r[recipedesc]</p>
            </div>
            </div>
            </a>
            </div>
            EOL;
        }
        echo "</div>";
        echo "</div>";
        ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>

<footer class="footer mt-auto py-3">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php'; ?>
</footer>

</html>