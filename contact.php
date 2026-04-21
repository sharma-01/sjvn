<?php 
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>SJVN | Contact Us</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

/* ===== MASTER LAYOUT ===== */

html, body{
height:100%;
margin:0;
font-family:'Poppins',sans-serif;
background:#f4f7fb;
}

body{
display:flex;
flex-direction:column;
height:100vh;
overflow:hidden;
}

header{
flex-shrink:0;
}

footer{
flex-shrink:0;
}


/* ===== PAGE WRAPPER ===== */

.page-wrapper{
flex:1;
display:flex;
justify-content:center;
align-items:flex-start;
padding-top:10px;
padding-bottom:45px;
}


/* ===== CONTACT SECTION ===== */

.contact-section{
max-width:1200px;
width:100%;
padding:0 20px;
}


/* ===== TITLE ===== */

.contact-title{
text-align:center;
margin-bottom:14px;
}

.contact-title h2{
font-size:30px;
color:#0b3c7a;
margin:0;
font-weight:700;
}

.contact-title p{
font-size:13px;
color:#555;
margin-top:4px;
}


/* ===== GRID ===== */

.contact-wrapper{
display:grid;
grid-template-columns:1fr 1fr;
gap:24px;
height:260px;
}


/* ===== LEFT BOX ===== */

.contact-info{
background:#fff;
border-radius:18px;
padding:16px;
border:3px solid #0b3c7a;
box-shadow:0 10px 20px rgba(0,0,0,.10);

display:flex;
flex-direction:column;
justify-content:center;
}


/* ===== INFO BLOCK ===== */

.info-block{
display:flex;
gap:12px;
padding:12px;
margin-bottom:10px;

border-radius:10px;
background:#fff;
border:2px solid #dbe4f3;
}

.info-block:last-child{
margin-bottom:0;
}


/* ===== ICON ===== */

.info-icon{
width:40px;
height:40px;
border-radius:8px;

display:flex;
align-items:center;
justify-content:center;

font-size:16px;
color:#fff;

flex-shrink:0;
}

.icon-phone{
background:#1abc9c;
}

.icon-mail{
background:#3498db;
}

.icon-location{
background:#9b59b6;
}


/* ===== TEXT ===== */

.info-text h4{
margin:0;
font-size:14px;
color:#0b3c7a;
font-weight:600;
}

.info-text a,
.info-text p{
display:block;
margin-top:3px;
font-size:12px;
color:#333;
text-decoration:none;
}


/* ===== MAP ===== */

.contact-map{
background:#fff;
border-radius:18px;
border:3px solid #f2b705;
box-shadow:0 10px 20px rgba(0,0,0,.10);
overflow:hidden;

display:flex;
}

.contact-map iframe{
width:100%;
height:100%;
border:none;
flex:1;
}


/* ===== MOBILE ===== */

@media(max-width:900px){

body{
overflow:auto;
}

.contact-wrapper{
grid-template-columns:1fr;
height:auto;
}

.contact-map iframe{
height:320px;
}

}

</style>

</head>

<body>


<?php include 'header.php'; ?>


<div class="page-wrapper">

<section class="contact-section">


<div class="contact-title">

<h2>Contact Us</h2>

<p>
<b>SJVN Limited – ERP & IT Applications Division</b>
</p>

</div>



<div class="contact-wrapper">

<!-- LEFT SIDE -->

<div class="contact-info">


<div class="info-block">

<div class="info-icon icon-phone">
<i class="fa-solid fa-phone"></i>
</div>

<div class="info-text">

<h4>Phone Numbers</h4>

<a href="tel:+911772660002">+91 177-2660002</a>

<a href="tel:+911772660003">+91 177-2660003</a>

<a href="tel:+911772660004">+91 177-2660004</a>

</div>

</div>



<div class="info-block">

<div class="info-icon icon-mail">
<i class="fa-solid fa-envelope"></i>
</div>

<div class="info-text">

<h4>Email IDs</h4>

<a href="mailto:cs.sjvn@sjvn.nic.in">
cs.sjvn@sjvn.nic.in
</a>

<a href="mailto:info@sjvn.nic.in">
info@sjvn.nic.in
</a>

</div>

</div>



<div class="info-block">

<div class="info-icon icon-location">
<i class="fa-solid fa-location-dot"></i>
</div>

<div class="info-text">

<h4>Office Location</h4>

<p>Corporate Headquarters Shakti Sadan, Shanan</p>

<p>Shimla, Himachal Pradesh 171006</p>

</div>

</div>

</div>



<!-- RIGHT MAP -->

<div class="contact-map">

<iframe 
src="https://www.google.com/maps?q=SJVN%20Limited%20Shimla&output=embed"
loading="lazy">
</iframe>

</div>


</div>

</section>

</div>


<?php include 'footer.php'; ?>


<script src="script.js"></script>


</body>
</html>