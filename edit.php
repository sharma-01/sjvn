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
    exit("No ID provided");
}

$id = intval($_GET['id']);

// FETCH USER
$q = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");

if (!$q || mysqli_num_rows($q) == 0) {
    exit("User not found");
}

$user = mysqli_fetch_assoc($q);
?>

<div class="card">
  <h2>Edit User</h2>

  <form id="editForm">

    <input type="hidden" name="id" value="<?= $user['id'] ?>">

    <input name="name" value="<?= $user['name'] ?>" placeholder="Full Name" required>
    <input name="employee_id" value="<?= $user['employee_id'] ?>" placeholder="Employee ID" required>
    <input name="phone" value="<?= $user['phone'] ?>" placeholder="Phone Number" required>
    <input name="email" type="email" value="<?= $user['email'] ?>" required>

    <!-- PASSWORD OPTIONAL -->
    <input 
      type="password" 
      name="password" 
      placeholder="New Password (leave blank to keep old)">

    <select name="department" required>
      <?php
      $depts = ["ALL","HR","Finance","Commercial","PM","PO","ESS"];
      foreach($depts as $d){
        $sel = ($user['department'] == $d) ? "selected" : "";
        echo "<option value='$d' $sel>$d</option>";
      }
      ?>
    </select>

    <select name="role" required>
      <option value="user"  <?= $user['role']=="user"?"selected":"" ?>>User</option>
      <option value="admin" <?= $user['role']=="admin"?"selected":"" ?>>Admin</option>
    </select>

    <button type="submit" class="primary">Update User</button>

  </form>
</div>

<script>
document.getElementById("editForm").onsubmit = function(e){
  e.preventDefault();

  let formData = new FormData(this);

  fetch("update.php", {
    method: "POST",
    body: formData
  })
  .then(res => res.text())
  .then(msg => {
    alert(msg);

    // reload users list
    viewUsers();
  });
};
</script>