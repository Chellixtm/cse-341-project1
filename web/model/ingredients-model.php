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

function updateIngredients($recipeId, $ingredients) {
    // get database connection
    $db = recipeConnect();

    // get an array of all the ingredients currently connected to a recipe in
    // the database. 
    $rnstmt = $db->prepare('SELECT i.*
                            FROM recipeIngredient ri 
                            INNER JOIN ingredients i ON ri.ingredientId = i.ingredientId 
                            INNER JOIN recipes r on ri.recipeId = r.recipeId
                            WHERE ri.recipeId = :recipeId');
    $rnstmt->bindValue(':recipeId', $recipeId);
    $rnstmt->execute();
    $recipeNames = $rnstmt->fetchAll();
    $rnstmt->closeCursor();

    // delete any ingredients that are no longer wanted in the recipe
    foreach($recipeNames as $rn) {
        $inRn = false;
        // check if the name is contained in the ingredients array
        foreach($ingredients as $i) {
            if($rn['name'] == $i['name']) {
                $inRn = true;
            }
        }

        // delete ingredient if it doesn't exist in the ingredients array
        if(!$inRn) {
            $drnstmt = $db->prepare('DELETE FROM recipeIngredient WHERE recipeId = :recipeId AND ingredientId = :ingredientId');
            $drnstmt->bindValue(':recipeId', $recipeId);
            $drnstmt->bindValue(':ingredientId', $rn['ingredientid']);
            $drnstmt->execute();
        }
    }

    // Go through the current ingredients and insert them into the database
    // if they are new
    foreach($ingredients as $i) {

        $stmt = $db->prepare('SELECT COUNT(*) from ingredients WHERE name = :name');
        $stmt->bindValue(':name', $i['name']);
        $stmt->execute();
        $exists = $stmt->fetch();
        $stmt->closeCursor();

        if ($exists['count'] < 1) {
            $stmt2 = $db->prepare('INSERT INTO ingredients (name) VALUES (:name)');
            $stmt2->bindValue(':name', $i['name']);
            $stmt2->execute();
        }

        // get the id of the ingredient
        $stmt3 = $db->prepare('SELECT * FROM ingredients WHERE name = :name');
        $stmt3->bindValue(':name', $i['name']);
        $stmt3->execute();
        $ingredientId = $stmt3->fetch();
        $stmt3->closeCursor();

        // Check if there is a recipeIngredient for this ingredient in this recipe
        $stmt4 = $db->prepare('SELECT * FROM recipeIngredient WHERE ingredientId = :ingredientid AND recipeId = :recipeid');
        $stmt4->bindValue(':ingredientid', $ingredientId['ingredientid']);
        $stmt4->bindValue(':recipeid', $recipeId);
        $stmt4->execute();
        $ri = $stmt4->fetch();
        $riexists = $stmt4->rowCount();
        $stmt4->closeCursor();

        // If it does exists update it
        if($riexists > 0) {
            $stmt5 = $db->prepare('UPDATE recipeIngredient SET
                                    amount = :amount,
                                    measurement = :measurement
                                    WHERE recIngId = :recingid');
            $stmt5->bindValue(':amount', $i['amount']);
            $stmt5->bindValue(':measurement', $i['measurement']);
            $stmt5->bindValue(':recingid', $ri['recingid']);
            $stmt5->execute();
            $stmt5->closeCursor();
        }
        // If it doesn't exist insert it into the database
        else {
            $stmt6 = $db->prepare('INSERT INTO recipeIngredient (recipeId, ingredientId, amount, measurement) 
                                    VALUES (:recipeid, :ingredientid, :amount, :measurement)');
            $stmt6->bindValue(':recipeid', $recipeId);
            $stmt6->bindValue(':ingredientid', $ingredientId['ingredientid']);
            $stmt6->bindValue(':amount', $i['amount']);
            $stmt6->bindValue(':measurement', $i['measurement']);
            $stmt6->execute();
        }
    }
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