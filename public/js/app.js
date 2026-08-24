document.addEventListener('DOMContentLoaded', function () {
    // Init AOS (scroll reveal) — durasi & easing dijaga tetap halus, tidak berlebihan
    if (window.AOS) {
        AOS.init({
            duration: 600,
            easing: 'ease-out-cubic',
            once: true,
            offset: 60,
        });
    }

    // Navbar: tambah background lebih solid saat halaman discroll
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

    // Galeri: tombol panah kiri-kanan untuk scroll slider
    var galleryTrack = document.querySelector('[data-gallery-track]');
    if (galleryTrack) {
        var prevBtn = document.querySelector('[data-gallery-prev]');
        var nextBtn = document.querySelector('[data-gallery-next]');
        var scrollStep = function () {
            var item = galleryTrack.querySelector('.nac-gallery__item');
            var itemWidth = item ? item.offsetWidth : 300;
            return itemWidth + 20; // lebar item + gap
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
});