const menuBtn = document.getElementById("menuBtn");
const nav = document.getElementById("nav");

menuBtn.addEventListener("click", () => {
  nav.classList.toggle("active");
});

/* Close menu on link click */
document.querySelectorAll(".nav a").forEach(link => {
  link.addEventListener("click", () => {
    nav.classList.remove("active");
  });
});

/* DATE & TIME */
function updateDateTime(){
  const now = new Date();

  const date = now.toLocaleDateString("en-IN", {
    weekday: "short",
    day: "2-digit",
    month: "short",
    year: "numeric"
  });

  const time = now.toLocaleTimeString("en-IN");

  document.getElementById("datetime").innerHTML =
    `<i class="fa-regular fa-clock"></i> ${date} | ${time}`;
}

setInterval(updateDateTime, 1000);
updateDateTime();
let slides = document.querySelectorAll(".slide");
let index = 0;

setInterval(() => {
    slides[index].classList.remove("active");
    index = (index + 1) % slides.length;
    slides[index].classList.add("active");
}, 3000);
let slideIndex = 1;
showSlides(slideIndex);

function changeSlide(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("slides");
  let dots = document.getElementsByClassName("dot");

  if (n > slides.length) { slideIndex = 1 }
  if (n < 1) { slideIndex = slides.length }

  for (i = 0; i < slides.length; i++) {
    slides[i].classList.remove("active");
  }

  for (i = 0; i < dots.length; i++) {
    dots[i].classList.remove("active");
  }

  slides[slideIndex - 1].classList.add("active");
  dots[slideIndex - 1].classList.add("active");
}

/* Auto Slide */
setInterval(() => {
  changeSlide(1);
}, 4000);
// Select all module cards
const moduleCards = document.querySelectorAll('.erp-module-card');

moduleCards.forEach(card => {
  card.addEventListener('click', () => {
    // Close other cards
    moduleCards.forEach(c => {
      if(c !== card) c.classList.remove('expanded');
    });
    // Toggle clicked card
    card.classList.toggle('expanded');
  });
});

function sendWhatsApp() {
  var name = document.getElementById("name").value;
  var email = document.getElementById("email").value;
  var phone = document.getElementById("phone").value;
  var subject = document.getElementById("subject").value;
  var message = document.getElementById("message").value;

  var whatsappNumber = "911772665600"; 

  var text =
    "👤 Name: " + name + "%0A" +
    "📧 Email: " + email + "%0A" +
    "📞 Phone: " + phone + "%0A" +
    "📌 Subject: " + subject + "%0A%0A" +
    "📝 Message:%0A" + message;

  var url = "https://wa.me/" + whatsappNumber + "?text=" + text;
  window.open(url, "_blank");
}
