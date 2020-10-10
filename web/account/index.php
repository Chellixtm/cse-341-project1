<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/library/functions.php';

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'login':
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
