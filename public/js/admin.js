(function () {
  // Copy-to-clipboard
  document.addEventListener('click', function (e) {
    const btn = e.target.closest('[data-action="copy"]');
    if (!btn) return;
    const link = btn.getAttribute('data-link');
    if (!link) return;

    navigator.clipboard.writeText(link).then(() => {
      showToast('Tautan disalin');
    }).catch(() => {
      // fallback
      const input = document.createElement('input');
      input.value = link;
      document.body.appendChild(input);
      input.select();
      document.execCommand('copy');
      input.remove();
      showToast('Tautan disalin');
    });
  });

  // Simple toast (gunakan Bootstrap toast kalau mau)
  function showToast(msg) {
    let el = document.getElementById('simple-toast');
    if (!el) {
      el = document.createElement('div');
      el.id = 'simple-toast';
      el.style.position = 'fixed';
      el.style.left = '50%';
      el.style.bottom = '80px';
      el.style.transform = 'translateX(-50%)';
      el.style.background = '#D4AF37';
      el.style.color = '#111';
      el.style.padding = '10px 14px';
      el.style.borderRadius = '10px';
      el.style.boxShadow = '0 8px 30px rgba(0,0,0,.15)';
      el.style.zIndex = '2000';
      document.body.appendChild(el);
    }
    el.textContent = msg;
    el.style.opacity = '1';
    setTimeout(() => { el.style.opacity = '0'; }, 1600);
  }
})();
