<?php
function getAllRecipes()
{
    $db = recipeConnect();
    $sql = 'SELECT * FROM recipes';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $recipes;
}

function getRecipe($recipeId) {
    $db = recipeConnect();
    $stmt = $db->prepare('SELECT recipes.*, users.username FROM recipes INNER JOIN users ON recipes.userid = users.userid WHERE recipeId = :recipeid');
    $stmt->bindValue(':recipeid', $recipeId);
    $stmt->execute();
    $recipe = $stmt->fetch();
    $stmt->closeCursor();
    return $recipe;
}

function getUserRecipes($userId) {
    $db = recipeConnect();
    $stmt = $db->prepare('SELECT * FROM recipes WHERE userId = :userId');
    $stmt->bindValue(':userid', $userId);
    $stmt->execute();
    $recipes = $stmt->fetchAll();
    $stmt->closeCursor();
    return $recipes;
}

function insertRecipe($userId, $recipeName, $recipeDesc, $recipeInstruct)
{
    $db = recipeConnect();
    $stmt = $db->prepare('INSERT INTO recipes (userId, recipeName, recipeDesc, recipeInstruct) 
                            VALUES (:userid, :recipename, :recipedesc, :recipeinstruct)');
    $stmt->bindValue(':userid', $userId);
    $stmt->bindValue(':recipename', $recipeName);
    $stmt->bindValue(':recipedesc', $recipeDesc);
    $stmt->bindValue(':recipeinstruct', $recipeInstruct);
    $stmt->execute();
    $result = $db->lastInsertId();
    $stmt->closeCursor();
    return $result;
}

function updateRecipe($userId, $recipeName, $recipeDesc, $recipeInstruct)
{
    $db = recipeConnect();
    $stmt = $db->prepare('UPDATE recipes SET 
                            userId = :userid, 
                            recipeName = :recipename, 
                            recipeDesc = :recipedesc, 
                            recipeInstruct = :recipeInstruct 
                            WHERE recipeId = :recipeid');
    $stmt->bindValue(':userid', $userId);
    $stmt->bindValue(':recipename', $recipeName);
    $stmt->bindValue(':recipeDesc', $recipeDesc);
    $stmt->bindValue(':recipeinstruct', $recipeInstruct);
    $stmt->execute();
}

function deleteRecipe($recipeId)
{
    $db = recipeConnect();
    $stmt = $db->prepare('DELETE FROM recipes WHERE recipeId = :recipeid');
    $stmt->bindValue('recipeid', $recipeId);
    $stmt->execute();
}

function buildBrowseDisplay() {
    $db = recipeConnect();
    $sql = 'SELECT recipes.*, users.username FROM recipes INNER JOIN users ON recipes.userid = users.userid ORDER BY userId DESC LIMIT 9';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    $build = "<div class='container margin-top'>";
    $build .= "<div class='row row-col-3'>";
    foreach ($recipes as $r) {
        // TODO: Write code for building recipe cards
        $build .= "<div class='col'>";
        $build .= "<a href='/recipe/index.php?action=recipeDetail&recipeid=$r[recipeid]' class='remove-link-style'>";
        $build .= "<div class='card card-space-sides card-same-height' style='width: 18rem;'>";
        $build .= "<div class='card-body shadow card-background-highlight'>";
        $build .= "<h5 class='card-title'>$r[recipename]</h5>";
        $build .= "<h6 class='card-subtitle mb-2 text-muted'>Created By: $r[username]</h6>";
        $build .= "<p class='card-text'>$r[recipedesc]</p>";
        $build .= "</div>";
        $build .= "</div>";
        $build .= "</a>";
        $build .= "</div>";
    }
    $build .= "</div>";
    $build .= "</div>";
    return $build;
}

// function buildRecipesDisplay($recipes)
// {
//     $build = "<div class='container margin-top'>";
//     $build .= "<div class='row'>";
//     foreach ($recipes as $r) {
//         $build .= "<div class='card card-space-sides' style='width: 18rem;'>";
//         $build .= "<div class='card-body'>";
//         $build .= "<h5 class='card-title'>$r[recipename]</h5>";
//         $build .= "<h6 class='card-subtitle mb-2 text-muted'>$r[recipedesc]</h6>";
//         $build .= "<p>Id of Recipe: $r[recipeid]<br>";
//         $build .= "<p>User Id of Recipe: $r[userid]<br>";
//         $build .= "<p>Recipe Text: r[recipeinstruct]</p>";
//         $build .= "</div>";
//         $build .= "</div>";
//     }
//     $build .= "</div>";
//     $build .= "</div>";
//     return $build;
// }
