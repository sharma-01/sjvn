<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- <!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>SJVN | Home</title> -->

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

/* HEADER */
/* .header{
position:sticky;
top:0;
z-index:1000;

height:75px;
display:flex;
align-items:center;
justify-content:space-between;

padding:0 40px;

background:linear-gradient(135deg,#0b2d5c,#1e4d8f);
color:white;

box-shadow:0 4px 10px rgba(0,0,0,0.2);
} */
.header{
position:sticky;
top:0;
z-index:1000;

height:75px;
display:flex;
align-items:center;
justify-content:space-between;

padding:0 40px;

/* DARK BASE (same tone as footer) */
background:linear-gradient(135deg,#0b2d5c,#123d7a);

overflow:hidden;
color:white;
box-shadow:0 4px 10px rgba(0,0,0,0.2);
}
/* LEFT SIDE */
.header-left{
display:flex;
align-items:center;
gap:15px;
}

/* LOGO */
.logo img{
height:80px;
width:70px;
}

/* CALENDAR */
.calendar-button{
background:white;
color:#0b2d5c;
padding:6px 10px;
border-radius:6px;
display:flex;
align-items:center;
text-decoration:none;
}

.calendar-button i{
font-size:18px;
}

/* DATE TIME */
.datetime{
font-size:15px;
font-weight:500;
color:#fff;
}

/* NAV */
.nav{
display:flex;
gap:20px;
align-items:center;
}

.nav a{
color:white;
text-decoration:none;
padding:8px 14px;
border-radius:6px;
display:flex;
align-items:center;
gap:6px;
transition:0.3s;
font-size:15px;
}

.nav a:hover{
background:#f2c400;
color:black;
}

/* COLORFUL ICONS */

.nav a:nth-child(1) i{ color:#00d4ff; }   /* About */
.nav a:nth-child(2) i{ color:#00e676; }   /* Manuals */
.nav a:nth-child(3) i{ color:#ff9800; }   /* Portals */
.nav a:nth-child(4) i{ color:#ff4d6d; }   /* Contact */

/* LOGIN */
.login-btn{
background:red;
color:white;
padding:8px 16px;
border-radius:6px;
}

/* ESS */
.ess-login{
background:#f2c400;
color:black;
padding:8px 16px;
border-radius:6px;
}


/* WAVE CONTAINER */
/* WAVE CONTAINER */
.wave-container{
position:absolute;
bottom:0;
left:0;
width:100%;
height:70px;
overflow:hidden;
z-index:0;
pointer-events:none;
}

/* COMMON WAVE */
.wave{
position:absolute;
bottom:0;
left:0;
width:200%;
height:100%;
}

/* BACK WAVE (slow + slightly up) */
.wave2{
animation:waveLeft 12s linear infinite;
opacity:0.4;
bottom:0px;   /* 👈 shift up */
}

/* FRONT WAVE (fast + bottom) */
.wave1{
animation:waveRight 6s linear infinite;
opacity:0.8;
bottom:0;
}

/* LEFT → RIGHT */
@keyframes waveRight{
0%{ transform:translateX(-50%); }
100%{ transform:translateX(0%); }
}

/* RIGHT → LEFT */
@keyframes waveLeft{
0%{ transform:translateX(0%); }
100%{ transform:translateX(-50%); }
}

/* HEADER CONTENT ABOVE */
.header *:not(.wave-container){
position:relative;
z-index:2;
}
</style>

<header class="header">

<div class="header-left">

<!-- LOGO -->
<div class="logo">
<a href="index.php">
<img src="picture/logo.png" alt="SJVN Logo">
</a>
</div>

<!-- CALENDAR -->
<a href="calender.php" class="calendar-button">
<i class="fa-solid fa-calendar-days"></i>
</a>

<!-- DATE TIME -->
<div class="datetime" id="datetime"></div>

</div>

<!-- NAV -->
<nav class="nav">

<a href="about.php">
<i class="fa-solid fa-circle-info"></i> About Us
</a>

<a href="pdf.php">
<i class="fa-solid fa-book"></i> User Manuals
</a>

<a href="portal.php">
<i class="fa-solid fa-diagram-project"></i> Web Portals
</a>

<a href="contact.php">
<i class="fa-solid fa-envelope"></i> Contact
</a>

<a href="login.php" class="login-btn">
<i class="fa-solid fa-user-lock"></i> Login
</a>

<a href="https://portal.sjvn.co.in:44300/irj/portal" class="ess-login">
<i class="fa-solid fa-right-to-bracket"></i> ESS
</a>

</nav>


<div class="wave-container">

<svg class="wave wave2" viewBox="0 0 1200 120" preserveAspectRatio="none">
<path d="M0,60 C200,120 400,0 600,60 C800,120 1000,0 1200,60 L1200,120 L0,120 Z"
fill="#1e88e5"></path>
</svg>

<svg class="wave wave1" viewBox="0 0 1200 120" preserveAspectRatio="none">
<path d="M0,80 C300,0 500,120 700,60 C900,0 1100,120 1200,60 L1200,120 L0,120 Z"
fill="#42a5f5"></path>
</svg>

</div>
</header>

<!-- DATE TIME SCRIPT -->

<script>

function updateDateTime(){
const now = new Date();

const options = {
weekday: 'short',
day: '2-digit',
month: 'short',
year: 'numeric'
};

const date = now.toLocaleDateString('en-IN', options);
const time = now.toLocaleTimeString();

document.getElementById("datetime").innerHTML =
"🕒 " + date + " | " + time;
}

setInterval(updateDateTime, 1000);
updateDateTime();

</script>

