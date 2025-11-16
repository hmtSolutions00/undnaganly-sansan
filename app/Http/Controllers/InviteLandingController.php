<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Rsvp;
use App\Models\Wish;

class InviteLandingController extends Controller
{
    public function show(Invitation $invitation)
    {
        // Tandai undangan sudah dibuka
        $invitation->markOpened();

        // Fallback nama tamu:
        // - kalau invitee_name null / kosong / hanya spasi → gunakan "Tamu"
        $guestName = trim((string) $invitation->invitee_name);
        if ($guestName === '') {
            $guestName = 'Tamu';
        }

        // (Opsional) kalau kamu juga mau jaga-jaga slug kosong di view,
        // bisa pakai fallback 'tamu' (tapi secara DB & routing slug seharusnya tidak boleh kosong)
        $slug = trim((string) $invitation->slug);
        if ($slug === '') {
            $slug = 'tamu';
        }

        // SEMUA RSVP (global), misal hanya yang hadir
        $rsvps = Rsvp::where('status', 'hadir')
            ->latest()
            ->get();

        // SEMUA WISHES (global), hanya yang public
        $wishes = Wish::where('is_public', true)
            ->latest()
            ->get();

        return view('frontend.index', [
            'invitation' => $invitation,
            'guestName'  => $guestName,
            'slug'       => $slug,   // kalau mau dipakai di view
            'rsvps'      => $rsvps,
            'wishes'     => $wishes,
        ]);
    }
}
