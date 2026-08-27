<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSiteSettingRequest;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    /**
     * Tampilkan form pengaturan. Tidak ada index/create/destroy karena
     * tabel ini didesain cuma punya 1 baris data (lihat SiteSetting::current()).
     */
    public function edit()
    {
        $setting = SiteSetting::current();

        return view('admin.settings.edit', compact('setting'));
    }

    public function update(UpdateSiteSettingRequest $request)
    {
        $setting = SiteSetting::current();
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }
            $data['logo'] = $request->file('logo')->store('settings', 'public');
        }

        if ($request->hasFile('about_photo')) {
            if ($setting->about_photo) {
                Storage::disk('public')->delete($setting->about_photo);
            }
            $data['about_photo'] = $request->file('about_photo')->store('settings', 'public');
        }

        $setting->update($data);

        return redirect()
            ->route('admin.settings.edit')
            ->with('status', 'Pengaturan situs berhasil disimpan.');
    }
}