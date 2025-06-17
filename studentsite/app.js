document.addEventListener("DOMContentLoaded", () => {
  // Smooth Scroll
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const href = this.getAttribute('href');
      const target = document.querySelector(href);

      if (this.id === "loginBtn") return;

      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth' });
      }
    });
  });

  // Back to Top Button
  const backToTop = document.getElementById('backToTop');
  if (backToTop) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 200) {
        backToTop.classList.add("show");
      } else {
        backToTop.classList.remove("show");
      }
    });

    backToTop.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // Search and Filter
  const searchInput = document.getElementById('searchInput');
  const classFilter = document.getElementById('classFilter');
  const cards = document.querySelectorAll('#students .card');

  function filterStudents() {
    const searchText = searchInput.value.toLowerCase();
    const selectedClass = classFilter.value;

    cards.forEach(card => {
      const name = card.querySelector('h3').textContent.toLowerCase();
      const className = card.querySelector('p').textContent;

      const matchesSearch = name.includes(searchText);
      const matchesClass = selectedClass === "" || className.includes(selectedClass);

      card.style.display = (matchesSearch && matchesClass) ? "inline-block" : "none";
    });
  }

  if (searchInput && classFilter) {
    searchInput.addEventListener('input', filterStudents);
    classFilter.addEventListener('change', filterStudents);
  }

  // Dark Mode Toggle
  const darkToggle = document.getElementById('darkModeToggle');
  if (darkToggle) {
    darkToggle.addEventListener('click', () => {
      document.body.classList.toggle('dark-mode');

      // Optional: Save preference
      if (document.body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark');
      } else {
        localStorage.setItem('theme', 'light');
      }
    });

    // Load saved theme
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
      document.body.classList.add('dark-mode');
    }
  }
});
