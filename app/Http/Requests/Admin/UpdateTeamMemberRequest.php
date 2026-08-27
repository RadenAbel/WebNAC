<?php

namespace App\Http\Requests\Admin;

class UpdateTeamMemberRequest extends StoreTeamMemberRequest
{
    // Aturan validasi sama persis dengan saat membuat data baru (photo
    // tetap opsional — kalau tidak diupload, foto lama tidak berubah).
    // Dipisah jadi class sendiri supaya gampang dikustomisasi nanti kalau
    // aturan create vs update perlu dibedakan.
}