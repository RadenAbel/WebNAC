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

    // PENTING: AOS menghitung titik pemicu (kapan elemen dianggap "masuk layar")
    // saat DOMContentLoaded — padahal foto-foto (galeri, dsb) masih proses loading
    // dan bikin tinggi halaman berubah setelahnya. Akibatnya, section yang posisinya
    // di bawah foto (seperti Jadwal) jadi butuh scroll lebih jauh dari seharusnya
    // sebelum animasinya "nyala" — terutama kentara di layar kecil.
    // Fix: hitung ulang setelah SEMUA aset (termasuk gambar) selesai dimuat.
    window.addEventListener('load', function () {
        if (window.AOS) {
            AOS.refreshHard();
        }
    });

    // Jaga-jaga: hitung ulang juga saat ukuran layar berubah (mis. rotate HP,
    // atau resize browser saat testing responsive di desktop).
    var aosResizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(aosResizeTimer);
        aosResizeTimer = setTimeout(function () {
            if (window.AOS) AOS.refresh();
        }, 200);
    });

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

    // Form pendaftaran (Join Us): tampilkan status loading di tombol saat
    // form dikirim, karena prosesnya (apalagi kalau ada upload foto) bisa
    // makan waktu beberapa detik — biar user tahu form sedang diproses,
    // bukan macet, dan tidak asal klik kirim berkali-kali.
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
});