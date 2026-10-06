<?php

namespace App\Http\Controllers;

use App\Support\ImageOptimizer;
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
        $data = $request->safe()->except('website');

        if ($request->hasFile('photo')) {
            $data['photo'] = ImageOptimizer::store($request->file('photo'), 'join-requests', disk: 'local');
        }

        JoinRequest::create($data);

        return redirect()
            ->route('join.create')
            ->with('status', 'Terima kasih! Pendaftaran Anda sudah kami terima. Tim kami akan segera menghubungi Anda lewat WhatsApp.');
    }
}
