<?php
function getAllRecipes() {
    $db = recipeConnect();
    $sql = 'SELECT * FROM recipes';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $recipes;
}

function buildRecipesDisplay($recipes) {
    $build = "<div class='container margin-top'>";
    $build .= "<div class='row'>";
    foreach($recipes as $r) {
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