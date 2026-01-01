document.addEventListener("DOMContentLoaded", function () {
  const taskSearchInput = document.getElementById("mainSearchInput");
  const taskCards = document.querySelectorAll(".task-card");

  function filterTasks(keyword) {
    const lowerKeyword = keyword.toLowerCase().trim();
    console.log("Mencari keyword:", lowerKeyword);

    taskCards.forEach((card) => {
      // Ambil teks dari elemen spesifik di dalam card
      const category =
        card.querySelector(".category")?.innerText.toLowerCase() || "";
      const title =
        card.querySelector(".task-title")?.innerText.toLowerCase() || "";
      const desc =
        card.querySelector(".task-desc")?.innerText.toLowerCase() || "";

      // Cek apakah keyword ada di kategori, judul, atau deskripsi
      if (
        category.includes(lowerKeyword) ||
        title.includes(lowerKeyword) ||
        desc.includes(lowerKeyword)
      ) {
        card.style.display = "block";
      } else {
        card.style.display = "none";
      }
    });
  }

  // 1. CEK PARAMETER URL (Pencarian dari Beranda)
  const urlParams = new URLSearchParams(window.location.search);
  const searchParam = urlParams.get("q");

  if (searchParam) {
    if (taskSearchInput) {
      taskSearchInput.value = searchParam;
      filterTasks(searchParam);
    }
  }

  // 2. FILTER REAL-TIME (Mengetik langsung)
  if (taskSearchInput) {
    taskSearchInput.addEventListener("input", function () {
      filterTasks(this.value);
    });
  }
});

// ADD MODAL
// Fungsi Modal Tambah
const formTambah = document.getElementById("formTambahTugas");
if (formTambah) {
  formTambah.addEventListener("submit", function (e) {
    const judulInput = document.getElementById("judulInput");
    const kategoriInput = document.getElementById("kategoriInput");
    const errorMsgJudul = document.getElementById("errorJudul");
    const errorMsgKategori = document.getElementById("errorKategori");

    const judul = judulInput.value.trim();
    const kategori = kategoriInput.value.trim();

    // Reset Style
    errorMsgJudul.style.display = "none";
    errorMsgKategori.style.display = "none";
    judulInput.style.borderColor = "";
    kategoriInput.style.borderColor = "";

    let hasError = false;

    // Validasi Kategori
    if (kategori === "") {
      e.preventDefault();
      errorMsgKategori.style.display = "block";
      kategoriInput.style.borderColor = "#ff4d4d";
      hasError = true;
    }

    // Validasi Judul
    if (judul === "") {
      e.preventDefault();
      errorMsgJudul.style.display = "block";
      judulInput.style.borderColor = "#ff4d4d";
      hasError = true;
    }

    if (hasError) {
      this.classList.add("shake");
      setTimeout(() => this.classList.remove("shake"), 500);
    }
  });
}
// });

// FUNGSI DELETE
function openDeleteModal(id, title) {
  const modal = document.getElementById("deleteModal");
  const titleSpan = document.getElementById("taskTitleToDelete");
  const confirmBtn = document.getElementById("confirmDeleteBtn");

  titleSpan.innerText = title;

  // Pastikan path-nya benar menuju proses_tugas.php
  confirmBtn.href = `../auth/proses_tugas.php?action=delete&id=${id}`;

  modal.style.display = "flex";
}

// --- FUNGSI MODAL (Bisa di luar DOMContentLoaded karena dipanggil via onclick) ---
function openAddModal() {
  document.getElementById("addModal").style.display = "flex";
}
function closeAddModal() {
  document.getElementById("addModal").style.display = "none";
}

function closeDeleteModal() {
  document.getElementById("deleteModal").style.display = "none";
}

// HAMBUERGER
const navToggle = document.getElementById("navToggle");
const navMenu = document.querySelector(".header nav ul");

navToggle.addEventListener("click", () => {
  navToggle.classList.toggle("active");
  navMenu.classList.toggle("active");
});
document.querySelectorAll(".header nav ul li a").forEach((link) => {
  link.addEventListener("click", () => {
    navMenu.classList.remove("active");
    navToggle.classList.remove("active");
  });
});

// HILANGIN NAVBAR
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
