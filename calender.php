
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SJVN Holiday Calendar 2026</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

/* ===== RESET ===== */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

/* ===== BODY ===== */
body{
    background:linear-gradient(135deg,#eef5ff,#f8fbff);
    overflow-x:hidden;
}

/* ===== WRAPPER (BALANCED WIDTH) ===== */
.main-wrapper{
    max-width:1400px;
    margin:auto;
    padding:25px;
}

/* ===== TITLE ===== */
.page-title{
    text-align:center;
    margin-bottom:20px;
}

.page-title h1{
    font-size:26px;
    color:#0a2f63;
}

/* ===== LEGEND ===== */
.legend{
    display:flex;
    justify-content:center;
    gap:25px;
    margin-bottom:20px;
}

.box{
    width:14px;
    height:14px;
    border-radius:3px;
}

.holiday-box{ background:#8b0000; }
.sun-box{ background:#ff3b3b; }

/* ===== GRID ===== */
.calendar{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
}

/* ===== MONTH CARD ===== */
.month{
    background:#fff;
    border-radius:12px;
    padding:14px;
    border:1px solid #e0e6f0;
    border-top:4px solid #1e4db7;
    box-shadow:0 4px 10px rgba(0,0,0,0.05);
    transition:0.25s;
    overflow:visible;
}

.month:hover{
    transform:translateY(-4px);
    border-top:4px solid #ff9800;
}

/* ===== COLOR VARIATION ===== */
.month:nth-child(1){ border-top-color:#ff6b6b; }
.month:nth-child(2){ border-top-color:#4dabf7; }
.month:nth-child(3){ border-top-color:#51cf66; }
.month:nth-child(4){ border-top-color:#f59f00; }
.month:nth-child(5){ border-top-color:#845ef7; }
.month:nth-child(6){ border-top-color:#20c997; }
.month:nth-child(7){ border-top-color:#fa5252; }
.month:nth-child(8){ border-top-color:#228be6; }
.month:nth-child(9){ border-top-color:#40c057; }
.month:nth-child(10){ border-top-color:#fd7e14; }
.month:nth-child(11){ border-top-color:#7950f2; }
.month:nth-child(12){ border-top-color:#12b886; }

/* ===== MONTH TITLE ===== */
.month h2{
    text-align:center;
    font-size:16px;
    color:#1e4db7;
    margin-bottom:8px;
}

/* ===== WEEK ===== */
.weekdays, .days{
    display:grid;
    grid-template-columns:repeat(7,1fr);
    text-align:center;
}

.weekdays div{
    font-size:12px;
    font-weight:600;
    color:#666;
}

/* ===== DAYS ===== */
.days{
    overflow:visible;
}

.days div{
    padding:8px;
    margin:2px;
    border-radius:6px;
    font-size:13px;
    background:#e9eef7;
    cursor:pointer;
    position:relative;
    transition:0.2s;
}

/* NORMAL HOVER */
.days div:hover{
    background:#bcd6ff;
    transform:scale(1.06);
}

/* ===== SUNDAY ===== */
.sun{
    color:#ff3b3b;
    font-weight:bold;
}

/* ===== HOLIDAY ===== */
.days div.holiday{
    background:#8b0000 !important;
    color:#fff !important;
    font-weight:700;
    border:1px solid #700000;
}

/* HOLIDAY HOVER */
.days div.holiday:hover{
    background:#660000 !important;
    transform:scale(1.08);
}

/* ===== TOOLTIP ===== */
.tooltip{
    visibility:hidden;
    opacity:0;
    position:absolute;
    bottom:130%;
    left:50%;
    transform:translateX(-50%);
    background:#0a2f63;
    color:#fff;
    padding:6px 10px;
    border-radius:6px;
    font-size:12px;
    white-space:nowrap;
    z-index:9999;
    transition:0.3s;
}

.days div:hover .tooltip{
    visibility:visible;
    opacity:1;
}

/* 🔥 EDGE FIX */
.month:nth-child(4n) .tooltip{
    left:auto;
    right:0;
    transform:none;
}

.month:nth-child(4n-1) .tooltip{
    left:70%;
    transform:translateX(-70%);
}

/* ===== RESPONSIVE ===== */
@media(max-width:1000px){
    .calendar{
        grid-template-columns:repeat(2,1fr);
    }
}

@media(max-width:600px){
    .calendar{
        grid-template-columns:repeat(1,1fr);
    }

    .page-title h1{
        font-size:20px;
    }
}

</style>
</head>

<body>

<?php include 'header.php'; ?>

<div class="main-wrapper">

<div class="page-title">
    <h1><i class="fa-solid fa-calendar-days"></i> SJVN Holiday Calendar 2026</h1>
</div>

<div class="legend">
    <span><div class="box holiday-box"></div> Holiday</span>
    <span><div class="box sun-box"></div> Sunday</span>
</div>

<div class="calendar" id="calendar"></div>

</div>

<script>

const year = 2026;

const holidays = {
    "2026-01-26":"Republic Day ",
    "2026-03-04":"Holi 🎨",
    "2026-05-01":"Buddha Purnima 🪷",
    "2026-05-27":"Bakrid 🐐",
    "2026-08-15":"Independence Day ",
    "2026-10-02":"Gandhi Jayanti 🕊️",
    "2026-10-20":"Dussehra 🏹",
    "2026-11-24":"Guru Nanak Jayanti 🙏",
    "2026-12-25":"Christmas 🎄"
};

const months = [
"January","February","March","April","May","June",
"July","August","September","October","November","December"
];

const calendar = document.getElementById("calendar");

months.forEach((month, mIndex)=>{

    const firstDay = new Date(year, mIndex, 1).getDay();
    const daysInMonth = new Date(year, mIndex+1, 0).getDate();

    let monthDiv = document.createElement("div");
    monthDiv.className = "month";

    let title = document.createElement("h2");
    title.innerText = month + " " + year;
    monthDiv.appendChild(title);

    let weekdays = document.createElement("div");
    weekdays.className="weekdays";

    ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"].forEach(d=>{
        let div=document.createElement("div");
        div.innerText=d;
        weekdays.appendChild(div);
    });

    monthDiv.appendChild(weekdays);

    let daysDiv = document.createElement("div");
    daysDiv.className="days";

    for(let i=0;i<firstDay;i++){
        daysDiv.appendChild(document.createElement("div"));
    }

    for(let d=1; d<=daysInMonth; d++){

        let dateDiv = document.createElement("div");
        dateDiv.innerText=d;

        let dateStr = `${year}-${String(mIndex+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;

        let day = new Date(year, mIndex, d).getDay();

        if(day===0){
            dateDiv.classList.add("sun");
        }

        if(holidays[dateStr]){
            dateDiv.classList.add("holiday");

            let tip=document.createElement("span");
            tip.className="tooltip";
            tip.innerText=holidays[dateStr];
            dateDiv.appendChild(tip);
        }

        daysDiv.appendChild(dateDiv);
    }

    monthDiv.appendChild(daysDiv);
    calendar.appendChild(monthDiv);
});

</script>

<?php include 'footer.php'; ?>

</body>
</html>