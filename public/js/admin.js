document.addEventListener('DOMContentLoaded', function () {
    var body = document.body;

    // ============ Sidebar collapse (desktop) ============
    var toggle = document.getElementById('sidebarToggle');
    var STORAGE_KEY = 'nac_admin_sidebar_collapsed';

    body.classList.toggle('nac-sidebar-collapsed', localStorage.getItem(STORAGE_KEY) === '1');

    if (toggle) {
        toggle.addEventListener('click', function () {
            var isCollapsed = body.classList.toggle('nac-sidebar-collapsed');
            localStorage.setItem(STORAGE_KEY, isCollapsed ? '1' : '0');
        });
    }

    // ============ Sidebar drawer (mobile) ============
    var mobileToggle = document.getElementById('mobileSidebarToggle');
    var backdrop = document.getElementById('sidebarBackdrop');

    function closeMobileNav() {
        body.classList.remove('nac-mobile-nav-open');
    }

    if (mobileToggle) {
        mobileToggle.addEventListener('click', function () {
            body.classList.toggle('nac-mobile-nav-open');
        });
    }
    if (backdrop) {
        backdrop.addEventListener('click', closeMobileNav);
    }
    // Tutup drawer otomatis begitu salah satu menu diklik (biar tidak nutup manual)
    document.querySelectorAll('.nac-admin-nav a').forEach(function (link) {
        link.addEventListener('click', closeMobileNav);
    });
    // Tutup drawer kalau layar di-resize balik ke ukuran desktop
    window.addEventListener('resize', function () {
        if (window.innerWidth >= 992) closeMobileNav();
    });

    // ============ Preview foto saat upload (dropzone) ============
    document.querySelectorAll('[data-photo-input]').forEach(function (input) {
        input.addEventListener('change', function () {
            var previewId = input.getAttribute('data-photo-input');
            var preview = document.getElementById(previewId);
            if (preview && input.files && input.files[0]) {
                preview.src = window.URL.createObjectURL(input.files[0]);
                preview.style.display = 'block';
            }
        });
    });

    // ============ Stack preview (mobile) — Slider & Galeri ============
    document.querySelectorAll('[data-stack-trigger]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var group = btn.closest('[data-stack-group]');
            if (!group) return;

            var willOpen = !group.classList.contains('is-open');
            group.classList.toggle('is-open', willOpen);

            var textEl = btn.querySelector('[data-stack-trigger-text]');
            if (textEl) {
                textEl.textContent = willOpen
                    ? btn.getAttribute('data-label-open')
                    : btn.getAttribute('data-label-closed');
            }
        });
    });

    // ============ Umur otomatis dari Tanggal Lahir (form Tim) ============
    document.querySelectorAll('[data-birthdate-input]').forEach(function (input) {
        var ageOutput = document.getElementById(input.getAttribute('data-birthdate-input'));
        if (!ageOutput) return;

        function calcAge() {
            if (!input.value) {
                ageOutput.value = '';
                return;
            }
            var birthDate = new Date(input.value);
            var today = new Date();
            var age = today.getFullYear() - birthDate.getFullYear();
            var monthDiff = today.getMonth() - birthDate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            ageOutput.value = age >= 0 ? age : '';
        }

        input.addEventListener('change', calcAge);
        // Langsung hitung begitu halaman dimuat, kalau tanggal lahir sudah
        // terisi sebelumnya (mis. waktu buka halaman Edit).
        calcAge();
    });
});