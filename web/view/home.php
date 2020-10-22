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
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>

<footer class="footer mt-auto py-3">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php'; ?>
</footer>

</html>