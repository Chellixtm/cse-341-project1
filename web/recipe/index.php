<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/library/functions.php';

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'browse':
        include $_SERVER['DOCUMENT_ROOT'].'/view/browse.php';
        break;
    case 'create':
        break;
    case 'delete':
        break;
    default:
        header('Location: /view/error.php');
        break;
}
