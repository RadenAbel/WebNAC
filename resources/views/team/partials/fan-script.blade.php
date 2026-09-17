<script>
(function () {
    var groups = document.querySelectorAll('[data-fan-group]');

    groups.forEach(function (group) {
        var trigger = group.querySelector('[data-fan-trigger]');
        var grid    = group.querySelector('[data-fan-grid]');
        if (!trigger || !grid) return;

        var labelClosed = trigger.getAttribute('data-label-closed');
        var labelOpen   = trigger.getAttribute('data-label-open');
        var textEl      = trigger.querySelector('[data-fan-trigger-text]');

        trigger.addEventListener('click', function () {
            var willOpen = !group.classList.contains('is-open');

            group.classList.toggle('is-open', willOpen);
            trigger.setAttribute('aria-expanded', String(willOpen));
            if (textEl) {
                textEl.textContent = willOpen ? labelOpen : labelClosed;
            }

            if (willOpen) {
                window.setTimeout(function () {
                    grid.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }, 80);
            }
        });

        group.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && group.classList.contains('is-open')) {
                trigger.click();
                trigger.focus();
            }
        });
    });
})();
</script>