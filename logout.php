<?php
session_start();
session_destroy();
?>

<script>
localStorage.removeItem("activePage"); // ✅ RESET
window.location.href = "index.php";
</script>