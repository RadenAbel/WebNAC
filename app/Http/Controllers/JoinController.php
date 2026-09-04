<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJoinRequest;
use App\Mail\JoinRequestMail;
use Illuminate\Support\Facades\Mail;

class JoinController extends Controller
{
    // ⚠️ Ganti alamat ini dengan email pengelola Nugroho Aquatic Center
    // yang sesungguhnya akan menerima notifikasi pendaftaran.
    private const RECIPIENT_EMAIL = 'flutteruser57@gmail.com';

    public function create()
    {
        return view('join.create');
    }

    public function store(StoreJoinRequest $request)
    {
        $data = $request->validated();

        // Foto tidak disimpan permanen ke disk — cukup dilampirkan langsung
        // ke email dari file sementara (temp) hasil upload. Karena
        // Mail::send() di sini bersifat sinkron (bukan di-queue), file
        // sementara itu masih ada selama proses ini berjalan.
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $data['photo_path'] = $photo->getRealPath();
            $data['photo_ext']  = $photo->getClientOriginalExtension() ?: 'jpg';
            $data['photo_mime'] = $photo->getMimeType();
        }

        Mail::to(self::RECIPIENT_EMAIL)->send(new JoinRequestMail($data));

        return redirect()
            ->route('join.create')
            ->with('status', 'Terima kasih! Pendaftaran Anda sudah terkirim. Tim kami akan segera menghubungi Anda.');
    }
}