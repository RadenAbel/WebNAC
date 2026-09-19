<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JoinRequest;
use Illuminate\Support\Facades\Storage;

class JoinRequestController extends Controller
{
    public function index()
    {
        $joinRequests = JoinRequest::latestFirst()->paginate(15);
        $pendingCount = JoinRequest::pending()->count();

        return view('admin.join-requests.index', compact('joinRequests', 'pendingCount'));
    }

    public function show(JoinRequest $joinRequest)
    {
        return view('admin.join-requests.show', compact('joinRequest'));
    }

    public function accept(JoinRequest $joinRequest)
    {
        $joinRequest->update([
            'status'       => 'accepted',
            'responded_at' => now(),
        ]);

        $message = "Halo {$joinRequest->name}!\n\n"
            . "Selamat! Pendaftaran Anda di kategori *{$joinRequest->category}* untuk NAC Swim School telah kami *TERIMA*.\n\n"
            . "Tim kami akan segera menghubungi Anda untuk informasi jadwal & langkah selanjutnya.\n\n"
            . "Terima kasih,\nNugroho Aquatic Club";

        $waLink = $joinRequest->whatsappLink($message);

        $redirect = redirect()
            ->route('admin.join-requests.index')
            ->with('status', "Pendaftaran {$joinRequest->name} ditandai DITERIMA.");

        return $waLink
            ? $redirect->with('whatsapp_redirect', $waLink)
            : $redirect->with('whatsapp_error', "Nomor WhatsApp {$joinRequest->name} ({$joinRequest->whatsapp}) tidak valid — hubungi manual.");
    }

    public function reject(JoinRequest $joinRequest)
    {
        $joinRequest->update([
            'status'       => 'rejected',
            'responded_at' => now(),
        ]);

        $message = "Halo {$joinRequest->name},\n\n"
            . "Terima kasih atas minat Anda mendaftar di NAC Swim School kategori *{$joinRequest->category}*.\n\n"
            . "Mohon maaf, saat ini kami belum dapat menerima pendaftaran Anda. Semoga dapat bergabung di kesempatan berikutnya.\n\n"
            . "Terima kasih,\nNugroho Aquatic Club";

        $waLink = $joinRequest->whatsappLink($message);

        $redirect = redirect()
            ->route('admin.join-requests.index')
            ->with('status', "Pendaftaran {$joinRequest->name} ditandai DITOLAK.");

        return $waLink
            ? $redirect->with('whatsapp_redirect', $waLink)
            : $redirect->with('whatsapp_error', "Nomor WhatsApp {$joinRequest->name} ({$joinRequest->whatsapp}) tidak valid — hubungi manual.");
    }

    public function destroy(JoinRequest $joinRequest)
    {
        if ($joinRequest->photo) {
            Storage::disk('public')->delete($joinRequest->photo);
        }

        $name = $joinRequest->name;
        $joinRequest->delete();

        return redirect()
            ->route('admin.join-requests.index')
            ->with('status', "Pendaftaran {$name} berhasil dihapus.");
    }
}