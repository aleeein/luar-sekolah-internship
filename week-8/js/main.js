// Features
document.addEventListener("DOMContentLoaded", () => {
  const featuresContainer = document.querySelector(".features-content");

  featuresContainer.addEventListener("click", (e) => {
    const groupHeader = e.target.closest(".features-group-header");

    if (!groupHeader) return;

    const group = groupHeader.parentElement;
    const groupBody = group.querySelector(".features-group-body");
    const icon = groupHeader.querySelector("i");

    // Icon toggle
    icon.classList.toggle("fa-plus");
    icon.classList.toggle("fa-minus");

    // Toggle visibility of body
    groupBody.classList.toggle("open");

    // Closing other groups when one is open
    const otherGroups = featuresContainer.querySelectorAll(".features-group");

    otherGroups.forEach((otherGroup) => {
      if (otherGroup !== group) {
        const otherGroupBody = otherGroup.querySelector(".features-group-body");
        const otherIcon = otherGroup.querySelector(".features-group-header i");

        otherGroupBody.classList.remove("open");
        otherIcon.classList.remove("fa-minus");
        otherIcon.classList.add("fa-plus");
      }
    });
  });
});

// Login Form
document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.getElementById("loginForm");

  loginForm.addEventListener("submit", (e) => {
    e.preventDefault(); // Prevent form from refreshing the page

    // Show the alert for successful login
    alert("Login successful!");
  });
});

// About Slideshow
let slideIndex = 0;
showSlides();

function showSlides() {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {
    slideIndex = 1;
  }
  slides[slideIndex - 1].style.display = "block";
  setTimeout(showSlides, 4000); // Change image every 4 seconds
}

function plusSlides(n) {
  let slides = document.getElementsByClassName("mySlides");
  slideIndex += n;
  if (slideIndex > slides.length) {
    slideIndex = 1;
  }
  if (slideIndex < 1) {
    slideIndex = slides.length;
  }
  for (let i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slides[slideIndex - 1].style.display = "block";
}

// Programs
function filterCourses(category) {
  const courses = document.querySelectorAll(".course-card");

  courses.forEach((course) => {
    if (
      course.getAttribute("data-category") === category ||
      category === "all"
    ) {
      course.style.display = "block";
    } else {
      course.style.display = "none";
    }
  });
}

// Email Verification
function validateForm() {
  const email = document.getElementById("email").value;
  const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

  if (!emailPattern.test(email)) {
    alert("Invalid email format. Please enter a valid email address.");
    return false;
  }
  return true;
}