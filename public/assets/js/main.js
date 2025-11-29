document.addEventListener('DOMContentLoaded', () => {
  // Smooth anchor focus (small polish)
  const links = document.querySelectorAll('a[href^="#"]');
  for (const a of links) {
    a.addEventListener('click', (e) => {
      const id = a.getAttribute('href');
      const el = document.querySelector(id);
      if (el) {
        e.preventDefault();
        el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        el.setAttribute('tabindex', '-1');
        el.focus({ preventScroll: true });
      }
    });
  }
});
