

<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About Us</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:#eef2f7;
}

/* ===== LAYOUT ===== */
.about-wrapper{
    display:flex;
    min-height:100vh;
}

/* ===== SIDEBAR ===== */
.sidebar{
    width:290px;
    background:linear-gradient(180deg,#0b3c7a,#062c57);
    color:#fff;
    padding:25px 20px;
    position:fixed;
    top:70px;
    bottom:0;
    left:0;
    border-right:4px solid #ffd700;
    overflow-y:auto;
}

/* TITLE */
.sidebar h2{
    font-size:22px;
    margin-bottom:25px;
    padding-bottom:12px;
    border-bottom:2px solid rgba(255,255,255,.3);
    display:flex;
    align-items:center;
    gap:10px;
}

/* MENU */
.sidebar ul{
    list-style:none;
}

/* MENU ITEM */
.sidebar ul li{
    display:flex;
    align-items:center;
    gap:12px;
    padding:14px;
    margin-bottom:14px;
    border-radius:14px;
    border:2px solid rgba(255,255,255,.25);
    background:rgba(255,255,255,.08);
    cursor:pointer;
    transition:.3s;

    white-space:normal;
    line-height:1.4;
    font-size:15px;
    font-weight:500;
}

/* ICON */
.sidebar ul li i{
    min-width:36px;
    height:36px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    background:#fff;
    font-size:15px;
}

/* ICON COLORS */
.icon-blue{color:#0b3c7a;}
.icon-purple{color:#7b3fe4;}
.icon-orange{color:#ff7a18;}
.icon-green{color:#16a34a;}
.icon-gold{color:#d4a017;}

/* HOVER */
.sidebar ul li:hover{
    background:#fff;
    color:#0b3c7a;
    transform:translateX(6px);
    border-left:6px solid #ffd700;
    box-shadow:0 6px 15px rgba(0,0,0,.2);
}

/* ACTIVE */
.sidebar ul li.active{
    background:#fff;
    color:#0b3c7a;
    font-weight:600;
    border-left:6px solid #ffd700;
}

/* ===== CONTENT ===== */
.content{
    margin-left:290px;
    padding:30px;
    width:calc(100% - 290px);
}

.section{
    display:none;
}
.section.active{
    display:block;
}

/* ===== MEDIA BOX (OVERVIEW FIXED) ===== */
.media-box{
    display:flex;
    align-items:center;
    gap:35px;
    background:#fff;
    padding:30px;
    border-radius:16px;

    border:3px solid #0b3c7a;
    box-shadow:0 10px 25px rgba(0,0,0,.08);

    margin-bottom:30px;
}

/* IMAGE */
.media-img{
    flex:0 0 320px;
}

.media-img img{
    width:100%;
    height:220px;
    object-fit:cover;
    border-radius:14px;

    border:4px solid #ffd700;
    padding:4px;

    box-shadow:0 6px 15px rgba(0,0,0,0.15);
}

/* TEXT */
.media-content i{
    font-size:34px;
    color:#0b3c7a;
}

.media-content h2{
    margin:12px 0 10px;
    font-size:24px;
    color:#0b3c7a;
}

.media-content p{
    line-height:1.8;
    color:#444;
    margin-bottom:12px;
    text-align:justify;
}

/* ===== ERP CARDS ===== */
.erp-cards{
    margin-top:30px;
}

.erp-card{
    display:flex;
    gap:30px;
    align-items:center;
    background:#fff;
    padding:25px;
    border-radius:16px;
    border:2px solid #d0d9e8;
    margin-bottom:25px;
    box-shadow:0 8px 18px rgba(0,0,0,.08);
    transition:.3s;
}

.erp-card:hover{
    transform:translateY(-5px);
}

.erp-card.reverse{
    flex-direction:row-reverse;
}

.erp-card img{
    width:250px;
    height:170px;
    object-fit:cover;
    border-radius:10px;
    border:3px solid #0b3c7a;
}

.erp-card-content i{
    font-size:26px;
    color:#0b3c7a;
    background:#eef4ff;
    padding:10px;
    border-radius:50%;
    margin-bottom:10px;
}

.erp-card-content h3{
    margin-bottom:10px;
    color:#0b3c7a;
}

.erp-card-content p{
    color:#555;
    line-height:1.7;
}

/* ===== BPA GRID ===== */
.bpa-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:25px;
    margin-top:30px;
}

.bpa-card{
    background:#fff;
    border-left:6px solid #0b3c7a;
    border-radius:16px;
    padding:25px;
    text-align:center;
    cursor:pointer;
    transition:.35s;
    box-shadow:0 6px 16px rgba(0,0,0,.08);
}

.bpa-card i{
    font-size:36px;
    color:#0b3c7a;
    margin-bottom:12px;
}

.bpa-card h3{
    font-size:16px;
}

.bpa-card:hover{
    background:#0b3c7a;
    color:#fff;
    transform:translateY(-6px);
}

.bpa-card:hover i{
    color:#ffd700;
}

/* ===== RESPONSIVE ===== */
@media(max-width:900px){

    .sidebar{
        position:relative;
        width:100%;
        top:0;
    }

    .content{
        margin-left:0;
        width:100%;
    }

    .media-box{
        flex-direction:column;
        text-align:center;
    }

    .media-img{
        flex:100%;
    }

    .media-img img{
        height:200px;
    }

    .erp-card{
        flex-direction:column;
    }
}
</style>
</head>

<body>

<?php include 'header.php'; ?>

<div class="about-wrapper">

<!-- SIDEBAR -->

<aside class="sidebar">

<h2>
<i class="fa-solid fa-building"></i>
About Company
</h2>

<ul>

<li class="active" onclick="showSection('overview',this)">
<i class="fa-solid fa-city icon-blue"></i>
Company Overview
</li>

<li onclick="showSection('erp',this)">
<i class="fa-solid fa-diagram-project icon-purple"></i>
About ERP
</li>

<li onclick="showSection('bpa',this)">
<i class="fa-solid fa-gears icon-orange"></i>
Business Process Automation
</li>

<li onclick="showSection('team',this)">
<i class="fa-solid fa-users icon-green"></i>
Our Team
</li>

<li onclick="showSection('awards',this)">
<i class="fa-solid fa-award icon-gold"></i>
Awards
</li>

</ul>

</aside>
<!-- CONTENT -->
<div class="content">

<!-- OVERVIEW -->
<div id="overview" class="section active">
  <div class="media-box">
    <div class="media-img">
      <img src="picture/sjvn.jfif">
    </div>
    <div class="media-content">
      <i class="fa-solid fa-building"></i>
      <h2>Company Overview</h2>
      <p><b>SJVN Limited, a Navratna CPSE under administrative control of Ministry of Power, Govt. of India, was incorporated on May 24, 1988, as a joint venture of the Government of India (GOI) and the Government of Himachal Pradesh (GOHP). SJVN is now a listed Company having shareholders pattern of 55.00% with Govt. of India, 26.85% with Govt. of Himachal Pradesh and rest of 18.15% with Public.</b></p>
        <p><b> The present paid up capital and authorized capital of SJVN is Rs. 3,929.80 Crore and Rs. 7,000 Crore respectively. The Net Worth as on 31.03.2025 is Rs.14282.10 Crore.</b></p>
    
    </div>
  </div>
</div>

<!-- ERP -->
<div id="erp" class="section">

  <div class="media-box">
    <div class="media-img">
      <img src="picture/images.jfif">
    </div>
    <div class="media-content">
      <i class="fa-solid fa-diagram-project"></i>
      <h3>ERP System</h3>
      <p><b>At SJVN, the ERP system acts as the backbone of digital operations by bringing people, processes, and data onto a unified platform. It enables smooth coordination between departments such as Finance, HR, Procurement, Projects, and Operations, ensuring that information flows seamlessly across the organization.</b></p>

<p><b>By providing real-time insights and automated workflows, ERP at SJVN helps management make informed decisions, improves operational efficiency, and strengthens transparency. The system reduces manual dependency, enhances data reliability, and supports a culture of accountability and performance excellence.</b></p>
    </div>
  </div>

  <div class="erp-cards">

    <div class="erp-card reverse">
      <img src="picture/decision.jfif">
      <div class="erp-card-content">
        <i class="fa-solid fa-chart-line"></i>
        <h3>Effective & Faster Decision Making</h3>
        <p><b>• Real-Time Data Availability:</b> ERP provides up-to-date information from all departments on a single platform.</p>
        <p><b>• Centralized Information System: </b>All business data is consolidated, eliminating delays caused by manual reports.</p>
        <p><b>• Improved Data Accuracy:</b> Automated processes reduce human errors and ensure reliable information.</p>
      </div>
    </div>

    <div class="erp-card">
      <img src="">
      <div class="erp-card-content">
        <i class="fa-solid fa-stopwatch"></i>
        <h3>Reduction in Work Life Cycle</h3>
        <p><b>• Process Automation:</b> ERP automates routine and repetitive tasks, reducing manual effort and processing time.</p>
        <p><b>• Standardized Workflows: </b>Predefined workflows ensure faster execution of activities with fewer delays.</p>
        <p><b>• Elimination of Redundancy:</b> Duplicate data entry and repeated tasks are minimized through a single system.</b></p>
      </div>
    </div>
<!-- <div class="erp-cards"> -->

    <div class="erp-card reverse">
      <img src="picture/trans.jfif">
      <div class="erp-card-content">
        <i class="fa-solid fa-eye"></i>
        <h3>Transparency and Accountability</h3>
        <p><b>• Single Source of Truth:</b> ERP maintains centralized data, ensuring consistent and transparent information across departments.</p>
        <p><b>• Real-Time Visibility: </b>All transactions and processes can be viewed and tracked in real time.</p>
        <p><b>• Accurate & Standard Reports:</b>System-generated reports enhance clarity and reduce manual manipulation.</p>
      </div>
    </div>
    <div class="erp-card">
      <img src="picture/moral.jfif">
      <div class="erp-card-content">
        <i class="fa-solid fa-users-gear"></i>
        <h3>Improved Employee Moral,Collaboration & Productivity</h3>
        <p><b>• User-Friendly System:</b> Easy and intuitive ERP interface reduces work stress and improves employee confidence.</p>
        <p><b>• Reduced Manual Work:</b> Automation of repetitive tasks allows employees to focus on meaningful and value-added work.</p>
        <p><b>• Improved Job Satisfaction:</b> Faster processes, fewer errors, and smoother workflows enhance employee confidence and overall morale.</p>
      </div>
    </div>
    <!-- <div class="erp-cards"> -->
      

    <div class="erp-card reverse">
      <img src="picture/prototype.jfif">
      <div class="erp-card-content">
        <i class="fa-solid fa-diagram-project"></i>
        <h3>Better Business Prototype interface & Collaboration</h3>
        <p><b>• User-Friendly Interface:</b> ERP provides a simple, intuitive, and well-structured interface, making business processes easy to understand and operate.</p>
        <p><b>• Standardized Business Processes: </b>Clearly defined and uniform interfaces ensure consistency in workflows across all departments.</p>
        <p><b>• Real-Time Collaboration:</b>Employees and departments can access and share information instantly, enabling faster coordination and execution.</p>
      </div>
    </div>
    <div class="erp-card">
      <img src="picture/retiree.jfif">
      <div class="erp-card-content">
        <i class="fa-solid fa-hand-holding-heart"></i>
        <h3>serving the retirees (ex-employees) </h3>
        <p><b>• Centralized Pension Management</b> ERP provides a single platform to manage pension, gratuity, and other post-retirement benefits efficiently.</p>
        <p><b>• Easy Access to Personal Records:</b> Retirees can digitally view service history, pension details, payment statements, and related documents.</p>
        <p><b>• Transparency in Payments:</b> Clear visibility of calculations, deductions, and payment status builds trust among retirees.</p>
      </div>
    </div>
    <!-- <div class="erp-cards"> -->

    <div class="erp-card reverse">
      <img src="picture/automation.jfif">
      <div class="erp-card-content">
        <i class="fa-solid fa-gears"></i>
        <h3>Benefits of Office Automation</h3>
        <p><b>• Reduced Manual Work:</b> Automation minimizes repetitive and time-consuming tasks, reducing manual effort and errors.</p>
        <p><b>• Faster Process Execution: </b>Automated workflows speed up daily office operations and approvals.</p>
        <p><b>• Standardized Procedures:</b>Uniform digital workflows maintain consistency across all departments.</p>
      </div>
    </div>
    <div class="erp-card">
      <img src="picture/governance.png">
      <div class="erp-card-content">
        <i class="fa-solid fa-landmark"></i>
        <h3>Contribution to e-Governance & Digital India </h3>
        <p><b>• Digital Governance Enablement:</b> ERP digitizes administrative and operational processes, supporting transparent and efficient e-Governance.</p>
        <p><b>• Paperless Operations:</b> Automated workflows reduce dependency on physical documents and promote a paperless office environment.</p>
        <p><b>• Improved Service Delivery:</b> Digital processes enable faster, accurate, and citizen-centric service delivery.</p>
      </div>
    </div>
  </div>
</div>

<!-- BPA -->
<div id="bpa" class="section">
  <div class="media-box">
    <div class="media-content">
      <i class="fa-solid fa-gears"></i>
      <h2>Business Process Automation Initiative</h2>
      <p><b>Automation for faster, transparent and paperless processes.</b></p>
    </div>
  </div>

  <div class="bpa-grid">
    
    <div class="bpa-card" onclick="openBPA('hr')"><i class="fa-solid fa-user-tie"></i><h3>HR</h3></div>
    <div class="bpa-card" onclick="openBPA('finance')"><i class="fa-solid fa-coins"></i><h3>Finance</h3></div>
    <div class="bpa-card" onclick="openBPA('ess')"><i class="fa-solid fa-id-card"></i><h3>ESS</h3></div>
    <div class="bpa-card" onclick="openBPA('quality')"><i class="fa-solid fa-check-circle"></i><h3>Quality</h3></div>
    <div class="bpa-card" onclick="openBPA('pm')"><i class="fa-solid fa-diagram-project"></i><h3>PM / PO</h3></div>
    <div class="bpa-card" onclick="openBPA('eoffice')"><i class="fa-solid fa-file-lines"></i><h3>E-Office</h3></div>
    <div class="bpa-card" onclick="openBPA('townshipBilling')"><i class="fa-solid fa-building-user"></i><h3>Township Billing</h3></div>
<div class="bpa-card" onclick="openBPA('commercial')"><i class="fa-solid fa-briefcase"></i><h3>Commercial billing</h3></div>
<div class="bpa-card" onclick="openBPA('vendor')"><i class="fa-solid fa-handshake"></i><h3>E-Vendor Portal</h3></div>
<div class="bpa-card" onclick="openBPA('material')"><i class="fa-solid fa-boxes-stacked bpa-icon"></i> <h3>Material Management</h3></div>

<div class="bpa-card" onclick="openBPA('tenderting')"><i class="fa-solid fa-file-contract bpa-icon"></i><h3>E-tendering</h3></div>

<div class="bpa-card" onclick="openBPA('wlcp')"> <i class="fa-solid fa-sitemap bpa-icon"></i><h3>Work life cycle Procurement</h3></div>

<div class="bpa-card" onclick="openBPA('md')"><i class="fa-solid fa-chart-line bpa-icon"></i><h3>Management Dashboard</h3></div>

<div class="bpa-card" onclick="openBPA('psm')"><i class="fa-solid fa-diagram-project bpa-icon"></i><h3>Project System / Monitoring</h3></div>

<div class="bpa-card" onclick="openBPA('flm')"><i class="fa-solid fa-file-lines bpa-icon"></i><h3>Paperless Working through FLM</h3></div>
</div>

  <div id="bpa-detail" class="bpa-detail"></div>
</div>
<!-- TEAM -->
<div id="team" class="section">
  <div class="media-box">
    <div class="media-img"> 
      <img src="picture/download (5).jpg">
    </div>
    <div class="media-content">
      <i class="fa-solid fa-users"></i>
      <h2>Our Team</h2>
      <p><b>SJVN’s team comprises skilled professionals driving innovation, efficiency and excellence.</b></p>
    </div>
  </div>
</div>


<!-- AWARDS -->
<div id="awards" class="section">
  <div class="media-box">
    <div class="media-img">
      <img src="picture/download (10).jpg">
    </div>
    <div class="media-content">
      <i class="fa-solid fa-award"></i>
      <h2>Awards & Events</h2>
      <p><b>SJVN has received multiple national and international awards for excellence and governance.</b></p>
    </div>
  </div>
</div>

</div>
</div>

<script>
function showSection(id, el){
  document.querySelectorAll('.section').forEach(sec => sec.classList.remove('active'));
  document.getElementById(id).classList.add('active');

  document.querySelectorAll('.sidebar ul li').forEach(li => li.classList.remove('active'));
  el.classList.add('active');
}

</script>

<!-- ===== FOOTER ===== -->
<?php include 'footer.php'; ?>
<script src="script.js"></script> 

</body>
</html>  