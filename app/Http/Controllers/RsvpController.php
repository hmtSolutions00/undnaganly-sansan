<?php

namespace App\Http\Controllers;

use App\Models\Rsvp;
use Illuminate\Http\Request;
use App\Models\Invitation; 

class RsvpController extends Controller
{
    public function index(Request $request)
      {
        $q       = (string) $request->query('q', '');
        $status  = (string) $request->query('status', 'all');
        $statusN = in_array($status, ['hadir','tidak_hadir'], true) ? $status : '';

        $rsvps = Rsvp::query()
            ->when($q !== '', fn($qr) => $qr->where('name', 'like', "%{$q}%"))
            ->when($statusN !== '', fn($qr) => $qr->where('status', $statusN))
            ->latest()
            ->paginate(10);

        return view('admin.rsvp.index', [
            'rsvps'  => $rsvps,
            'q'      => $q,
            'status' => $statusN,
        ]);
    }

    // === Live search (JSON) ===
    public function live(Request $request)
    {
        $q      = trim((string) $request->get('q', ''));
        $status = $request->get('status');

        $items = Rsvp::query()
            ->when($q !== '', fn($qr) => $qr->where('name', 'like', "%{$q}%"))
            ->when(in_array($status, ['hadir','tidak_hadir'], true), fn($qr) => $qr->where('status', $status))
            ->latest()
            ->limit(40)
            ->get(['id','name','status']); // cukup kolom yang perlu

        return response()->json([
            'items' => $items,
        ]);
    }
       public function storeFromGuest(Request $request, Invitation $invitation)
    {
        // validasi input
        $data = $request->validate([
            'name'            => ['required', 'string', 'max:120'],
            'status'          => ['required', 'in:hadir,tidak_hadir'],
            'total_attendees' => ['required', 'integer', 'min:1', 'max:10'],
        ], [
            'name.required'   => 'Nama wajib diisi.',
            'status.required' => 'Konfirmasi kehadiran wajib dipilih.',
        ]);

        $data['invitation_id'] = $invitation->id;

        Rsvp::create($data);

        return redirect()
    ->route('invite.show', $invitation)
    ->with([
        'rsvp_success' => 'Terima kasih, konfirmasi kehadiran berhasil dikirim.',
        'skip_cover'   => true,
    ]);
    }
}
