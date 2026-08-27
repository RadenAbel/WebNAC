<?php

namespace App\Http\Requests\Admin;

class UpdateScheduleRequest extends StoreScheduleRequest
{
    // Aturan validasi sama persis dengan create — tidak ada field file upload
    // yang perlu dibedakan seperti di Slider/Galeri. Dipisah class tetap
    // dipertahankan untuk konsistensi pola dengan Request lain di project ini.
}