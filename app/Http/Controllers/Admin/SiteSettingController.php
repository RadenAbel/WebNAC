<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSiteSettingRequest;
use App\Models\SiteSetting;
use App\Support\SocialLinkHelper;
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
        $data['instagram_url'] = SocialLinkHelper::toFullUrl($data['instagram_url'] ?? null, 'instagram');
        $data['facebook_url']  = SocialLinkHelper::toFullUrl($data['facebook_url'] ?? null, 'facebook');
        $data['youtube_url']   = SocialLinkHelper::toFullUrl($data['youtube_url'] ?? null, 'youtube');
        $data['tiktok_url']    = SocialLinkHelper::toFullUrl($data['tiktok_url'] ?? null, 'tiktok');

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

        if ($request->hasFile('classes_section_photo')) {
            if ($setting->classes_section_photo) {
                Storage::disk('public')->delete($setting->classes_section_photo);
            }
            $data['classes_section_photo'] = $request->file('classes_section_photo')->store('settings', 'public');
        }

        if ($request->hasFile('pool_section_photo')) {
            if ($setting->pool_section_photo) {
                Storage::disk('public')->delete($setting->pool_section_photo);
            }
            $data['pool_section_photo'] = $request->file('pool_section_photo')->store('settings', 'public');
        }

        if ($data['gallery_header_type'] === 'video') {
            if ($setting->gallery_header_photo) {
                Storage::disk('public')->delete($setting->gallery_header_photo);
            }
            $data['gallery_header_photo'] = null;
        } elseif ($request->hasFile('gallery_header_photo')) {
            if ($setting->gallery_header_photo) {
                Storage::disk('public')->delete($setting->gallery_header_photo);
            }
            $data['gallery_header_photo'] = $request->file('gallery_header_photo')->store('settings', 'public');
        }

        if ($data['event_header_type'] === 'video') {
            if ($setting->event_header_photo) {
                Storage::disk('public')->delete($setting->event_header_photo);
            }
            $data['event_header_photo'] = null;
        } elseif ($request->hasFile('event_header_photo')) {
            if ($setting->event_header_photo) {
                Storage::disk('public')->delete($setting->event_header_photo);
            }
            $data['event_header_photo'] = $request->file('event_header_photo')->store('settings', 'public');
        }

        if ($data['team_header_type'] === 'video') {
            if ($setting->team_header_photo) {
                Storage::disk('public')->delete($setting->team_header_photo);
            }
            $data['team_header_photo'] = null;
        } elseif ($request->hasFile('team_header_photo')) {
            if ($setting->team_header_photo) {
                Storage::disk('public')->delete($setting->team_header_photo);
            }
            $data['team_header_photo'] = $request->file('team_header_photo')->store('settings', 'public');
        }

        if ($data['join_header_type'] === 'video') {
            if ($setting->join_header_photo) {
                Storage::disk('public')->delete($setting->join_header_photo);
            }
            $data['join_header_photo'] = null;
        } elseif ($request->hasFile('join_header_photo')) {
            if ($setting->join_header_photo) {
                Storage::disk('public')->delete($setting->join_header_photo);
            }
            $data['join_header_photo'] = $request->file('join_header_photo')->store('settings', 'public');
        }

        $setting->update($data);

        return redirect()
            ->route('admin.settings.edit')
            ->with('status', 'Pengaturan situs berhasil disimpan.');
    }
}