<?php
if (!isset($_SESSION['loggedin'])) {
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
                <h1 class="card-title">Account Details</h1><br>
                <?php
                if (isset($message)) {
                    echo "<div class='alert alert-danger' role='alert'>$message</div>";
                }
                if (isset($success)) {
                    echo "<div class='alert alert-success' role='alert'>$success</div>";
                }
                ?>
                <p class="card-text"><b>Username:</b> <?= $_SESSION['userData']['username'] ?><br><br>
                    <b>E-Mail:</b> <?= $_SESSION['userData']['email'] ?></p>
                <form action="/users/index.php" method="get" class="d-inline">
                    <input type="hidden" name="action" value="updateUserPage">
                    <input type="submit" name="submit" value="Edit Account" id="editAccount" class="btn btn-primary">
                </form>
                <form action="/users/index.php" method="get" class="d-inline">
                    <input type="hidden" name="action" value="deleteUserPage">
                    <input type="submit" name="submit" value="Delete Account" id="deleteAccount" class="btn btn-danger">
                </form>

                <?php
                if (!empty($userRecipes)) {
                    $i = 1;
                    echo <<<EOL
                        <hr>
                        <h3>User Recipes</h3>
                            <table class='table table-borderless'>
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Recipe Name</th>
                                        <th scope="col">Option</th>
                                    </tr>
                                </thead>
                                </tbody>
                        EOL;
                    foreach ($userRecipes as $ur) {
                        echo <<<EOL
                                <tr>
                                    <th scope="row">$i</th>
                                    <td>$ur[recipename]</td>
                                    <td>
                                        <a class="btn btn-primary" href="/recipe/index.php?action=editPage&recipeid=$ur[recipeid]">Edit</a>
                                        <a class="btn btn-danger" href="/recipe/index.php?action=deletePage&recipeid=$ur[recipeid]">Delete</a>
                                    </td>
                                </tr>
                            EOL;
                        $i++;
                    }
                    echo <<<EOL
                            </tbody>
                        </table>
                        EOL;
                }
                ?>
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