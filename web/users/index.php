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
        include $_SERVER['DOCUMENT_ROOT'].'/view/login.php';
        break;
    case 'loginUser':
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        if(empty($username) || $empty($password)) {
            $message = '<p>Please fill in all field.</p>';
            include $_SERVER['DOCUMENT_ROOT'].'/view/login.php';
            exit;
            break;
        }

        
        break;
    case 'createPage':
        break;
    case 'createUser':
        break;
    case 'delete':
        break;
    case 'update':
        break;
    case 'userDetails':
        include $_SERVER['DOCUMENT_ROOT'].'/view/userDetails.php';
        break;
    default:
        header('Location: /view/error.php');
        break;
}