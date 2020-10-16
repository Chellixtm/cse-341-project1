<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/library/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/library/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/ingredients-model.php';

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'browse':
        $recipes = getAllRecipes();
        
        if (!empty($recipes)) {
            $recipesDisplay = buildRecipesDisplay($recipes);
        } else {
            $errorMsg = '<h1>ERROR, NO RECIPES</h1>';
            include $_SERVER['DOCUMENT_ROOT'] . '/view/error.php';
            break;
        }

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
