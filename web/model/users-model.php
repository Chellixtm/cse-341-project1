<?php
function getAllUsers() {
    $db = recipeConnect();
    $sql = 'SELECT * FROM users';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $users;
}

function buildUsersDisplay($users) {
    $build = "<div class='container margin-top'>";
    $build .= "<div class='row'>";
    foreach($users as $u) {
        $build .= "<div class='card card-space-sides' style='width: 18rem;'>";
        $build .= "<div class='card-body'>";
        $build .= "<h5 class='card-title'>$u[username]</h5>";
        $build .= "<h6 class='card-subtitle mb-2 text-muted'>$u[email]</h6>";
        $build .= "<p>User Id: $u[userid]<br>";
        $build .= "<p>User Password: $u[password]</p>";
        $build .= "</div>";
        $build .= "</div>";
    }
    $build .= "</div>";
    $build .= "</div>";
    return $build;
}