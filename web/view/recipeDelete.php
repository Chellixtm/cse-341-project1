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

    <div class="container margin-top signup-window">
        <div class="card text-center">
            <div class="card-body">
                <h1 class="card-title">Are you Sure?</h1><br>
                <?php 
                    if(isset($message)) {
                        echo "<div class='alert alert-danger' role='alert'>$message</div>";
                    }
                ?>
                <p class="card-text">If you are sure you want to delete your <?=$recipe['recipename']?> recipe, just click the button to confirm.</p>
                <form action="/recipe/index.php" method="post">
                    <input type="hidden" name="recipeid" value="<?=$recipe['recipeid']?>">
                    <input type="hidden" name="action" value="deleteRecipe">
                    <input type="submit" name="submit" value="Delete Recipe" id="deleteRecipe" class="btn btn-danger">
                </form>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>

<footer class="footer mt-auto py-3">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php'; ?>
</footer>

</html>