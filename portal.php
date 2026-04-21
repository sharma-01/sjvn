<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Web Portals</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

/* BODY */
body{
    margin:0;
    font-family:Poppins, sans-serif;
    background:#eef3f9;

    height:100vh;
    display:flex;
    flex-direction:column;
    overflow:hidden; /* ✅ NO SCROLL */
}

/* MAIN */
.portal-main{
    flex:1;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:10px 30px; /* ✅ NO TOP GAP */
}

/* GRID */
.portal-grid{
    width:100%;
    max-width:1200px;

    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:20px;
}

/* CARD */
.portal-card{
    padding:40px;
    border-radius:16px;

    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:10px;

    border:2px solid transparent;
    background:
        linear-gradient(#fff,#fff) padding-box,
        linear-gradient(135deg,#0b3c7a,#00aaff,#ffd700) border-box;

    box-shadow:0 4px 12px rgba(0,0,0,.06);
    transition:.25s;
}

.portal-card:hover{
    transform:translateY(-4px);
}

/* ICON */
.portal-icon{
    width:55px;
    height:55px;
    font-size:22px;
    border-radius:50%;

    display:flex;
    align-items:center;
    justify-content:center;

    box-shadow:0 4px 10px rgba(0,0,0,.1);
}

/* COLORS */
.p1{ background:#e0f2fe; color:#0284c7; }
.p2{ background:#dcfce7; color:#16a34a; }
.p3{ background:#ede9fe; color:#7c3aed; }
.p4{ background:#fee2e2; color:#dc2626; }

/* TEXT */
.portal-card h3{
    font-size:15px;
    font-weight:600;
    color:#1e293b;
    text-align:center;
    margin:5px 0;
}

/* LINK */
.portal-link{
    font-size:12px;
    color:#0b3c7a;
    text-decoration:none;
    word-break:break-all;
}

.portal-link:hover{
    text-decoration:underline;
}

/* FOOTER */
footer{
    height:50px;
    display:flex;
    align-items:center;
    justify-content:center;
}

/* RESPONSIVE */
@media(max-width:900px){
    body{
        overflow:auto; /* mobile scroll allow */
    }

    .portal-main{
        padding:80px 20px 30px;
        align-items:flex-start;
    }

    .portal-grid{
        grid-template-columns:1fr;
    }
}

</style>

</head>

<body>

<?php include 'header.php'; ?>

<div class="portal-main">

<div class="portal-grid">

<div class="portal-card">
    <div class="portal-icon p1">
        <i class="fa-solid fa-user"></i>
    </div>
    <h3>SJVN Ex-Employee Application</h3>
    <a href="https://connect.sjvn.co.in" target="_blank" class="portal-link">
        <b>https://connect.sjvn.co.in</b>
    </a>
</div>

<div class="portal-card">
    <div class="portal-icon p2">
        <i class="fa-solid fa-id-card"></i>
    </div>
    <h3>Gate Pass Application</h3>
    <a href="https://gatepass.sjvn.co.in" target="_blank" class="portal-link">
        <b>https://gatepass.sjvn.co.in</b>
    </a>
</div>

<div class="portal-card">
    <div class="portal-icon p3">
        <i class="fa-solid fa-chart-line"></i>
    </div>
    <h3>BI Dashboard</h3>
    <a href="http://10.10.237.79:8080/BOE/BI" target="_blank" class="portal-link">
        <b>http://10.10.237.79:8080/BOE/BI</b>
    </a>
</div>

<div class="portal-card">
    <div class="portal-icon p4">
        <i class="fa-solid fa-layer-group"></i>
    </div>
    <h3>Management SAC Dashboard</h3>
    <a href="https://sjvn.ap10.hcs.cloud.sap" target="_blank" class="portal-link">
       <b> https://sjvn.ap10.hcs.cloud.sap</b>
    </a>
</div>

</div>

</div>

<?php include 'footer.php'; ?>

</body>
</html>