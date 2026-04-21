<?php
include "db.php";

// START SESSION (important)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// CHECK ADMIN
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Unauthorized";
    exit;
}

// CHECK REQUEST METHOD
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // GET DATA SAFELY
    $name   = mysqli_real_escape_string($conn, $_POST['name']);
    $emp    = mysqli_real_escape_string($conn, $_POST['employee_id']);
    $phone  = mysqli_real_escape_string($conn, $_POST['phone']);
    $email  = mysqli_real_escape_string($conn, $_POST['email']);
    $plainPassword = $_POST['password'];
    $dept   = ($_POST['department'] == "ALL") ? "ALL" : $_POST['department'];
    $role   = mysqli_real_escape_string($conn, $_POST['role']);

    // HASH PASSWORD
    $pass = password_hash($plainPassword, PASSWORD_DEFAULT);

    // INSERT QUERY
    $query = "INSERT INTO users 
    (name, employee_id, phone, email, password, department, role)
    VALUES 
    ('$name','$emp','$phone','$email','$pass','$dept','$role')";

    if (mysqli_query($conn, $query)) {

        // OPTIONAL MAIL
        $subject = "Your ERP Account Created";

        $message = "Hello $name,

Your ERP account has been created.

Email: $email
Password: $plainPassword
Role: $role
Department: $dept

Login: http://localhost/sjvn/login.php

Please change your password.";

        $headers = "From: erp@sjvn.com";

        @mail($email, $subject, $message, $headers);

        // 🔥 IMPORTANT: RETURN MESSAGE (NO REDIRECT)
        echo "User created successfully";

    } else {
        echo "Error: " . mysqli_error($conn);
    }

} else {
    echo "Invalid request";
}
?>