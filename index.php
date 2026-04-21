<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>SJVN | Home</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#000;
}

/* HERO */

.hero-section{
height:100vh;
width:100%;
position:relative;
overflow:hidden;
}

/* SLIDES */

.slide{
position:absolute;
width:100%;
height:100%;
background-size:cover;
background-position:center;
opacity:0;
transition:opacity 1s ease-in-out, transform 6s ease-in-out;
transform:scale(1.1);
}

.slide.active{
opacity:1;
transform:scale(1);
}

/* OVERLAY */

.hero-overlay{
position:absolute;
inset:0;
background:rgba(0,0,0,0.5);
z-index:1;
}

/* CONTENT */

.hero-content{
position:absolute;
top:50%;
left:50%;
transform:translate(-50%,-50%);
z-index:2;
text-align:center;
color:white;
max-width:800px;
padding:20px;
}

.hero-content h1{
font-size:42px;
margin-bottom:15px;
}

.hero-content p{
font-size:18px;
margin-bottom:25px;
}

/* ICONS */

.hero-icons{
display:flex;
justify-content:center;
gap:30px;
}

.hero-icons a{
background:#f2c400;
width:60px;
height:60px;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
color:black;
font-size:22px;
text-decoration:none;
transition:0.3s;
}

.hero-icons a:hover{
transform:scale(1.1);
background:white;
}

/* DOTS */

.dots{
position:absolute;
bottom:25px;
width:100%;
display:flex;
justify-content:center;
gap:10px;
z-index:3;
}

.dot{
width:12px;
height:12px;
background:white;
border-radius:50%;
opacity:0.5;
cursor:pointer;
}

.dot.active{
opacity:1;
background:#f2c400;
}

/* NOTIFICATION BAR */

.notification-bar{
background:#1b3c73;
color:white;
padding:8px 16px;
height:45px;
display:flex;
align-items:center;
font-size:14px;
box-shadow:0 2px 6px rgba(0,0,0,0.2);
}

.notice-title{
background:#ffcc00;
color:black;
padding:5px 12px;
font-size:14px;
font-weight:600;
margin-right:12px;
border-radius:4px;
display:flex;
align-items:center;
gap:6px;
}

.notification-bar marquee{
line-height:45px;
flex:1;
}

/* ===== CHATBOT BUTTON ===== */

/* CHATBOT BUTTON FINAL */

.chatbot-btn{
position:fixed;
right:25px;
bottom:25px;
z-index:9999;

display:flex;
align-items:center;
gap:10px;

background:#f2c400;
color:black;

padding:12px 18px;
border-radius:30px;

font-size:14px;
font-weight:600;

text-decoration:none;

box-shadow:0 8px 20px rgba(0,0,0,0.3);
transition:0.3s;
}

/* ICON */
.chatbot-btn i{
font-size:18px;
}

/* HOVER */
.chatbot-btn:hover{
transform:scale(1.05);
background:white;
color:#0b2d5c;
}
/* RESPONSIVE */

@media(max-width:768px){
.hero-content h1{ font-size:28px; }
.hero-content p{ font-size:16px; }
}


</style>

</head>

<body>

<?php include 'header.php'; ?>

<!-- HERO -->

<section class="hero-section">

<div class="slide active" style="background-image:url('picture/erp.webp')"></div>
<!-- <div class="slide" style="background-image:url('picture/erp3.jfif')"></div>
<div class="slide" style="background-image:url('picture/erp4.jfif')"></div>
<div class="slide" style="background-image:url('picture/erp1.jfif')"></div> -->

<div class="hero-overlay"></div>

<div class="hero-content">

<h1>Powering SJVN Through Integrated ERP Solutions</h1>

<p>
A centralized enterprise resource planning platform enabling efficient management across departments.
</p>

<div class="hero-icons">
<!-- <a href="tel:+911772666001"><i class="fa-solid fa-phone"></i></a>
<a href="mailto:info@sjvn.nic.in"><i class="fa-solid fa-envelope"></i></a> -->
<a href="https://www.google.com/maps?q=SJVN+Shimla" target="_blank"><i class="fa-solid fa-location-dot"></i></a>
</div>

</div>

<!-- DOTS -->
<!-- <div class="dots">
<div class="dot active"></div>
<div class="dot"></div>
<div class="dot"></div>
<div class="dot"></div>
</div> -->

</section>

<!-- NOTICE -->

<div class="notification-bar">

<div class="notice-title">
<i class="fa-solid fa-bullhorn"></i> Notice
</div>

<marquee>
SJVN upcoming projects and announcements – Stay Updated with ERP updates and departmental news.
</marquee>

</div>

<!-- CHATBOT BUTTON -->
<a href="http://172.16.34.41:5000/" class="chatbot-btn" target="_blank" title="Chat with us">
<i class="fa-solid fa-robot"></i>
CHATBOT
</a>

<!-- FOOTER -->

<?php include 'footer.php'; ?>

<!-- SCRIPT -->

<script>

let slides = document.querySelectorAll(".slide");
let dots = document.querySelectorAll(".dot");

let index = 0;

function showSlide(i){
slides.forEach(s => s.classList.remove("active"));
dots.forEach(d => d.classList.remove("active"));

slides[i].classList.add("active");
dots[i].classList.add("active");
}

function nextSlide(){
index = (index + 1) % slides.length;
showSlide(index);
}

setInterval(nextSlide, 4000);

dots.forEach((dot,i)=>{
dot.addEventListener("click", ()=>{
index = i;
showSlide(index);
});
});

</script>

</body>
</html>