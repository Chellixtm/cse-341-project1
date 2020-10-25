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
        $recipesDisplay = buildBrowseDisplay();

        include $_SERVER['DOCUMENT_ROOT'].'/view/browse.php';
        break;
    case 'recipeDetail':
        $recipeId = filter_input(INPUT_GET, 'recipeid', FILTER_SANITIZE_STRING);

        $recipe = getRecipe($recipeId);

        $recipeIngredients = getRecipeIngredients($recipeId);
        
        if(!empty($recipe)) {
            include $_SERVER['DOCUMENT_ROOT'] . '/view/recipeDetail.php';
            exit;
            break;        
        } else {
            header('Location: /view/error.php');
            exit;
            break;
        }
        break;
    case 'createPage':
        include $_SERVER['DOCUMENT_ROOT'].'/view/recipeCreate.php';
        break;
    case 'createRecipe':
        $recipeName = filter_input(INPUT_POST, 'recipeName', FILTER_SANITIZE_STRING);
        $recipeDesc = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $recipeInstructions = filter_input(INPUT_POST, 'instructions', FILTER_SANITIZE_STRING);
        $userId = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_NUMBER_INT);
        $ingredients = $_POST['ingredient'];

        if (empty($recipeName) || empty($recipeInstructions) || empty($ingredients)) {
            $message = 'Please fill in all the fields.';
            include $_SERVER['DOCUMENT_ROOT'] . 'view/recipeCreate.php';
            exit;
            break;
        }

        $recipeId = insertRecipe($userId, $recipeName, $recipeDesc, $recipeInstructions);

        $ingredientsSuccess = insertIngredients($recipeId, $ingredients);

        foreach($ingredientsSuccess as $iS) {
            if($iS === 0) {
                $message = 'There was an error trying to insert the recipe, try again.';
                include $_SERVER['DOCUMENT_ROOT'] . 'view/recipeCreate.php';
                exit;
                break;
            }
        }

        header("Location: /recipe/index.php?action=recipeDetail&recipeid=$recipeId");
        exit;
        break;
    case 'deletePage':
        break;
    case 'deleteRecipe':
        break;
    default:
        header('Location: /view/error.php');
        break;
}
