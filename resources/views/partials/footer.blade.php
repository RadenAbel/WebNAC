<div class="nac-divider nac-divider--dark" aria-hidden="true">
    <span class="nac-divider__line"></span>
    <span class="nac-divider__icon"><i class="fa-solid fa-location-dot"></i></span>
    <span class="nac-divider__line"></span>
</div>

<footer class="nac-footer" id="kontak">
    <div class="container">

        {{-- ============ INFO FOOTER ============ --}}
        <div class="row gy-4 nac-footer__cols">
            <div class="col-lg-4">
                <a href="{{ route('home') }}" class="nac-brand nac-brand--footer">
                    <img src="{{ asset('img/Logo.png') }}" alt="Logo NAC" class="nac-brand__mark">
                    <span class="nac-brand__text">Nugroho Aquatic Center</span>
                </a>
                <p class="nac-footer__desc">
                    Kolam renang premium dengan pelatih bersertifikat, dirancang untuk atlet
                    junior hingga senior yang serius mengejar performa terbaik.
                </p>
                <div class="nac-footer__social">
                    <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    <a href="#" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-6">
                <h6 class="nac-footer__title">Jam Operasional</h6>
                <ul class="nac-footer__links">
                    <li>Senin – Jumat: 06.00 – 21.00</li>
                    <li>Sabtu – Minggu: 07.00 – 20.00</li>
                </ul>
            </div>

            <div class="col-lg-3">
                <h6 class="nac-footer__title">Kontak</h6>
                <ul class="nac-footer__links">
                    <li><i class="bi bi-telephone"></i> +62 812-3456-7890</li>
                    <li><i class="bi bi-envelope"></i> info@nugrohoaquatic.id</li>
                </ul>
            </div>
            
            <div class="col-lg-3 col-6" id="lokasi">
                <h6 class="nac-footer__title">Lokasi</h6>
                <p class="nac-footer__map-desc">
                    Jln. A.H. Nasution Gg. Walet, Tlk. Lingga, Kec. Sangatta Utara, Kabupaten Kutai Timur, Kalimantan Timur 75611
                </p>
                <div class="nac-map-frame nac-map-frame--sm">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.645550719851!2d117.53442831085492!3d0.5332075994593344!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x320bb506a5c25e9b%3A0x37a66f3147a434f9!2sNugroho%20Aquatic%20Club!5e0!3m2!1sen!2sid!4v1787534193240!5m2!1sen!2sid"
                        width="100%" height="120" style="border:0;"
                        allowfullscreen loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Lokasi Nugroho Aquatic Center">
                    </iframe>
                </div>
            </div>
        </div>

        <div class="nac-footer__bottom">
            <span>&copy; {{ date('Y') }} Nugroho Aquatic Center. Semua hak dilindungi.</span>
        </div>
    </div>
</footer>