<?php
include "db.php";

// START SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// CHECK ADMIN
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    exit("Unauthorized");
}

// CHECK ID
if (!isset($_GET['id'])) {
    exit("No ID received");
}

$id = intval($_GET['id']);

// DELETE QUERY
$q = "DELETE FROM users WHERE id = $id";

if (mysqli_query($conn, $q)) {

    if (mysqli_affected_rows($conn) > 0) {
        echo "User deleted successfully";
    } else {
        echo "User not found";
    }

} else {
    echo "Delete failed: " . mysqli_error($conn);
}
?>