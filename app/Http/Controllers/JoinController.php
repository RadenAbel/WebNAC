<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJoinRequest;
use App\Mail\JoinRequestMail;
use Illuminate\Support\Facades\Mail;

class JoinController extends Controller
{
    // ⚠️ Ganti alamat ini dengan email pengelola Nugroho Aquatic Center
    // yang sesungguhnya akan menerima notifikasi pendaftaran.
    private const RECIPIENT_EMAIL = 'radenabel22@gmail.com';

    public function create()
    {
        return view('join.create');
    }

    public function store(StoreJoinRequest $request)
    {
        $data = $request->validated();

        Mail::to(self::RECIPIENT_EMAIL)->send(new JoinRequestMail($data));

        return redirect()
            ->route('join.create')
            ->with('status', 'Terima kasih! Pendaftaran Anda sudah terkirim. Tim kami akan segera menghubungi Anda.');
    }
}