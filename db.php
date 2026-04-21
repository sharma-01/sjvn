<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = mysqli_connect("localhost", "root", "", "sjvn");

if (!$conn) {
    die("DB Connection Failed");
}
?> 