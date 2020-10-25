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
                <h1 class="card-title">Edit Account</h1><br>
                <?php 
                    if(isset($message)) {
                        echo "<div class='alert alert-danger' role='alert'>$message</div>";
                    }
                ?>
                <form action="/users/index.php" method="post">
                    <label for="username">Username:</label><br>
                    <input type="text" id="username" name="username" value="<?=$_SESSION['userData']['username']?>"><br><br>

                    <label for="email">E-Mail Address:</label><br>
                    <input type="email" id="email" name="email" value="<?=$_SESSION['userData']['email']?>"><br><br>

                    <label for="password">Password:</label><br>
                    <p class="card-text">Entering A Password here Will change your password. Leave blank to keep the password the same.</p>
                    <p><small class="text-muted">*Password must be at least 5 characters and not more than 20.</small></p>
                    <input type="password" id="password" name="password" placeholder="New Password" minlength="5" maxlength="20"><br><br>

                    <input type="hidden" name="userId" value="<?=$_SESSION['userData']['userid']?>">
                    <input type="hidden" name="action" value="updateUser">
                    <input type="submit" name="submit" value="Update Account" id="updateUser" class="btn btn-primary">
                    <a href="/users/index.php?action=userDetails" class="btn btn-danger">Cancel</a>
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