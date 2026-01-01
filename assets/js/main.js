
// FITUR SEARCH
const navSearchInput = document.querySelector(".search-input"); // Sesuaikan selector dengan class input navbarmu

if (navSearchInput) {
  navSearchInput.addEventListener("keypress", function (e) {
    if (e.key === "Enter") {
      e.preventDefault();
      const keyword = this.value.trim();
      if (keyword !== "") {
        // Alihkan ke halaman tugas.php sambil membawa kata kunci
        window.location.href = `tugas.php?q=${encodeURIComponent(keyword)}`;
      }
    }
  });
}
// FITUR SEARCH

// HAMBURGER
const hamburger = document.getElementById("hamburger");
const navMenu = document.querySelector(".header nav ul");

hamburger.addEventListener("click", () => {
  navMenu.classList.toggle("active");
  hamburger.classList.toggle("active");
});
// HAMBURGER

// AUTO HIDE
let lastScroll = 0;
const header = document.querySelector(".header");

window.addEventListener("scroll", () => {
  const currentScroll = window.pageYOffset;

  if (currentScroll > lastScroll && currentScroll > 100) {
    header.style.transform = "translateY(-100%)";
  } else {
    header.style.transform = "translateY(0)";
  }

  lastScroll = currentScroll;
});
// AUTO HIDE
