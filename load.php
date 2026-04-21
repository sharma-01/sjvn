<?php
include "db.php";

$q = mysqli_query($conn,"SELECT * FROM users ORDER BY id DESC");

echo "<div class='card'><h2>All Users</h2>";

if(mysqli_num_rows($q)==0){

  echo "<p>No users found.</p>";

}else{

  echo "
  <table>
    <tr>
      <th>Name</th>
      <th>Emp ID</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Department</th>
      <th>Role</th>
      <th>Action</th>
    </tr>
  ";

  while($r = mysqli_fetch_assoc($q)){

    echo "
    <tr>
      <td>{$r['name']}</td>
      <td>{$r['employee_id']}</td>
      <td>{$r['email']}</td>
      <td>{$r['phone']}</td>
      <td>{$r['department']}</td>
      <td>{$r['role']}</td>
      <td>
        <div class='action-btns'>
          <button onclick='editUser({$r['id']})' class='edit-btn'>Edit</button>
          <button onclick='deleteUser({$r['id']})' class='del-btn'>Delete</button>
        </div>
      </td>
    </tr>
    ";
  }

  echo "</table>";
}

echo "</div>";
?>