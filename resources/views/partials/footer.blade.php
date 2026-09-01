<footer class="nac-footer" id="kontak">
    <div class="container">

        {{-- ============ INFO FOOTER ============ --}}
        <div class="row gy-4 nac-footer__cols">
            <div class="col-lg-4">
                <a href="{{ route('home') }}" class="nac-brand nac-brand--footer">
                    <img src="{{ $setting->logo_url ?? asset('img/Logo.png') }}" alt="Logo {{ $setting->site_name ?? 'NAC' }}" class="nac-brand__mark">
                    <span class="nac-brand__text_f">{{ $setting->site_name ?? 'Nugroho Aquatic Club' }}</span>
                </a>
                <p class="nac-footer__desc">
                    Kolam renang premium dengan pelatih bersertifikat, dirancang untuk atlet
                    junior hingga senior yang serius mengejar performa terbaik.
                </p>
                <div class="nac-footer__social">
                    @if ($setting->instagram_url)
                        <a href="{{ $setting->instagram_url }}" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    @endif
                    @if ($setting->facebook_url)
                        <a href="{{ $setting->facebook_url }}" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    @endif
                    @if ($setting->youtube_url)
                        <a href="{{ $setting->youtube_url }}" target="_blank" rel="noopener" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    @endif
                    @if ($setting->whatsapp_url)
                        <a href="{{ $setting->whatsapp_url }}" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    @endif
                </div>
            </div>

            <div class="col-lg-2 col-6">
                <h6 class="nac-footer__title">Jam Operasional</h6>
                <ul class="nac-footer__links">
                    <li>Senin – Jumat: {{ $setting->opening_hours_weekday ?? '06.00 – 21.00' }}</li>
                    <li>Sabtu – Minggu: {{ $setting->opening_hours_weekend ?? '07.00 – 20.00' }}</li>
                </ul>
            </div>

            <div class="col-lg-3">
                <h6 class="nac-footer__title">Kontak</h6>
                <ul class="nac-footer__links">
                    <li>
                        <a href="tel:{{ $setting->phone }}" class="text-decoration-none">
                            <i class="bi bi-telephone"></i> {{ $setting->phone ?? '+62 812-3456-7890' }}
                        </a>
                    </li>
                    <li>
                        <a href="mailto:{{ $setting->email }}" class="text-decoration-none">
                            <i class="bi bi-envelope"></i> {{ $setting->email ?? 'info@nugrohoaquatic.id' }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-3 col-6" id="lokasi">
                <h6 class="nac-footer__title">Lokasi</h6>
                <p class="nac-footer__map-desc">
                    {{ $setting->address ?? 'Jl. Aquatic Raya No. 1, Surabaya, Jawa Timur' }}
                </p>
                <div class="nac-map-frame nac-map-frame--sm">
                    <iframe
                        src="{{ $setting->map_embed_url ?? 'https://www.google.com/maps?q=Surabaya,+East+Java&output=embed' }}"
                        width="100%" height="120" style="border:0;"
                        allowfullscreen loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Lokasi {{ $setting->site_name ?? 'Nugroho Aquatic Center' }}">
                    </iframe>
                </div>
            </div>
        </div>

        <div class="nac-footer__bottom">
            <span>&copy; {{ date('Y') }} {{ $setting->site_name ?? 'Nugroho Aquatic Center' }}. Semua hak dilindungi.</span>
        </div>
    </div>
</footer>