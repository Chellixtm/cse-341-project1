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
    $stmt = $db->prepare('SELECT * FROM recipes WHERE recipeId = :recipeid');
    $stmt->bindValue(':recipeid', $recipeId);
    $stmt->execute();
    $recipe = $stmt->fetch();
    $stmt->closeCursor();
    return $recipe;
}

function insertRecipe($userId, $recipeName, $recipeDesc, $recipeInstruct)
{
    $db = recipeConnect();
    $stmt = $db->prepare('INSERT INTO recipes (userId, recipeName, recipeDesc, recipeInstruct) 
                            VALUES (:userid, :recipename, :recipedesc, :recipeinstruct)');
    $stmt->bindValue(':userid', $userId);
    $stmt->bindValue(':recipename', $recipeName);
    $stmt->bindValue(':recipeDesc', $recipeDesc);
    $stmt->bindValue(':recipeinstruct', $recipeInstruct);
    $stmt->execute();
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

function buildRecipesDisplay($recipes)
{
    $build = "<div class='container margin-top'>";
    $build .= "<div class='row'>";
    foreach ($recipes as $r) {
        $build .= "<div class='card card-space-sides' style='width: 18rem;'>";
        $build .= "<div class='card-body'>";
        $build .= "<h5 class='card-title'>$r[recipename]</h5>";
        $build .= "<h6 class='card-subtitle mb-2 text-muted'>$r[recipedesc]</h6>";
        $build .= "<p>Id of Recipe: $r[recipeid]<br>";
        $build .= "<p>User Id of Recipe: $r[userid]<br>";
        $build .= "<p>Recipe Text: r[recipeinstruct]</p>";
        $build .= "</div>";
        $build .= "</div>";
    }
    $build .= "</div>";
    $build .= "</div>";
    return $build;
}
