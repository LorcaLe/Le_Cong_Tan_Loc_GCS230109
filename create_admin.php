<?php

// 1. Nạp file kết nối CSDL
require 'includes/DatabaseConnection.php';

echo "Script bắt đầu...<br>";

// 2. Định nghĩa thông tin Admin
$admin_name = 'admin';
$admin_email = 'admin@ex.com';
$admin_password = 'admin123'; // Đặt mật khẩu bạn muốn

// 3. Băm mật khẩu (Rất quan trọng)
$hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);

try {
    // 4. Kiểm tra xem email đã tồn tại chưa
    $check_sql = "SELECT id FROM user WHERE email = :email LIMIT 1";
    $check_stmt = $pdo->prepare($check_sql);
    $check_stmt->execute(['email' => $admin_email]);

    if ($check_stmt->fetch()) {
        echo "LỖI: Email " . htmlspecialchars($admin_email) . " đã tồn tại. Không tạo tài khoản.";
    } else {
        // 5. Câu lệnh SQL để chèn Admin
        $sql = "INSERT INTO user (name, email, password, role) 
                VALUES (:name, :email, :password, 'admin')"; // Chỉ định rõ role là 'admin'

        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            ':name' => $admin_name,
            ':email' => $admin_email,
            ':password' => $hashed_password
        ]);

        echo "THÀNH CÔNG: Đã tạo tài khoản admin '" . htmlspecialchars($admin_name) . "' với mật khẩu '" . htmlspecialchars($admin_password) . "'.";
    }

} catch (PDOException $e) {
    die("LỖI CSDL: " . $e->getMessage());
}

echo "<br>...Script kết thúc.";

?>