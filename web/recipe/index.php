<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/library/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/library/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/recipe-model.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/model/ingredients-model.php';

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'browse':
        $recipes = getAllRecipes();
        $ingredients = getAllIngredients();
        $rIngredients = getAllRecipeIngredient();
        $recipesDisplay = '';
        
        if (!empty($recipes)) {
            $recipesDisplay .= buildRecipesDisplay($recipes);
        } else {
            $errorMsg = '<h1>ERROR, NO RECIPES</h1>';
            include $_SERVER['DOCUMENT_ROOT'] . '/view/error.php';
            break;
        }

        if (!empty($ingredients)) {
            $recipesDisplay .= buildIngredientsDisplay($ingredients);
        } else {
            $errorMsg = '<h1>ERROR, NO INGREDIENTS</h1>';
            include $_SERVER['DOCUMENT_ROOT'] . '/view/error.php';
            break;
        }

        if (!empty($rIngredients)) {
            $recipesDisplay .= buildRecipeIngredientDisplay($rIngredients);
        } else {
            $errorMsg = '<h1>ERROR, NO RECIPE INGREDIENTS</h1>';
            include $_SERVER['DOCUMENT_ROOT'] . '/view/error.php';
            break;
        }

        include $_SERVER['DOCUMENT_ROOT'].'/view/browse.php';
        break;
    case 'createPage':
        break;
    case 'createRecipe':
        break;
    case 'deletePage':
        break;
    case 'deleteRecipe':
        break;
    default:
        header('Location: /view/error.php');
        break;
}
