document.addEventListener('DOMContentLoaded', function () {
    var body = document.body;

    var toggle = document.getElementById('sidebarToggle');
    var STORAGE_KEY = 'nac_admin_sidebar_collapsed';

    body.classList.toggle('nac-sidebar-collapsed', localStorage.getItem(STORAGE_KEY) === '1');

    if (toggle) {
        toggle.addEventListener('click', function () {
            var isCollapsed = body.classList.toggle('nac-sidebar-collapsed');
            localStorage.setItem(STORAGE_KEY, isCollapsed ? '1' : '0');
        });
    }

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
    document.querySelectorAll('.nac-admin-nav a').forEach(function (link) {
        link.addEventListener('click', closeMobileNav);
    });
    window.addEventListener('resize', function () {
        if (window.innerWidth >= 992) closeMobileNav();
    });

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
        calcAge();
    });

    function calcAgeBetween(birthDateStr, targetDateStr) {
        if (!birthDateStr || !targetDateStr) return '';
        var birth = new Date(birthDateStr);
        var target = new Date(targetDateStr);
        var age = target.getFullYear() - birth.getFullYear();
        var m = target.getMonth() - birth.getMonth();
        if (m < 0 || (m === 0 && target.getDate() < birth.getDate())) age--;
        return age >= 0 ? age : '';
    }

    document.querySelectorAll('[data-record-date-input]').forEach(function (input) {
        var birthDate = input.getAttribute('data-birthdate');
        var ageTarget = document.getElementById(input.getAttribute('data-age-target'));
        if (!ageTarget || !birthDate) return;

        input.addEventListener('change', function () {
            var calculated = calcAgeBetween(birthDate, input.value);
            if (calculated !== '') ageTarget.value = calculated;
        });
    });

    document.querySelectorAll('[data-event-select]').forEach(function (select) {
        var customInput = document.getElementById(select.getAttribute('data-event-custom'));
        if (!customInput) return;

        function sync() {
            if (select.value === '__custom__') {
                select.removeAttribute('name');
                customInput.classList.remove('d-none');
                customInput.setAttribute('name', 'event');
                customInput.setAttribute('required', 'required');
            } else {
                select.setAttribute('name', 'event');
                customInput.classList.add('d-none');
                customInput.removeAttribute('name');
                customInput.removeAttribute('required');
            }
        }

        select.addEventListener('change', sync);
        sync();
    });

    document.querySelectorAll('[data-toggle-edit]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var item = btn.closest('[data-item]');
            if (!item) return;
            item.querySelector('[data-view-mode]').classList.add('d-none');
            item.querySelector('[data-edit-mode]').classList.remove('d-none');
        });
    });
    document.querySelectorAll('[data-cancel-edit]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var item = btn.closest('[data-item]');
            if (!item) return;
            item.querySelector('[data-edit-mode]').classList.add('d-none');
            item.querySelector('[data-view-mode]').classList.remove('d-none');
        });
    });

    document.querySelectorAll('[data-dropdown-toggle]').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var menu = btn.parentElement.querySelector('.nac-dropdown-menu');
            if (!menu) return;

            var willOpen = !menu.classList.contains('is-open');

            document.querySelectorAll('.nac-dropdown-menu.is-open').forEach(function (m) {
                m.classList.remove('is-open');
            });

            if (willOpen) menu.classList.add('is-open');
        });
    });
    document.addEventListener('click', function () {
        document.querySelectorAll('.nac-dropdown-menu.is-open').forEach(function (m) {
            m.classList.remove('is-open');
        });
    });
});

document.addEventListener('click', function (e) {
    var btn = e.target.closest('[data-toggle-password]');
    if (!btn) return;
    var input = document.getElementById(btn.getAttribute('data-toggle-password'));
    if (!input) return;
    var show = input.type === 'password';
    input.type = show ? 'text' : 'password';
    btn.setAttribute('aria-pressed', show ? 'true' : 'false');
    var icon = btn.querySelector('i');
    if (icon) icon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
});
