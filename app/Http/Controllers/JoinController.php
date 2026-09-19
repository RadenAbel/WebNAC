<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJoinRequest;
use App\Models\JoinRequest;
use App\Models\SiteSetting;

class JoinController extends Controller
{
    public function create()
    {
        $setting = SiteSetting::current();

        return view('join.create', compact('setting'));
    }

    public function store(StoreJoinRequest $request)
    {
        // 'website' (honeypot) sengaja tidak ada di $fillable JoinRequest,
        // jadi walau lolos sejauh sini pun tidak akan pernah ikut tersimpan.
        $data = $request->safe()->except('website');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('join-requests', 'public');
        }

        JoinRequest::create($data);

        return redirect()
            ->route('join.create')
            ->with('status', 'Terima kasih! Pendaftaran Anda sudah kami terima. Tim kami akan segera menghubungi Anda lewat WhatsApp.');
    }
}