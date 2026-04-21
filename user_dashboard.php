<?php
session_start();
include "db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
  header("Location: login.php");
  exit;
}

$department = $_SESSION['department'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
<title>User Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:"Poppins", sans-serif;
}

body{
  background:#eef2f7;
  display:flex;
  flex-direction:column;
  min-height:100vh;
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

.sidebar li.active{
  background:#fff;
  color:#0b3c7a;
  border-left:4px solid #ffd166;
}

.sidebar li.active i{
  color:#0b3c7a;
}

/* ================= MAIN ================= */
.main{
  margin-left:260px;
  margin-top:70px;
  padding:20px;

  min-height:calc(100vh - 70px);
  height:auto;
  overflow:visible;
}

/* ================= CARD ================= */
.card{
  background:#fff;
  border-radius:20px;
  padding:25px;

  height:auto;
  max-height:none;
  overflow:visible;

  box-shadow:0 15px 40px rgba(0,0,0,.08);
  border:2px solid #e0e7ff;
}

/* ================= TITLE ================= */
.title{
  font-size:22px;
  font-weight:600;
  color:#0b3c7a;
}

/* ================= GRID ================= */
.dept-grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,220px);
  gap:25px;
  margin-top:25px;
  justify-content:flex-start;
}

/* ================= COLORFUL BOX ================= */
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

.dept-box i{
  font-size:34px;
  color:#fff;
  background:rgba(255,255,255,0.2);
  padding:16px;
  border-radius:50%;
}

.dept-box p{
  font-size:16px;
  font-weight:600;
  color:#fff;
}

.dept-box:hover{
  transform:translateY(-10px) scale(1.05);
  box-shadow:0 25px 50px rgba(0,0,0,.3);
}

/* ================= INFO ================= */
.info{
  margin-top:15px;
  padding:12px;
  border-radius:10px;
  background:#f1f5ff;
  font-size:14px;
}
</style>
</head>

<body>

<?php include 'header.php'; ?>

<div class="sidebar">
  <h2>USER PANEL</h2>
  <ul>
    <li class="active" onclick="dashboard(this)">
      <i class="fa-solid fa-house"></i> Dashboard
    </li>

    <li onclick="confirmLogout()">
      <i class="fa-solid fa-right-from-bracket"></i> Logout
    </li>
  </ul>
</div>

<div class="main">
  <div id="content"></div>
</div>

<?php include 'footer.php'; ?>

<script>
const userDept = "<?= $department ?>";

/* ICONS */
const deptIcons = {
  "HR": "fa-users",
  "Finance": "fa-coins",
  "Commercial": "fa-chart-line",
  "PM": "fa-diagram-project",
  "PO": "fa-file-invoice",
  "ESS": "fa-user-check"
};

/* COLORS */
const deptColors = {
  "HR": "#ff4d4d",
  "Finance": "#00c853",
  "Commercial": "#2979ff",
  "PM": "#ff9800",
  "PO": "#7c4dff",
  "ESS": "#00bcd4"
};

/* ACTIVE MENU */
function setActive(el){
  document.querySelectorAll(".sidebar li").forEach(li=>{
    li.classList.remove("active");
  });
  el.classList.add("active");
}

/* DASHBOARD */
function dashboard(el){
  if(el) setActive(el);

  content.innerHTML = `
    <div class="card">
      <div class="title">Welcome 👋</div>

      <div class="info">
        You are assigned to <b>${userDept}</b> department.
      </div>

      <div class="dept-grid">
        <div class="dept-box" onclick="openDepartment('${userDept}')" style="--clr:${deptColors[userDept]}">
          <i class="fa-solid ${deptIcons[userDept]}"></i>
          <p>${userDept}</p>
        </div>
      </div>

    </div>
  `;
}

/* OPEN DEPARTMENT */
function openDepartment(dept){
  content.innerHTML = `
    <div class="card">
      <h2>${dept} Department</h2>

      <div class="dept-grid">

        <div class="dept-box" onclick="openDocs('${dept}','technical')" style="--clr:#2563eb">
          <i class="fa-solid fa-code"></i>
          <p>Technical Documents</p>
        </div>

        <div class="dept-box" onclick="openDocs('${dept}','functional')" style="--clr:#16a34a">
          <i class="fa-solid fa-file-lines"></i>
          <p>Functional Documents</p>
        </div>

      </div>
    </div>
  `;
}

/* LOAD DOCUMENTS */
function openDocs(dept,type){
  fetch(`documents.php?dept=${dept}&type=${type}`)
    .then(res=>res.text())
    .then(data=>{
      content.innerHTML = `<div class="card">${data}</div>`;
    });
}

/* LOGOUT CONFIRM */
function confirmLogout(){
  if(confirm("Are you sure you want to logout?")){
    window.location.href = "logout.php";
  }
}

/* AUTO LOAD */
dashboard();
</script>

</body>
</html>