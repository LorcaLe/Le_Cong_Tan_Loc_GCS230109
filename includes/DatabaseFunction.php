<?php
/* =================================
   CÁC HÀM CƠ BẢN (Helper)
================================= */

function query($pdo, $sql, $parameters = []) {
    $query = $pdo->prepare($sql);
    $query->execute($parameters);
    return $query;
}

/* =================================
   CÁC HÀM XỬ LÝ QUESTION
================================= */

function totalQuestion($pdo) {
    $query = query($pdo, 'SELECT COUNT(*) FROM question');
    $row = $query->fetch();
    return $row[0];
}

function allQuestions($pdo) {
    // Thêm q.userid để kiểm tra quyền sở hữu
    $sql = 'SELECT q.id, q.text, q.date, q.img, u.name, u.email, m.moduleName, q.userid
            FROM question q
            INNER JOIN user u ON q.userid = u.id
            INNER JOIN module m ON q.moduleid = m.id 
            ORDER BY q.id DESC';
    return query($pdo, $sql)->fetchAll();
}

function getQuestion($pdo, $id) {
    $parameters = [':id' => $id];
    $query = query($pdo, 'SELECT * FROM question WHERE id = :id', $parameters);
    return $query->fetch();
}

function getQuestionImg($pdo, $id) {
    $parameters = [':id' => $id];
    $stmt = query($pdo, 'SELECT img FROM question WHERE id = :id', $parameters);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// DÙNG CHO CẢ USER VÀ ADMIN
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

// DÙNG CHO CẢ USER VÀ ADMIN
function updateQuestionDetails($pdo, $id, $text, $moduleId, $imageFileName) {
    // Bắt đầu câu query
    $sql = 'UPDATE question SET text = :text, moduleid = :moduleid';
    $parameters = [
        ':text' => $text,
        ':moduleid' => $moduleId,
        ':id' => $id
    ];

    // Nếu có ảnh mới, thêm vào câu query
    if ($imageFileName !== null) {
        $sql .= ', img = :img';
        $parameters[':img'] = $imageFileName;
    }

    // Hoàn thành câu query
    $sql .= ' WHERE id = :id';
    
    query($pdo, $sql, $parameters);
}

function deleteQuestion($pdo, $id) {
    $query = 'DELETE FROM question WHERE id = :id';
    $parameters = [':id' => $id];
    query($pdo, $query, $parameters);
}

/* =================================
   CÁC HÀM XỬ LÝ MODULE
================================= */

function allModules($pdo) {
    $modules = query($pdo, 'SELECT id, moduleName FROM module');
    return $modules->fetchAll();
}

// (MỚI) Cho Admin quản lý
function insertModule($pdo, $moduleName) {
    $parameters = [':name' => $moduleName];
    query($pdo, 'INSERT INTO module (moduleName) VALUES (:name)', $parameters);
}

/* =================================
   CÁC HÀM XỬ LÝ USER / AUTH
================================= */

function allUsers($pdo) {
    $users = query($pdo, 'SELECT id, name FROM user');
    return $users->fetchAll();
}

// (MỚI) Dùng cho login
function getUserByEmail($pdo, $email) {
    $parameters = [':email' => $email];
    $query = query($pdo, 'SELECT * FROM user WHERE email = :email LIMIT 1', $parameters);
    return $query->fetch(PDO::FETCH_ASSOC);
}

// (MỚI) Dùng cho register
function checkEmailExists($pdo, $email) {
    $parameters = [':email' => $email];
    $query = query($pdo, 'SELECT id FROM user WHERE email = :email LIMIT 1', $parameters);
    return $query->fetch();
}

// (MỚI) Dùng cho register
function createUser($pdo, $name, $email, $hashedPassword) {
    $sql = "INSERT INTO user (name, email, password, role)
            VALUES (:name, :email, :password, 'user')";
    $parameters = [
        ':name' => $name,
        ':email' => $email,
        ':password' => $hashedPassword // Lưu mật khẩu đã HASH
    ];
    query($pdo, $sql, $parameters);
}

/* =================================
   CÁC HÀM XỬ LÝ CONTACT / INBOX
================================= */

// (MỚI) Dùng cho contact.php
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

// (MỚI) Dùng cho admin/inbox.php
function getAllContactMessages($pdo) {
    $sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
    return query($pdo, $sql)->fetchAll(PDO::FETCH_ASSOC);
}

// (MỚI) Dùng cho admin/view.php
function getContactMessageById($pdo, $id) {
    $parameters = [':id' => $id];
    $sql = "SELECT * FROM contact_messages WHERE id = :id";
    return query($pdo, $sql, $parameters)->fetch(PDO::FETCH_ASSOC);
}

// (MỚI) Dùng cho admin/view.php
function markMessageAsRead($pdo, $id) {
    // 0 = unread, 1 = read (dựa trên code admin_inbox.html.php)
    $parameters = [':id' => $id];
    $sql = "UPDATE contact_messages SET status = 'read' WHERE id = :id AND status = 'unread'";
    query($pdo, $sql, $parameters);
}

// (MỚI) Dùng cho admin/reply.php
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

// (MỚI) Dùng cho User Inbox
function getMessagesByUserId($pdo, $userId) {
    // Tên cột chính xác từ file SQL của bạn là 'user_id'
    $sql = "SELECT * FROM contact_messages 
            WHERE user_id = :userid_param 
            ORDER BY created_at DESC";
            
    $parameters = [':userid_param' => $userId];
    
    // Chúng ta sẽ chạy query trực tiếp ở đây để tránh lỗi
    $query = $pdo->prepare($sql);
    $query->execute($parameters);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function deleteModule($pdo, $id) {
    // Lưu ý: CSDL của bạn tự động SET NULL cho các question
    // nên chúng ta chỉ cần xóa module
    $parameters = [':id' => $id];
    query($pdo, 'DELETE FROM module WHERE id = :id', $parameters);
}

function getAllUsers($pdo) {
    // Lấy tất cả user (cho admin)
    $sql = "SELECT id, name, email, role FROM user ORDER BY name";
    return query($pdo, $sql)->fetchAll(PDO::FETCH_ASSOC);
}

function deleteUser($pdo, $id) {
    // Lưu ý: CSDL của bạn tự động XÓA CASCADE các question
    // và message của user này.
    $parameters = [':id' => $id];
    query($pdo, 'DELETE FROM user WHERE id = :id', $parameters);
}

/* =================================
   CÁC HÀM MỚI CHO "QUÊN MẬT KHẨU"
================================= */

function setResetToken($pdo, $email, $token) {
    // SỬA LỖI: Dùng NOW() + INTERVAL 1 HOUR của MySQL
    // thay vì dựa vào $expires của PHP
    $sql = "UPDATE `user` SET reset_token = :token, reset_expires = NOW() + INTERVAL 1 HOUR 
            WHERE email = :email";
    $parameters = [
        ':token' => $token,
        ':email' => $email
    ];
    query($pdo, $sql, $parameters);
}

function getUserByToken($pdo, $token) {
    // Thêm backtick `` xung quanh `user`
    $sql = "SELECT * FROM `user` 
            WHERE reset_token = :token AND reset_expires > NOW() 
            LIMIT 1";
    $parameters = [':token' => $token];
    return query($pdo, $sql, $parameters)->fetch(PDO::FETCH_ASSOC);
}

function updatePassword($pdo, $userId, $hashedPassword) {
    // Thêm backtick `` xung quanh `user`
    $sql = "UPDATE `user` SET password = :password, 
                reset_token = NULL, reset_expires = NULL 
            WHERE id = :id";
    $parameters = [
        ':password' => $hashedPassword,
        ':id' => $userId
    ];
    query($pdo, $sql, $parameters);
}

/* =================================
   CÁC HÀM MỚI CHO EDIT MODULE & USER
================================= */

function getModule($pdo, $id) {
    $parameters = [':id' => $id];
    return query($pdo, 'SELECT * FROM module WHERE id = :id', $parameters)->fetch(PDO::FETCH_ASSOC);
}

function updateModule($pdo, $id, $moduleName) {
    $sql = "UPDATE module SET moduleName = :name WHERE id = :id";
    $parameters = [':name' => $moduleName, ':id' => $id];
    query($pdo, $sql, $parameters);
}

function getUser($pdo, $id) {
    $parameters = [':id' => $id];
    return query($pdo, 'SELECT * FROM user WHERE id = :id', $parameters)->fetch(PDO::FETCH_ASSOC);
}

// Hàm cập nhật cho ADMIN (được sửa Role)
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

// Hàm cập nhật cho USER (chỉ sửa tên, email, và pass nếu có)
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

?>