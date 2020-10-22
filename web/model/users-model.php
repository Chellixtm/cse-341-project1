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

function getUser($username) {
    $db = recipeConnect();
    $stmt = $db->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch();
    $stmt->closeCursor();
    return $user;
}

function insertUser($username, $email, $password) {
    $db = recipeConnect();
    $stmt = $db->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password);
    $stmt->execute();
}

function updateUser($userId, $username, $email, $password) {
    $db = recipeConnect();
    $stmt = $db->prepare('UPDATE users SET
    username = :username,
    email = :email,
    password = :password
    WHERE userId = :userid');
    $stmt->bindValue(':userid', $userId);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password);
    $stmt->execute();
}

function deleteUser($userId) {
    $db = recipeConnect();
    $stmt = $db->prepare('DELETE FROM users WHERE userId = :userid');
    $stmt->bindValue(':userid', $userId);
    $stmt->execute();
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