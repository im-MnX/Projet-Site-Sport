document.addEventListener('DOMContentLoaded', function () {
  const dropdowns = document.querySelectorAll('[data-dropdown]');

  function closeAll() {
    dropdowns.forEach(d => {
      d.classList.remove('open');
      const btn = d.querySelector('.dropdown-toggle');
      if (btn) btn.setAttribute('aria-expanded', 'false');
    });
  }

  dropdowns.forEach(drop => {
    const toggle = drop.querySelector('.dropdown-toggle');

    // toggle on click
    toggle.addEventListener('click', function (e) {
      const isOpen = drop.classList.contains('open');
      closeAll();
      if (!isOpen) {
        drop.classList.add('open');
        toggle.setAttribute('aria-expanded', 'true');
      }
      e.stopPropagation();
    });

    // optional: close when an item is clicked (useful for links)
    const items = drop.querySelectorAll('.dropdown-item');
    items.forEach(i => i.addEventListener('click', () => closeAll()));
  });

  // close if click outside
  document.addEventListener('click', function () {
    closeAll();
  });

  // close on Escape
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeAll();
  });
});
