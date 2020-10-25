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

function getRecipeIngredients($recipeId) {
    $db = recipeConnect();
    $sql = 'SELECT recipeIngredient.*, ingredients.name FROM recipeIngredient INNER JOIN ingredients ON recipeIngredient.ingredientId = ingredients.ingredientId WHERE recipeIngredient.recipeid = :recipeid';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':recipeid', $recipeId);
    $stmt->execute();
    $recipeIngredients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $recipeIngredients;
}

function insertIngredients($recipeId, $ingredients) {
    $db = recipeConnect();
    $result = array();
    foreach($ingredients as $i) {
        $stmt = $db->prepare('SELECT COUNT(*) FROM ingredients WHERE name = :name');
        $stmt->bindValue(':name', $i['name']);
        $stmt->execute();
        $count = $stmt->fetch();
        $stmt->closeCursor();

        if ($count['count'] === 0) {
            $stmt2 = $db->prepare('INSERT INTO ingredients (name) VALUES (:name)');
            $stmt2->bindValue(':name', $i['name']);
            $stmt2->execute();
            $stmt2->closeCursor();
        }


        $stmt4 = $db->prepare('SELECT * FROM ingredients WHERE name = :name');
        $stmt4->bindValue(':name', $i['name']);
        $stmt4->execute();
        $ingredientId = $stmt4->fetch()['ingredientid'];
        $stmt4->closeCursor();
        

        $stmt3 = $db->prepare('INSERT INTO recipeIngredient (recipeId, ingredientId, amount, measurement) VALUES (:recipeid, :ingredientid, :amount, :measurement)');
        $stmt3->bindValue(':recipeid', $recipeId);
        $stmt3->bindValue(':ingredientid', $ingredientId);
        $stmt3->bindValue(':amount', $i['amount']);
        $stmt3->bindValue(':measurement', $i['measurement']);
        $stmt3->execute();
        $insertResult = $stmt3->rowCount();
        array_push($result, $insertResult);
        $stmt3->closeCursor();
    }
    return $result;
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