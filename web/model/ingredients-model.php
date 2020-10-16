<?php
function getAllIngredients() {
    $db = recipeConnect();
    $sql = 'SELECT * FROM ingredients';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $ingredients;
}

function getAllRecipeIngredient() {
    $db = recipeConnect();
    $sql = 'SELECT * FROM recipeIngredient';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $recipeIngredients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $recipeIngredients;
}

function buildIngredientsDisplay($ingredients) {
    $build = "<div class='container margin-top'>";
    $build .= "<div class='row'>";
    foreach($ingredients as $i) {
        $build .= "<div class='card card-space-sides' style='width: 18rem;'>";
        $build .= "<div class='card-body'>";
        $build .= "<h5 class='card-title'>$i[name]</h5>";
        $build .= "<p>Id of Ingredient: $i[ingredientid]</p>";
        $build .= "</div>";
        $build .= "</div>";
    }
    $build .= "</div>";
    $build .= "</div>";
    return $build;
}

function buildRecipeIngredientDisplay($recipeIngredient) {
    $build = "<div class='container margin-top'>";
    $build .= "<div class='row'>";
    foreach($recipeIngredient as $ri) {
        $build .= "<div class='card card-space-sides' style='width: 18rem;'>";
        $build .= "<div class='card-body'>";
        $build .= "<h5 class='card-title'>Recipe Ingredient</h5>";
        $build .= "<p>Id of Recipe Ingredient: $ri[recingid]<br>";
        $build .= "<p>Id of Parent Recipe: $ri[recipeid]<br>";
        $build .= "<p>Id of Base Ingredient: $ri[ingredientid]<br>";
        $build .= "<p>Amount used in recipe: $ri[amount]<br>";
        $build .= "<p>Measurement Used: $ri[measurement]</p>";
        $build .= "</div>";
        $build .= "</div>";
    }
    $build .= "</div>";
    $build .= "</div>";
    return $build;
}