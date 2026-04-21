<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>SJVN ERP Documents</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
.header{
  position:fixed !important;
  top:0;
  left:0;
  width:100%;
  z-index:9999;
}
*{margin:0;padding:0;box-sizing:border-box;}

/* ✅ FIX START */
html, body{
  height:100%;
}

body{
  display:flex;
  flex-direction:column;
  min-height:100vh;
  padding-top:80px; /* space for header */
  font-family: 'Poppins', sans-serif;
  font-weight: 400;
}
/* ✅ FIX END */

.main-wrapper{
  flex:1;
}footer{
  margin-top:auto;
}
/* GRID */
.module-container{
  padding:30px 40px;
  display:grid;
  grid-template-columns:repeat(5,1fr);
  gap:25px;
}

/* CARD */
.module-card{
  background:#fff;
  border-radius:16px;
  padding:25px 15px;
  text-align:center;
  cursor:pointer;
  position:relative;
  transition:.3s;
}

/* GRADIENT BORDER */
.module-card::before{
  content:"";
  position:absolute;
  inset:0;
  border-radius:16px;
  padding:2px;
  background:linear-gradient(135deg,#ff7a18,#32d2aa,#4facfe);
  -webkit-mask:linear-gradient(#fff 0 0) content-box,linear-gradient(#fff 0 0);
  -webkit-mask-composite:xor;
  mask-composite:exclude;
}

.module-card:hover{
  transform:translateY(-6px) scale(1.03);
}

/* ICON */
.icon-circle{
  width:65px;height:65px;margin:auto;
  border-radius:50%;
  display:flex;
  flex-direction:column;
  align-items:center;
  justify-content:center;
  color:#fff;
  margin-bottom:10px;
}
.icon-circle i{font-size:18px;}
.icon-circle span{font-size:10px;}

.c1{background:linear-gradient(135deg,#ff9a9e,#fad0c4);}
.c2{background:linear-gradient(135deg,#a18cd1,#fbc2eb);}
.c3{background:linear-gradient(135deg,#f6d365,#fda085);}
.c4{background:linear-gradient(135deg,#84fab0,#8fd3f4);}
.c5{background:linear-gradient(135deg,#fccb90,#d57eeb);}
.c6{background:linear-gradient(135deg,#30cfd0,#330867);}

.module-card p{
  font-size:14px;
  color:#003366;
}

/* TITLE */
.section-title{
  text-align:center;
  font-size:30px;
  margin:40px 0;
  color:#444;
}

/* BACK */
.back-btn{
  position:absolute;
  right:40px;
  top:100px;
  cursor:pointer;
  color:#007bff;
  font-weight:500;
}

/* SUB MODULE CENTER */
#subContainer{
  display:grid;
  grid-template-columns:repeat(auto-fit, minmax(220px, 260px));
  justify-content:center;
  gap:30px;
  padding:20px 40px 50px;
}

/* PDF VIEW */
.pdf-modal{
  position:fixed;
  top:0;
  left:0;
  width:100%;
  height:100%;
  background:#000;
  display:none;
  z-index:9999;
}

/* CLOSE BUTTON */
.close-btn{
  position:absolute;
  top:55px;
  right:15px;
  background:#ef4444;
  color:#fff;
  border:none;
  padding:6px 12px;
  font-size:14px;
  cursor:pointer;
  border-radius:4px;
  z-index:10000;
}

/* PDF */
.pdf-frame{
  width:100%;
  height:100%;
  border:none;
}

</style>
</head>

<body>

<?php include 'header.php'; ?>

<div class="main-wrapper">

<!-- MAIN MODULES -->
<div id="mainModules" class="module-container"></div>

<!-- SUB MODULES -->
<div id="subModules" style="display:none;">
  <div class="back-btn" onclick="goBack()">⬅ Back</div>
  <h2 id="moduleTitle" class="section-title"></h2>
  <div id="subContainer"></div>
</div>

</div>

<!-- PDF VIEW -->
<div id="pdfModal" class="pdf-modal">
  <button class="close-btn" onclick="closePDF()">✖ Close</button>
  <iframe id="pdfFrame" class="pdf-frame"></iframe>
</div>

<script>



const modules = [
["exemployees","User Manual for Ex-Employees","c1","pdf"],
["ess","Employee Self Service","c2","pdf"],
["finance","Finance","c3","sub"],
["hr","Human Resource","c4","sub"],
["mm","Material Management","c5","sub"],
["opm","Operation & Plant Maintenance","c6","sub"],
["rehab","Resettlement & Rehabilitation","c1","sub"],
["project","Project System","c2","sub"],
["township","Township Billing","c3","pdf"],
["flcm","File Life Cycle Management","c4","pdf"],
["clip","CLIP Portal","c5","sub"],
["billing","Commercial Billing","c6","sub"],
["sd","Sales & Distribution","c1","pdf"],
["srm","SRM","c2","sub"],
["vits","Vendor Invoice Tracking System","c3","sub"],
["legal","Litigation Management","c4","pdf"],
["mdcc","Material Dispatch Clearance","c5","pdf"],
["primavera","Primavera","c6","pdf"],
["csi","Customer Satisfaction Index","c1","pdf"],
["edms","Engineering Drawing System","c2","sub"]
];

/* ===== SUB MODULE DATA ===== */
const data = {

finance:{
title:"SAP Finance",
items:[
["finance_manual","Finance Manuals","inner"],
["tcode","List of T-codes","pdf"]
]
},

finance_manual:{
title:"Finance User Manuals",
items:[
["f1","Asset Create","pdf"],
["f2","Asset Delete","pdf"],
["f3","Asset Master","pdf"],
["f4","Asset Retirement","pdf"],
["f5","Asset Scrapping","pdf"],
["f6","Asset under Construction","pdf"],
["f7","Bank Guarantee with Approval Strategy","pdf"],
["f9","Earnest Money Deposit","pdf"],
["f10","Customer invoice parking and posting","pdf"],
["f11","CWIP to fixd Asset transfer","pdf"],
["f12","EMD release process","pdf"],
["f13","EMD without approval strategy","pdf"],
["f14","Fixed Term Deposit","pdf"],
["f15","General Ledger Master data","pdf"],
["f16","Journal Ledger Entry","pdf"],
["f17","Initial Security Receipt","pdf"],
["f18","Lease Accounting","pdf"],
["f19","Manual TDS  Entry","pdf"],
["f20","Manual TDS Nepal","pdf"],
["f21","Termination and Asset Deactivation process of RE-FX Module","pdf"],
["f22","Vendor Incove Processing","pdf"],

]
},   

hr:{
title:"HR User Manuals",
items:[
["h1","Advance or Loan utilization Application","pdf"],
["h2","Amenities for Senior Executives of SAPDC","pdf"],
["h3","Balance Score Card Application","pdf"],
["h4","Child Higher Education Loan Application and Reimbursement","pdf"],

["h5","Communication Expense in ESS Portal","pdf"],
["h6","Conveyance Reimbursement Process in ESS Portal","pdf"],
["h7","Telephone Registration,Reimbursement and Cancellation","pdf"],
["h8","Disciplnary Action Application","pdf"],
["h9","FTA PMS Application(Executives)","pdf"],
["h10","FTA PMS Application(Non-Executives)","pdf"],
["h11","Lease Process","pdf"],
["h12","Download Medical Slip in ESS Portal","pdf"],
["h13","NOC Request","pdf"],
["h14","Personal Information Process","pdf"],
["h15","Reports in HCM Payroll","pdf"],
["h16","Bulk Transfer Process","pdf"],
["h17","Manpower Contract Report","pdf"],
["h18","Briefcase and Mobile Handser Reimbursement","pdf"],
["h19","Conveyance Registration,Reimbursement and Cancellation","pdf"],
["h20","Conveyance Advance Application","pdf"],
["h21","Laptop Application(Laptop/Tablet,Battery","pdf"],
["h22","Lease Process","pdf"],
["h23","Leaves","pdf"],
["h24","Leave Encashment","pdf"],
["h25","  Medical Related Entitlement","pdf"],
["h26","Medical Application ","pdf"],
["h27","Official Duty Application","pdf"],


]
},
mm:{
title:"SAP Material Management",
items:[
["m1","Procurement and Inventory","pdf"],
["m2"," MSME Enhancement & MM Report","pdf"],
["m3","Store Related Process in CAPEX Projects ","pdf"],
]
},

opm:{
title:"Operation & Plant Maintenance User Manuals",
items:[
["o1","Annual Planned Maintenance","pdf"],
["o2","Breakdown Maintenance","pdf"],
["o3","Condition Based Maintenance","pdf"],
["o4","General Maintenance","pdf"],

["o5","Operations","pdf"],
["o6","Preventive Maintenance","pdf"],
["o7","Bank Gurantee with Approval Strategy","pdf"],
["o8","Earnest Money Deposit","pdf"],
["o9","Customer invoice parking and posting","pdf"],
["o10","CWIP to fixd Asset transfer","pdf"],
["o11","EMD release process","pdf"],
["o12","EMD without approval strategy","pdf"],
["o13","Fixed Term Deposit","pdf"],
["o14","General Ledger Master data","pdf"],
["o15","Journal Ledger Entry","pdf"],
["o16","Initial Security Receipt","pdf"],
["o17","Lease Accounting","pdf"],
["o18","Manual TDS  Entry","pdf"],
["o19","Manual TDS Nepal","pdf"],
["o20","Termination and Asset Deactivation process of RE-FX Module","pdf"],
["o21","Vendor Incove Processing","pdf"],

]
},
rehab:{
title:"Resettlement & Rehabilitation User Manuals",
items:[
["r1","R&R Data Entry","pdf"],
["r2","R&R Module-11.04.2024 ","pdf"],
]
},

project:{
title:"Project System User Manual",
items:[
["p1","Project System Manual","pdf"],
["p2","Hindrance Register ","pdf"],
]
},

clip:{
title:"CLIP User Manuals",
items:[
["c1","Contractor Registration","pdf"],
["c2","Project Site ","pdf"],
["c3","Wage ","pdf"],

]
},
billing:{
title:"Commercial Billing User Manuals",
items:[
["b1","Hydro Power Billing for NJHPS & RHPS","pdf"],
["b2","Solar Power Billing for Charanka Gujrat","pdf"],
["b3","Commercial Billing for Parasan Solar Power Plant","pdf"],
["b4","Wind Power 1 Billing Khirviri Project Maharashtra","pdf"],
["b5","Wind Power 2 Billing Sadla Gujrat","pdf"],
]
},

srm:{
title:"SRM User Manuals",
items:[
["s1","Bidder Manual","pdf"],
["s2","Purchaser Manual","pdf"],
]
},

vits:{
title:"VITMS User Manuals",
items:[
["v1","VITMS Ver 1.0","pdf"],
["v2","VITMS Ver 2.0","pdf"],
]
},

edms:{
title:"Engineering Drawing Management System User Manuals",
items:[
["e1","Admin & Sub-Admin manual","pdf"],
["e2","Consultant Manual","pdf"],
["e3","Official Manual","pdf"],
["e4","Vendor Manual","pdf"],
["e5","Upload Project sample Csv file ","pdf"],
]
}
};

/* ===== LOAD MAIN ===== */
modules.forEach(m=>{
  document.getElementById("mainModules").innerHTML += `
  <div class="module-card" onclick="handleClick('${m[0]}','${m[3]}')">
    <div class="icon-circle ${m[2]}">
      <i class="fa-solid fa-file-pdf"></i>
      <span>PDF</span>
    </div>
    <p>${m[1]}</p>
  </div>`;
});

function handleClick(key,type){

  /* PDF */
  if(type==="pdf"){
    openPDF(key);
    return;
  }

  /* SUB / INNER */
  const mod = data[key];

  document.getElementById("mainModules").style.display="none";
  document.getElementById("subModules").style.display="block";
  document.getElementById("moduleTitle").innerText = mod.title;

  let html="";

  mod.items.forEach(i=>{

    let clickType = i[2] || "pdf";

    html+=`
    <div class="module-card" onclick="handleClick('${i[0]}','${clickType}')">
      <div class="icon-circle c3">
        <i class="fa-solid fa-file-pdf"></i>
        <span>PDF</span>
      </div>
      <p>${i[1]}</p>
    </div>`;
  });

  document.getElementById("subContainer").innerHTML=html;
}

/* BACK */
function goBack(){
document.getElementById("subModules").style.display="none";
document.getElementById("mainModules").style.display="grid";
}

/* PDF MAP */

const pdfs={

/* MAIN */
exemployees:"pdf/RETIREE MANUAL",
ess:"https://portal.sjvn.co.in:44300/irj/portal",
finance_manual:"pdfs/finance_manual.pdf",
tcode:"pdf/List of Tcodes (Finance) (2)", 
township:"pdf/ISU Township",
flcm:"pdf/FLCM",
sd:"pdf/USER MANUAL VERSION 4",
legal:"pdf/TCS Tech Proposal_Odisha GRIDCO MBC (2)",
mdcc:"pdf/TCS Tech Proposal_Odisha GRIDCO MBC (2)",
primavera:"pdf/FS_TS template",
csi:"pdf/customer satisfaction index",

/* HR */
loan:"pdfs/loan.pdf",
balance:"pdfs/balance.pdf",
lease:"pdfs/lease.pdf",

/* FINANCE SUB MANUALS */
f1:"pdf/Asset create",
f2:"pdf/Asset delete",
f3:"pdf/Asset Master",
f4:"pdf/Asset Retirement",
f5:"pdf/Asset Scrapping",
f6:"pdf/Asset under Construction",
f7:"pdf/Bank Guarantee With Approval Strategy",
f9:"pdf/Cost Center Master Data",
f10:"pdf/Customer invoice parking and posting",
f11:"pdf/CWIP To Fixed Asset Transfer",
f12:"pdf/EMD Release Process",
f13:"pdf/EMD Without Approval Strategy",
f14:"pdf/FTD Manual - CC 2200",
f15:"pdf/General Ledger Master data",
f16:"pdf/JV Entry",
f17:"pdf/Initial Security Receipt.pdf",
f18:"pdf/Lease Accounting(V1)",
f19:"pdf/Manual TDS",
f20:"pdf/Nepal TDS",
f21:"pdf/Termination & Asset Deactivation Process of RE-FX Module",
f22:"pdf/Vendor Invoice Processing",


/* HR SUB MANUALS */  
h1:"pdf/Advance_Loan_Utilization_UM",
h2:"pdf/Amneities to Sr.Executives SAPDC",
h3:"pdf/BSC",
h4:"pdf/UM_child_hi_edu",
h5:"pdf/Communication Expense",
h6:"pdf/Conveyance Reimbursement",
h7:"pdf/manualTelephone",
h8:"pdf/Disciplinary Action application",
h9:"pdf/FTA PMS_Executive",
h10:"pdf/FTA PMSNonExecutive",
h11:"pdf/UM_Lease_process_06_2021",
h12:"pdf/Medical Slip",
h13:"pdf/NOC",
h14:"pdf/Personal Information",
h15:"pdf/REPORTS in HCM",
h16:"pdf/SJVN Bulk Transfer",
h17:"pdf/Manpower_Report_Manual",
h18:"pdf/manual_Briefcase_Mobile_Reimbursement",
h19:"pdf/manual_conveyance",
h20:"pdf/SJVN Blueprint HCM - Appraisal v2",
h21:"pdf/manual_laptop",
h22:"pdf/Manual_Lease_process",
h23:"pdf/SJVN ESS Leave User Manual",
h24:"pdf/manual_LeaveEncashment",
h25:"pdf/manual_medical_related",
h26:"pdf/manualMedical_Bill_Claim",
h27:"pdf/Official_Duty_manual",

/*MM */
m1:"pdf/MM",
m2:"pdf/TCS Tech Proposal_Odisha GRIDCO MBC",
m3:"pdf/store related process in capex projects",

/* pom*/
o1:"pdf/annual planned maintenance",
o2:"pdf/breakdown maintenance",
o3:"pdf/condition based maintenance",
o4:"pdf/general maintenance",
o5:"pdf/operations",
o6:"pdf/preventive maintenance",
o7:"pdf/Bank Guarantee with Approval Strategy",
o8:"pdf/Cost Center Master Data",
o9:"pdf/Customer invoice parking and posting",
o10:"pdf/CWIP To Fixed Asset Transfer",
o11:"pdf/EMD Release Process",
o12:"pdf/EMD Without Approval Strategy",
o13:"pdf/FTD Manual - CC 2200",
o14:"pdf/General Ledger Master data",
o15:"pdf/JV Entry",
o16:"",
o17:"pdf/Lease Accounting(V1)",
o18:"pdf/Manual TDS",
o19:"pdf/Nepal TDS",
o20:"pdf/Termination & Asset Deactivation Process of RE-FX Module",
o21:"pdf/Vendor Invoice Processing",

/* rehab*/
r1:"pdf/R&R Data Entry",
r2:"pdf/TCS Tech Proposal_Odisha GRIDCO MBC",

/* project*/
p1:"pdf/UserManual_PS",
p2:"pdf/SJVNUserManual_HindranceRegister",

/* clip*/
c1:"pdf/ContractorRegistration",
c2:"pdf/ProjectSite",
c3:"pdf/Wage",



/* commerical billing */
b1:"pdf/hydro power",
b2:"pdf/solar power billing",
b3:"pdf/BBP Version 4 (2)",
b4:"pdf/BBP Version 4 (3)",
b5:"pdf/BBP Version 4 (4)",

// srm 
s1:"pdf/bidder manual",
s2:"pdf/purchasermanual",

// vits 
v1:"pdf/VITMS Version 1.0",
v2:"pdf/VITMS Version 2.0",

// edms
e1:"pdf/Admin_sub_adminmanua",
e2:"pdf/Consultantmanual",
e3:"pdf/Usermanual_officia",
e4:"pdf/usermanual_vendor",

e5:"pdf/projsampleCSVfile.csv",



};
/* OPEN PDF */
function openPDF(file){
document.getElementById("pdfFrame").src = pdfs[file];
document.getElementById("pdfModal").style.display="block";
}

/* CLOSE PDF */
function closePDF(){
document.getElementById("pdfModal").style.display="none";
document.getElementById("pdfFrame").src="";
}

</script>
<!-- ===== FOOTER ===== -->
<?php include 'footer.php'; ?>
</body>
</html>