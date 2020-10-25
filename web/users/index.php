<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/library/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/library/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/users-model.php';

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'loginPage':
        include $_SERVER['DOCUMENT_ROOT'] . '/view/login.php';
        break;
    case 'loginUser':
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        if (empty($username) || empty($password)) {
            $message = 'Please fill in all fields.';
            include $_SERVER['DOCUMENT_ROOT'] . '/view/login.php';
            exit;
            break;
        }

        $userData = getUser($username);

        $passwordCheck = password_verify($password, $userData['password']);

        if (!$passwordCheck) {
            $message = 'Please check your password and try again.';
            include $_SERVER['DOCUMENT_ROOT'] . '/view/login.php';
            exit;
            break;
        }

        unset($userData['password']);

        $_SESSION['loggedin'] = true;
        $_SESSION['userData'] = $userData;

        setcookie('username', $_SESSION['userData']['username'], strtotime('+1 week'), '/');

        header('Location: /index.php');
        break;
    case 'logout':
        $_COOKIE['username'] = NULL;
        $_SESSION = array();
        session_destroy();
        header('Location: /index.php');
        break;
    case 'createPage':
        include $_SERVER['DOCUMENT_ROOT'] . '/view/signup.php';
        break;
    case 'createUser':
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        $userExists = checkUserExist($username);

        if ($userExists) {
            $message = 'That username exists, please try a different one.';
            include $_SERVER['DOCUMENT_ROOT'] . '/view/signup.php';
            exit;
            break;
        }

        if (empty($username) || empty($password) || empty($email)) {
            $message = 'Please fill in all the fields.';
            include $_SERVER['DOCUMENT_ROOT'] . '/view/signup.php';
            exit;
            break;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $createSuccess = insertUser($username, $email, $hashedPassword);

        if ($createSuccess === 1) {
            $success = "Account creation was a success, please log in to continue.";
            include $_SERVER['DOCUMENT_ROOT'] . '/view/login.php';
            exit;
            break;
        } else {
            $message = "Something went wrong. If this keeps happening try again later.";
            include $_SERVER['DOCUMENT_ROOT'] . '/view/signup.php';
            exit;
            break;
        }

        break;
    case 'updateUserPage':
        include $_SERVER['DOCUMENT_ROOT'] . '/view/userEdit.php';
        break;
    case 'updateUser':
        $userId = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_NUMBER_INT);
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $newPassword = '';

        if (empty($username) || empty($email)) {
            $message = 'Please fill all required fields.';
            include $_SERVER['DOCUMENT_ROOT'] . '/view/userEdit.php';
            exit;
            break;
        }

        if (!empty($password)) {
            $newPassword = password_hash($password, PASSWORD_DEFAULT);
        }

        $updateSuccess = updateUser($userId, $username, $email, $password);

        if ($updateSuccess === 1) {
            if ($_SESSION['userData']['username'] != $username) {
                $_SESSION['userData']['username'] = $username;
                setcookie('username', $username, strtotime('+1 week'), '/');
                $_COOKIE['username'] = $username;
            }

            if ($_SESSION['userData']['email'] != $email) {
                $_SESSION['userData']['email'] = $email;
            }

            $success = "Account update was a success!";
            include $_SERVER['DOCUMENT_ROOT'] . '/view/userDetails.php';
            exit;
            break;
        } else {
            $message = "Something went wrong. If this keeps happening try again later.";
            include $_SERVER['DOCUMENT_ROOT'] . '/view/userEdit.php';
            exit;
            break;
        }

        break;
    case 'deleteUserPage':
        include $_SERVER['DOCUMENT_ROOT'] . '/view/userDelete.php';
        break;
    case 'deleteUser':
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $userId = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT);

        $passwordCheck = checkPassword($userId, $password);

        if ($passwordCheck) {
            $deleteSuccess = deleteUser($userId);
            if ($deleteSuccess === 1) {
                $_COOKIE['username'] = NULL;
                $_SESSION = array();
                session_destroy();
                header('Location: /index.php');
                exit;
                break;
            } else {
                $message = 'There was a problem deleting user from the database, try again.';
                include $_SERVER['DOCUMENT_ROOT'] . '/view/userDelete.php';
                exit;
                break;
            }
        } else {
            $message = 'Password didnt\'t match, try again. ';
            include $_SERVER['DOCUMENT_ROOT'] . '/view/userDelete.php';
            exit;
            break;
        }
        break;
    case 'userDetails':
        $userRecipes = getUserRecipes($_SESSION['userData']['userid']);

        include $_SERVER['DOCUMENT_ROOT'] . '/view/userDetails.php';
        break;
    default:
        header('Location: /view/error.php');
        break;
}
