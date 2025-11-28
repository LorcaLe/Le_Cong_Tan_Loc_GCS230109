<?php

// General function to execute queries
function query($pdo, $sql, $parameters = []) {
    $query = $pdo->prepare($sql);
    $query->execute($parameters);
    return $query;
}

/* Function for Question */

// Get total number of questions
function totalQuestion($pdo) {
    $query = query($pdo, 'SELECT COUNT(*) FROM question');
    $row = $query->fetch();
    return $row[0];
}

// Get all questions with user name and module name
function allQuestions($pdo) {
    $sql = 'SELECT q.id, q.text, q.date, q.img, u.name, u.email, m.moduleName, q.userid
            FROM question q
            INNER JOIN user u ON q.userid = u.id
            INNER JOIN module m ON q.moduleid = m.id 
            ORDER BY q.id DESC';
    return query($pdo, $sql)->fetchAll();
}

// Get question by ID
function getQuestion($pdo, $id) {
    $parameters = [':id' => $id];
    $query = query($pdo, 'SELECT * FROM question WHERE id = :id', $parameters);
    return $query->fetch();
}

// Get question image filename by question ID
function getQuestionImg($pdo, $id) {
    $parameters = [':id' => $id];
    $stmt = query($pdo, 'SELECT img FROM question WHERE id = :id', $parameters);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Use for both user and admin
function insertQuestion($pdo, $text, $moduleid, $userid, $imageFileName) {
    $query = 'INSERT INTO question (text, date, img, userid, moduleid)
              VALUES (:text, CURDATE(), :img, :userid, :moduleid)';
    $parameters = [
        ':text' => $text,
        ':img' => $imageFileName,
        ':userid' => $userid,
        ':moduleid' => $moduleid
    ];
    query($pdo, $query, $parameters);
}

// Use for both user and admin
function updateQuestionDetails($pdo, $id, $text, $moduleId, $imageFileName) {

    $sql = 'UPDATE question SET text = :text, moduleid = :moduleid';
    $parameters = [
        ':text' => $text,
        ':moduleid' => $moduleId,
        ':id' => $id
    ];

    if ($imageFileName !== null) {
        $sql .= ', img = :img';
        $parameters[':img'] = $imageFileName;
    }

    $sql .= ' WHERE id = :id';
    
    query($pdo, $sql, $parameters);
}

// Use for both user and admin
function deleteQuestion($pdo, $id) {
    $query = 'DELETE FROM question WHERE id = :id';
    $parameters = [':id' => $id];
    query($pdo, $query, $parameters);
}

/* Function for modules */

// Get all modules (id and moduleName only)
function allModules($pdo) {
    $modules = query($pdo, 'SELECT id, moduleName FROM module');
    return $modules->fetchAll();
}

// Get module by ID
function getModule($pdo, $id) {
    $parameters = [':id' => $id];
    return query($pdo, 'SELECT * FROM module WHERE id = :id', $parameters)->fetch(PDO::FETCH_ASSOC);
}

// Insert new module
function insertModule($pdo, $moduleName) {
    $parameters = [':name' => $moduleName];
    query($pdo, 'INSERT INTO module (moduleName) VALUES (:name)', $parameters);
}

// Update module by ID
function updateModule($pdo, $id, $moduleName) {
    $sql = "UPDATE module SET moduleName = :name WHERE id = :id";
    $parameters = [':name' => $moduleName, ':id' => $id];
    query($pdo, $sql, $parameters);
}

// Delete module by ID
function deleteModule($pdo, $id) {
    $parameters = [':id' => $id];
    query($pdo, 'DELETE FROM module WHERE id = :id', $parameters);
}


/* Function for user*/

// Get all users (id and name only)
function allUsers($pdo) {
    $users = query($pdo, 'SELECT id, name FROM user');
    return $users->fetchAll();
}

// Get user by ID
function getUser($pdo, $id) {
    $parameters = [':id' => $id];
    return query($pdo, 'SELECT * FROM user WHERE id = :id', $parameters)->fetch(PDO::FETCH_ASSOC);
}

// Function for admin to get all users
function getAllUsers($pdo) {
    $sql = "SELECT id, name, email, role FROM user ORDER BY name";
    return query($pdo, $sql)->fetchAll(PDO::FETCH_ASSOC);
}

// Function for admin to delete user
function deleteUser($pdo, $id) {
    $parameters = [':id' => $id];
    query($pdo, 'DELETE FROM user WHERE id = :id', $parameters);
}

// Function for admin to update user details
function updateUserByAdmin($pdo, $id, $name, $email, $role) {
    $sql = "UPDATE user SET name = :name, email = :email, role = :role WHERE id = :id";
    $parameters = [
        ':name' => $name, 
        ':email' => $email, 
        ':role' => $role, 
        ':id' => $id
    ];
    query($pdo, $sql, $parameters);
}

// Function for user to update own profile
function updateUserProfile($pdo, $id, $name, $email, $password = null) {
    if ($password) {
        $sql = "UPDATE user SET name = :name, email = :email, password = :pass WHERE id = :id";
        $parameters = [':name' => $name, ':email' => $email, ':pass' => $password, ':id' => $id];
    } else {
        $sql = "UPDATE user SET name = :name, email = :email WHERE id = :id";
        $parameters = [':name' => $name, ':email' => $email, ':id' => $id];
    }
    query($pdo, $sql, $parameters);
}

// Function for login
function getUserByEmail($pdo, $email) {
    $parameters = [':email' => $email];
    $query = query($pdo, 'SELECT * FROM user WHERE email = :email LIMIT 1', $parameters);
    return $query->fetch(PDO::FETCH_ASSOC);
}

// Function for register
function checkEmailExists($pdo, $email) {
    $parameters = [':email' => $email];
    $query = query($pdo, 'SELECT id FROM user WHERE email = :email LIMIT 1', $parameters);
    return $query->fetch();
}

// Function to create new user
function createUser($pdo, $name, $email, $hashedPassword) {
    $sql = "INSERT INTO user (name, email, password, role)
            VALUES (:name, :email, :password, 'user')";
    $parameters = [
        ':name' => $name,
        ':email' => $email,
        ':password' => $hashedPassword 
    ];
    query($pdo, $sql, $parameters);
}

/* Function for contact and inbox*/

// Function for contact
function insertContactMessage($pdo, $userId, $name, $email, $subject, $message) {
    $sql = "INSERT INTO contact_messages (user_id, sender_name, sender_email, subject, message)
            VALUES (:uid, :name, :email, :subject, :message)";
    $parameters = [
        ':uid' => $userId,
        ':name' => $name,
        ':email' => $email,
        ':subject' => $subject,
        ':message' => $message
    ];
    query($pdo, $sql, $parameters);
}

// Function for admin inbox
function getAllContactMessages($pdo) {
    $sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
    return query($pdo, $sql)->fetchAll(PDO::FETCH_ASSOC);
}

// Function for admin view message
function getContactMessageById($pdo, $id) {
    $parameters = [':id' => $id];
    $sql = "SELECT * FROM contact_messages WHERE id = :id";
    return query($pdo, $sql, $parameters)->fetch(PDO::FETCH_ASSOC);
}

// Function to mark message as read
function markMessageAsRead($pdo, $id) {
    $parameters = [':id' => $id];
    $sql = "UPDATE contact_messages SET status = 'read' WHERE id = :id AND status = 'unread'";
    query($pdo, $sql, $parameters);
}

// Function for admin reply message
function replyToContactMessage($pdo, $id, $replyMessage) {
    $sql = "UPDATE contact_messages 
            SET reply_message = :reply, status = 'replied', replied_at = NOW()
            WHERE id = :id";
    $parameters = [
        ':reply' => $replyMessage,
        ':id' => $id
    ];
    query($pdo, $sql, $parameters);
}

// Function for user inbox
function getMessagesByUserId($pdo, $userId) {

    $sql = "SELECT * FROM contact_messages 
            WHERE user_id = :userid_param 
            ORDER BY created_at DESC";
            
    $parameters = [':userid_param' => $userId];
    
    $query = $pdo->prepare($sql);
    $query->execute($parameters);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}


/* Function for forgot password*/

// Set reset token and expiration
function setResetToken($pdo, $email, $token) {
    $sql = "UPDATE `user` SET reset_token = :token, reset_expires = NOW() + INTERVAL 1 HOUR 
            WHERE email = :email";
    $parameters = [
        ':token' => $token,
        ':email' => $email
    ];
    query($pdo, $sql, $parameters);
}

// Get user by reset token
function getUserByToken($pdo, $token) {
    $sql = "SELECT * FROM `user` 
            WHERE reset_token = :token AND reset_expires > NOW() 
            LIMIT 1";
    $parameters = [':token' => $token];
    return query($pdo, $sql, $parameters)->fetch(PDO::FETCH_ASSOC);
}

// Update password and clear reset token
function updatePassword($pdo, $userId, $hashedPassword) {
    $sql = "UPDATE `user` SET password = :password, 
                reset_token = NULL, reset_expires = NULL 
            WHERE id = :id";
    $parameters = [
        ':password' => $hashedPassword,
        ':id' => $userId
    ];
    query($pdo, $sql, $parameters);
}

?>