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

function checkUserExist($username) {
    $db = recipeConnect();
    $stmt = $db->prepare('SELECT username FROM users WHERE username = :username');
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $matchUser = $stmt->fetch();
    $stmt->closeCursor();
    if(empty($matchUser)) {
        return 0;
    } else {
        return 1;
    }
}

function checkPassword($userId, $password) {
    $db = recipeConnect();
    $stmt = $db->prepare('SELECT password FROM users WHERE userId = :userid');
    $stmt->bindValue(':userid', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $dbPass = $stmt->fetch();
    $stmt->closeCursor();
    return password_verify($password, $dbPass['password']);
}

function insertUser($username, $email, $password) {
    $db = recipeConnect();
    $stmt = $db->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password);
    $stmt->execute();
    $result = $stmt->rowCount();
    $stmt->closeCursor();
    return $result;
}

function updateUser($userId, $username, $email, $password) {
    $db = recipeConnect();
    if(empty($password)) {
        $stmt = $db->prepare('UPDATE users SET
        username = :username,
        email = :email
        WHERE userId = :userid');
        $stmt->bindValue(':userid', $userId);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':email', $email);
    } else {
        $stmt = $db->prepare('UPDATE users SET
        username = :username,
        email = :email,
        password = :password
        WHERE userId = :userid');
        $stmt->bindValue(':userid', $userId);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);
    }
    $stmt->execute();
    $result = $stmt->rowCount();
    $stmt->closeCursor();
    return $result;
}

function deleteUser($userId) {
    $db = recipeConnect();
    $stmt = $db->prepare('DELETE FROM users WHERE userId = :userid');
    $stmt->bindValue(':userid', $userId);
    $stmt->execute();
    $result = $stmt->rowCount();
    $stmt->closeCursor();
    return $result;
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