// js/session-header.js
document.addEventListener('DOMContentLoaded', () => {
  const box = document.getElementById('session-area');
  if (!box) return;

  const endpoint = box.dataset.endpoint || 'login/header_session.php';

  fetch(endpoint, { credentials: 'include' })
    .then(res => res.text())
    .then(html => {
      box.innerHTML = html;
    })
    .catch(() => {
      box.innerHTML = `
        <a href="login/login.html" class="user-account for-buy">
          <i class="icon icon-user"></i>
          <span>Cuenta</span>
        </a>
      `;
    });
});
