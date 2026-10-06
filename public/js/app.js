document.addEventListener('DOMContentLoaded', function () {
    if (window.AOS) {
        AOS.init({
            duration: 600,
            easing: 'ease-out-cubic',
            once: true,
            offset: 60,
        });
    }

    window.addEventListener('load', function () {
        if (window.AOS) {
            AOS.refreshHard();
        }
    });

    var aosResizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(aosResizeTimer);
        aosResizeTimer = setTimeout(function () {
            if (window.AOS) AOS.refresh();
        }, 200);
    });

    var navbar = document.getElementById('nacNavbar');
    if (navbar) {
        var onScroll = function () {
            if (window.scrollY > 40) {
                navbar.classList.add('nac-navbar--scrolled');
            } else {
                navbar.classList.remove('nac-navbar--scrolled');
            }
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

    var galleryTrack = document.querySelector('[data-gallery-track]');
    if (galleryTrack) {
        var prevBtn = document.querySelector('[data-gallery-prev]');
        var nextBtn = document.querySelector('[data-gallery-next]');
        var scrollStep = function () {
            var item = galleryTrack.querySelector('.nac-gallery__item');
            var itemWidth = item ? item.offsetWidth : 300;
            return itemWidth + 20;
        };

        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                galleryTrack.scrollBy({ left: -scrollStep(), behavior: 'smooth' });
            });
        }
        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                galleryTrack.scrollBy({ left: scrollStep(), behavior: 'smooth' });
            });
        }
    }

    var joinForm = document.getElementById('joinForm');
    if (joinForm) {
        joinForm.addEventListener('submit', function () {
            var btn = document.getElementById('joinSubmitBtn');
            if (btn && !btn.disabled) {
                btn.disabled = true;
                btn.classList.add('is-loading');
            }
        });
    }

    var counterEls = document.querySelectorAll('[data-counter]');
    if (counterEls.length && window.IntersectionObserver) {
        var animateCounter = function (el) {
            var target = parseInt(el.getAttribute('data-counter'), 10) || 0;
            var duration = 1400;
            var startTime = null;

            function step(timestamp) {
                if (!startTime) startTime = timestamp;
                var progress = Math.min((timestamp - startTime) / duration, 1);
                var eased = 1 - Math.pow(1 - progress, 3);
                el.textContent = Math.floor(eased * target);
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                } else {
                    el.textContent = target;
                }
            }
            window.requestAnimationFrame(step);
        };

        var counterObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting && !entry.target.dataset.counted) {
                    entry.target.dataset.counted = 'true';
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.4 });

        counterEls.forEach(function (el) { counterObserver.observe(el); });
    }

    document.querySelectorAll('[data-play-video]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var embedUrl = btn.getAttribute('data-play-video');
            var iframe = document.createElement('iframe');
            iframe.src = embedUrl + (embedUrl.indexOf('?') > -1 ? '&' : '?') + 'autoplay=1';
            iframe.className = 'nac-gallery__play-iframe';
            iframe.setAttribute('allow', 'autoplay; encrypted-media; fullscreen');
            iframe.setAttribute('allowfullscreen', '');
            iframe.setAttribute('frameborder', '0');
            btn.replaceWith(iframe);
        });
    });

    document.querySelectorAll('[data-facility-showcase]').forEach(function (box) {
        var tabs = box.querySelectorAll('[data-facility-tab]');
        var panels = box.querySelectorAll('[data-facility-panel]');

        function show(index) {
            tabs.forEach(function (tab) {
                var active = tab.getAttribute('data-facility-tab') === String(index);
                tab.classList.toggle('is-active', active);
                tab.setAttribute('aria-selected', active ? 'true' : 'false');
                if (active && tab.scrollIntoView && window.innerWidth < 992) {
                    tab.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                }
            });
            panels.forEach(function (panel) {
                var active = panel.getAttribute('data-facility-panel') === String(index);
                panel.classList.toggle('is-active', active);
                panel.hidden = !active;
            });
        }

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                show(tab.getAttribute('data-facility-tab'));
            });
        });
    });

    var hoverQuery = window.matchMedia('(hover: hover) and (pointer: fine) and (min-width: 992px)');

    if (typeof bootstrap !== 'undefined') {
        var navDropdowns = [];

        document.querySelectorAll('.navbar-nav .dropdown').forEach(function (item) {
            var toggle = item.querySelector('[data-bs-toggle="dropdown"]');
            if (!toggle) return;

            var dropdown = bootstrap.Dropdown.getOrCreateInstance(toggle);
            var closeTimer = null;
            navDropdowns.push({ item: item, dropdown: dropdown, cancel: function () { clearTimeout(closeTimer); } });

            item.addEventListener('mouseenter', function () {
                if (!hoverQuery.matches) return;
                clearTimeout(closeTimer);
                navDropdowns.forEach(function (other) {
                    if (other.item !== item) {
                        other.cancel();
                        other.dropdown.hide();
                    }
                });
                dropdown.show();
                toggle.blur();
            });

            item.addEventListener('mouseleave', function () {
                if (!hoverQuery.matches) return;
                closeTimer = setTimeout(function () { dropdown.hide(); }, 120);
            });

            toggle.addEventListener('click', function (e) {
                if (!hoverQuery.matches) return;
                e.preventDefault();
                e.stopPropagation();
                dropdown.show();
                if (e.detail > 0) toggle.blur();
            }, true);
        });
    }

    document.querySelectorAll('[data-board]').forEach(function (board) {
        var backdrop = board.parentElement.querySelector('[data-board-backdrop]');
        var openId = null;
        var lastTrigger = null;

        function drawerFor(id) { return board.querySelector('[data-board-drawer="' + id + '"]'); }
        function triggerFor(id) { return board.querySelector('[data-board-open="' + id + '"]'); }

        function close(updateHash) {
            if (!openId) return;
            var drawer = drawerFor(openId), trigger = triggerFor(openId);
            if (drawer) { drawer.classList.remove('is-open'); drawer.hidden = true; }
            if (trigger) trigger.setAttribute('aria-expanded', 'false');
            if (backdrop) { backdrop.classList.remove('is-open'); backdrop.hidden = true; }
            document.body.style.overflow = '';
            openId = null;
            if (updateHash && window.history.replaceState) {
                history.replaceState(null, '', window.location.pathname + window.location.search);
            }
            if (lastTrigger) { lastTrigger.focus(); lastTrigger = null; }
        }

        function open(id) {
            var drawer = drawerFor(id);
            if (!drawer) return;
            if (openId) close(false);

            drawer.hidden = false;
            if (backdrop) backdrop.hidden = false;
            void drawer.offsetWidth;
            drawer.classList.add('is-open');
            if (backdrop) backdrop.classList.add('is-open');
            document.body.style.overflow = 'hidden';

            var trigger = triggerFor(id);
            if (trigger) trigger.setAttribute('aria-expanded', 'true');
            openId = id;
            drawer.scrollTop = 0;
            var closeBtn = drawer.querySelector('[data-board-close]');
            if (closeBtn) closeBtn.focus();

            if (window.history.replaceState) history.replaceState(null, '', '#' + id);
        }

        board.querySelectorAll('[data-board-open]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                lastTrigger = btn;
                open(btn.getAttribute('data-board-open'));
            });
        });
        board.querySelectorAll('[data-board-close]').forEach(function (btn) {
            btn.addEventListener('click', function () { close(true); });
        });
        if (backdrop) backdrop.addEventListener('click', function () { close(true); });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && openId) close(true);
        });

        var hash = decodeURIComponent(window.location.hash.replace('#', ''));
        if (hash && drawerFor(hash)) {
            window.addEventListener('load', function () {
                var card = document.getElementById(hash);
                if (card) card.scrollIntoView({ block: 'center' });
                open(hash);
            });
        }
    });
});
