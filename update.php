<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $employee_id = $_POST['employee_id'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $role = $_POST['role'];

    // OPTIONAL: password update (agar diya ho)
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "UPDATE users SET 
            name='$name',
            employee_id='$employee_id',
            phone='$phone',
            email='$email',
            password='$password',
            department='$department',
            role='$role'
            WHERE id=$id";
    } else {
        $sql = "UPDATE users SET 
            name='$name',
            employee_id='$employee_id',
            phone='$phone',
            email='$email',
            department='$department',
            role='$role'
            WHERE id=$id";
    }

    if (mysqli_query($conn, $sql)) {
        echo "User Updated Successfully";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>