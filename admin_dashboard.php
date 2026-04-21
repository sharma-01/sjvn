<?php
include "db.php";

if (!isset($_SESSION['role'])) {
  header("Location: login.php");
  exit;
}

$role = $_SESSION['role'];
$department = $_SESSION['department'] ?? '';
?>
<!DOCTYPE html>
<html>
<head>
<title>ERP Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:"Poppins", sans-serif;
}

/* BODY */
body{
  background:#eef2f7;
  overflow:auto; /* 🔥 FIX */
  display:flex;
  flex-direction:column;
  min-height:100vh; /* 🔥 ADD */
}

/* ================= SIDEBAR ================= */
.sidebar{
  width:260px;
  background:linear-gradient(180deg,#0b3c7a,#092c5c);
  color:#fff;
  position:fixed;
  top:70px;
  left:0;
  height:calc(100% - 70px);
  padding:20px 15px;
  box-shadow:5px 0 20px rgba(0,0,0,.1);
}

.sidebar h2{
  text-align:center;
  margin-bottom:25px;
  font-size:20px;
}

.sidebar ul{
  list-style:none;
}

.sidebar li{
  padding:14px 16px;
  margin-bottom:12px;
  border-radius:12px;
  cursor:pointer;
  display:flex;
  align-items:center;
  gap:12px;
  background:rgba(255,255,255,.08);
  border-left:4px solid transparent;
  transition:.3s;
}

.sidebar li i{
  font-size:18px;
  color:#ffd166;
}

.sidebar li:hover{
  background:#fff;
  color:#0b3c7a;
  transform:translateX(5px);
  border-left:4px solid #ffd166;
}

.sidebar li:hover i{
  color:#0b3c7a;
}

/* ================= MAIN ================= */
.main{
  margin-left:260px;
  margin-top:70px;
  padding:20px;

  min-height:calc(100vh - 70px); /* 🔥 FIX */
  height:auto; /* 🔥 ADD */
  overflow:visible; /* 🔥 FIX */
}

/* ================= CARD ================= */
.card{
  position: relative;
  background:#fff;
  border-radius:20px;
  padding:25px;
  z-index:1;
  overflow:hidden;
  box-shadow:0 15px 40px rgba(0,0,0,.08);
}

.card::before{
  content:"";
  position:absolute;
  inset:0;
  border-radius:20px;
  padding:2px;

  background:linear-gradient(
    120deg,
    #0b3c7a,
    #1b5cb8,
    #00c853,
    #ff9800,
    #7c4dff,
    #0b3c7a
  );

  background-size:300% 300%;
  animation:borderMove 6s linear infinite;

  -webkit-mask:
    linear-gradient(#fff 0 0) content-box,
    linear-gradient(#fff 0 0);
  -webkit-mask-composite: xor;
  mask-composite: exclude;

  pointer-events:none; /* 🔥 FIX */
}

@keyframes borderMove{
  0%{background-position:0% 50%;}
  50%{background-position:100% 50%;}
  100%{background-position:0% 50%;}
}
/* ================= DASHBOARD ================= */
.dept-grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
  gap:25px;
  margin-top:25px;
}

.dept-box{
  height:160px;
  border-radius:20px;
  display:flex;
  flex-direction:column;
  align-items:center;
  justify-content:center;
  gap:12px;
  cursor:pointer;
  transition:.4s;

  background:linear-gradient(135deg,var(--clr),#1e293b);
  color:#fff;

  box-shadow:0 15px 35px rgba(0,0,0,.15);
  position:relative;
  overflow:hidden;
}

/* Glow effect */
.dept-box::after{
  content:"";
  position:absolute;
  width:200%;
  height:200%;
  background:rgba(255,255,255,0.1);
  transform:rotate(45deg);
  top:-100%;
  left:-100%;
  transition:.6s;
}

.dept-box:hover::after{
  top:0;
  left:0;
}

/* ICON */
.dept-box i{
  font-size:34px;
  color:#fff;
  background:rgba(255,255,255,0.2);
  padding:16px;
  border-radius:50%;
}

/* TEXT */
.dept-box p{
  font-size:16px;
  font-weight:600;
  color:#fff;
}

/* HOVER */
.dept-box:hover{
  transform:translateY(-10px) scale(1.05);
  box-shadow:0 25px 50px rgba(0,0,0,.3);
}
/* ================= TABLE ================= */
.table-wrap{
  width:100%;
  overflow-x:auto;
}

table{
  width:100%;
  min-width:900px;
  border-collapse:collapse;
  margin-top:20px;
}

th,td{
  padding:14px;
  text-align:left;
  vertical-align:middle;
  white-space:nowrap;
}

th{
  background:#f4f7fb;
}

tr{
  border-bottom:1px solid #e0e0e0;
}

/* ================= BUTTON ================= */
button.primary{
  background:linear-gradient(90deg,#0b3c7a,#1b5cb8);
  color:#fff;
  border:none;
  padding:10px 14px;
  border-radius:8px;
  cursor:pointer;
}

/* ACTION BUTTON FIX */
.action-btns{
  display:flex;
  gap:10px;
}

.edit-btn{
  background:#1b5cb8;
  color:#fff;
  border:none;
  padding:8px 12px;
  border-radius:8px;
}

.del-btn{
  background:#e74c3c;
  color:#fff;
  border:none;
  padding:8px 12px;
  border-radius:8px;
}

/* ================= FORM ================= */
input,select{
  width:100%;
  padding:12px;
  margin-bottom:12px;
  border:1px solid #dbeafe;
  border-radius:10px;
  background:#f8fbff;
  transition:.3s;
}

input:focus,select:focus{
  border-color:#2563eb;
  box-shadow:0 0 6px rgba(37,99,235,.3);
}

/* ================= FOOTER FIX ================= */
footer{
  margin-left:260px;
  margin-top:auto; /* 🔥 FIX */
}
</style>
</head>

<body>

<?php include 'header.php'; ?>

<div class="sidebar">
  <h2><?= $role === 'admin' ? 'ADMIN PANEL' : 'USER PANEL' ?></h2>
  <ul>
    <li onclick="dashboard()"><i class="fa-solid fa-house"></i> Dashboard</li>

    <?php if($role === 'admin'){ ?>
      <li onclick="viewUsers()"><i class="fa-solid fa-users"></i> View Users</li>
      <li onclick="createUser()"><i class="fa-solid fa-user-plus"></i> Create User</li>
    <?php } ?>

    <li onclick="confirmLogout()">
  <i class="fa-solid fa-right-from-bracket"></i> Logout
</li>
  </ul>
</div>

<div class="main" id="content"></div>

<?php include 'footer.php'; ?>

<script>
const allDepartments = ["HR","Finance","Commercial","PM","PO","ESS"];
const userRole = "<?= $role ?>";
const userDept = "<?= $department ?>";

function dashboard(){

  const deptIcons = {
    "HR": "fa-users",
    "Finance": "fa-coins",
    "Commercial": "fa-chart-line",
    "PM": "fa-diagram-project",
    "PO": "fa-file-invoice",
    "ESS": "fa-user-check"
  };

  const deptColors = {
  "HR": "#ff4d4d",
  "Finance": "#00c853",
  "Commercial": "#2979ff",
  "PM": "#ff9800",
  "PO": "#7c4dff",
  "ESS": "#00bcd4"
};

  if(userRole === "admin"){
    content.innerHTML = `
      <div class="card">
        <h2>Departments</h2>

        <div class="dept-grid">
          ${allDepartments.map(d=>`
            <div class="dept-box" style="--clr:${deptColors[d]}">
              <i class="fa-solid ${deptIcons[d]}"></i>
              <p>${d}</p>
            </div>
          `).join("")}
        </div>

      </div>
    `;
  }
  else{
    content.innerHTML = `
      <div class="card">
        <h2>Your Department</h2>

        <div class="dept-grid">
          <div class="dept-box" style="--clr:${deptColors[userDept]}">
            <i class="fa-solid ${deptIcons[userDept]}"></i>
            <p>${userDept}</p>
          </div>
        </div>

      </div>
    `;
  }
}

function viewUsers(){
  fetch("load.php")
    .then(res=>res.text())
    .then(data=>{
      content.innerHTML = `<div class="card table-wrap">${data}</div>`;
    });
}

function createUser(){
  content.innerHTML = `
    <div class="card">
      <h2>Create User</h2>
      <form method="POST" action="save_user.php">
        <input name="name" placeholder="Full Name" required>
        <input name="employee_id" placeholder="Employee ID" required>
        <input name="phone" placeholder="Phone Number" required>
        <input name="email" type="email" placeholder="Email" required>
        <input name="password" type="password" placeholder="Password" required>

        <select name="department" required>
          <option value="">Assign Department</option>
          <option value="ALL">All Departments</option>
          ${allDepartments.map(d=>`<option value="${d}">${d}</option>`).join("")}
        </select>

        <select name="role" required>
          <option value="">Assign Role</option>
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>

        <button class="primary">Create User</button>
      </form>
    </div>
  `;
}

function deleteUser(id){
  if(!confirm("Delete this user?")) return;
  fetch("delete.php?id="+id)
    .then(r=>r.text())
    .then(msg=>{
      alert(msg);
      viewUsers();
    });
}

function editUser(id){
  fetch("edit.php?id="+id)
    .then(r=>r.text())
    .then(data=>{
      content.innerHTML = `<div class="card">${data}</div>`;
    });
}

function confirmLogout(){
  if(confirm("Are you sure you want to logout?")){
    window.location.href = "logout.php";
  }
}

dashboard();
</script>

</body>
</html>