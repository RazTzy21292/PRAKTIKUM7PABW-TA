/**
 * SmaCan - app.js
 * Helper umum: modal, toast, dan fungsi AJAX ke REST API internal.
 */

const APP_URL = window.APP_BASE_URL || '';

// ===== MODAL HELPER =====
function openModal(id) {
  const el = document.getElementById(id);
  if (el) el.classList.add('open');
}
function closeModal(id) {
  const el = document.getElementById(id);
  if (el) el.classList.remove('open');
}

// ===== TOAST HELPER =====
function showToast(msg, isError = false) {
  const t = document.getElementById('toast');
  if (!t) return;
  t.textContent = msg;
  t.classList.toggle('error', isError);
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 2500);
}

// ===== KLAIM POIN EDUKASI VIA AJAX (REST API internal) =====
function claimPoinAjax(edukasiId, btnElement) {
  fetch(`${APP_URL}/api/edukasi/klaim/${edukasiId}`, {
    method: 'POST',
    headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]') || {}).content || '' },
  })
    .then((res) => res.json())
    .then((res) => {
      if (res.success) {
        showToast(res.message);
        document.querySelectorAll('.poin-num').forEach((el) => {
          el.textContent = Number(res.data.total_poin).toLocaleString('id-ID');
        });
        if (btnElement) {
          btnElement.textContent = '✓ Terklaim';
          btnElement.disabled = true;
          btnElement.style.opacity = '0.5';
        }
      } else {
        showToast(res.message, true);
      }
    })
    .catch(() => showToast('Terjadi kesalahan jaringan.', true));
}

// ===== HAPUS LAPORAN VIA AJAX (REST API internal) =====
function deleteLaporanAjax(id, cardElement) {
  if (!confirm('Yakin ingin menghapus laporan ini?')) return;

  fetch(`${APP_URL}/api/laporan/delete/${id}`, {
    method: 'POST',
    headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]') || {}).content || '' },
  })
    .then((res) => res.json())
    .then((res) => {
      if (res.success) {
        showToast(res.message);
        if (cardElement) cardElement.remove();
      } else {
        showToast(res.message, true);
      }
    })
    .catch(() => showToast('Terjadi kesalahan jaringan.', true));
}

// Auto-hide alert flash message setelah beberapa detik
document.addEventListener('DOMContentLoaded', () => {
  const alerts = document.querySelectorAll('.alert');
  alerts.forEach((el) => {
    setTimeout(() => {
      el.style.transition = 'opacity 0.4s';
      el.style.opacity = '0';
      setTimeout(() => el.remove(), 400);
    }, 4000);
  });
});

// ===== NOTIFIKASI (dropdown berfungsi di semua halaman dashboard) =====
const NOTIF_DATA = [
  { icon: 'ti-alert-circle', color: 'red',   title: 'Tong Kelas 11B penuh',        desc: 'Segera kosongkan, kapasitas sudah 95%.',          time: '5 menit lalu',   unread: true },
  { icon: 'ti-star-filled',  color: 'amber', title: 'Poin bertambah +8',           desc: 'Kamu menyelesaikan artikel edukasi daur ulang.',  time: '2 jam lalu',     unread: true },
  { icon: 'ti-alert-triangle', color: 'amber', title: 'Tong Kantin mulai penuh',   desc: 'Status terisi 70%, pantau terus ya.',             time: '4 jam lalu',     unread: true },
  { icon: 'ti-check',        color: 'green', title: 'Laporanmu sudah ditindaklanjuti', desc: 'Petugas telah mengosongkan tong yang kamu laporkan.', time: 'Kemarin', unread: false },
  { icon: 'ti-trophy',       color: 'green', title: 'Naik peringkat leaderboard!', desc: 'Kamu sekarang ada di 5 besar minggu ini.',        time: '2 hari lalu',    unread: false },
];

function buildNotifPanel() {
  const panel = document.createElement('div');
  panel.className = 'notif-panel';
  panel.id = 'globalNotifPanel';

  const hasUnread = NOTIF_DATA.some((n) => n.unread);

  panel.innerHTML = `
    <div class="notif-panel-head">
      <h4>Notifikasi</h4>
      <button type="button" id="notifMarkAllRead">Tandai semua dibaca</button>
    </div>
    <div class="notif-list">
      ${NOTIF_DATA.map((n) => `
        <div class="notif-item ${n.unread ? 'unread' : ''}">
          <div class="notif-item-icon ${n.color}"><i class="ti ${n.icon}" aria-hidden="true"></i></div>
          <div class="notif-item-body">
            <div class="notif-item-title">${n.title}</div>
            <div class="notif-item-desc">${n.desc}</div>
            <div class="notif-item-time">${n.time}</div>
          </div>
        </div>
      `).join('')}
    </div>
  `;

  document.body.appendChild(panel);
  return panel;
}

function positionNotifPanel(panel, btn) {
  const rect = btn.getBoundingClientRect();
  const panelWidth = panel.offsetWidth || 320;
  let left = rect.right - panelWidth + window.scrollX;
  if (left < 8) left = 8;
  panel.style.top = `${rect.bottom + window.scrollY + 10}px`;
  panel.style.left = `${left}px`;
}

document.addEventListener('DOMContentLoaded', () => {
  const notifBtns = document.querySelectorAll('.notif-btn');
  if (!notifBtns.length) return;

  const panel = buildNotifPanel();

  function closeNotifPanel() {
    panel.classList.remove('open');
  }

  notifBtns.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      const isOpen = panel.classList.contains('open');
      if (isOpen) {
        closeNotifPanel();
      } else {
        positionNotifPanel(panel, btn);
        panel.classList.add('open');
        // Hilangkan titik merah saat notifikasi dibuka
        document.querySelectorAll('.notif-dot').forEach((d) => (d.style.display = 'none'));
      }
    });
  });

  document.addEventListener('click', (e) => {
    if (panel.classList.contains('open') && !panel.contains(e.target)) {
      closeNotifPanel();
    }
  });
  window.addEventListener('resize', () => { if (panel.classList.contains('open')) closeNotifPanel(); });
  window.addEventListener('scroll', () => { if (panel.classList.contains('open')) closeNotifPanel(); }, true);

  panel.addEventListener('click', (e) => {
    if (e.target && e.target.id === 'notifMarkAllRead') {
      panel.querySelectorAll('.notif-item.unread').forEach((item) => item.classList.remove('unread'));
      showToast('Semua notifikasi ditandai sudah dibaca.');
    }
  });
});
