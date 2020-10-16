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
    case 'login':
        $users = getAllUsers();
        $userDisplay = '';

        if (!empty($users)) {
            $userDisplay .= buildUsersDisplay($users);
        } else {
            $errorMsg = '<h1>ERROR, NO USERS</h1>';
            include $_SERVER['DOCUMENT_ROOT'] . '/view/error.php';
            break;
        }

        include $_SERVER['DOCUMENT_ROOT'].'/view/login.php';
        break;
    case 'create':
        break;
    case 'delete':
        break;
    case 'update':
        break;
    default:
        header('Location: /view/error.php');
        break;
}
