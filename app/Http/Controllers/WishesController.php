<?php

namespace App\Http\Controllers;

use App\Models\Wish;
use Illuminate\Http\Request;
use App\Models\Invitation;

class WishesController extends Controller
{
    // Index: list ucapan + paginate; q = cari nama undangan
    public function index(Request $request)
    {
        $q = (string) $request->query('q', '');

        $wishes = Wish::query()
            ->with(['invitation:id,invitee_name'])
            ->when($q !== '', function ($qr) use ($q) {
                $qr->whereHas('invitation', fn($iq) => $iq->where('invitee_name', 'like', "%{$q}%"));
            })
            ->latest()
            ->paginate(10);

        return view('admin.wishes.index', [
            'wishes' => $wishes,
            'q'      => $q,
        ]);
    }

    // Live search: JSON (q saja)
    public function live(Request $request)
    {
        $q = (string) $request->query('q', '');

        $items = Wish::query()
            ->with(['invitation:id,invitee_name'])
            ->when($q !== '', function ($qr) use ($q) {
                $qr->whereHas('invitation', fn($iq) => $iq->where('invitee_name', 'like', "%{$q}%"));
            })
            ->latest()
            ->limit(40)
            ->get(['id','invitation_id','name','message','is_public','created_at']);

        $json = $items->map(function ($w) {
            $full   = trim((string) $w->message);
            $words  = str_word_count(strip_tags($full));
            $short  = \Illuminate\Support\Str::words(strip_tags($full), 50, '…');

            return [
                'id'           => $w->id,
                'invitee_name' => optional($w->invitation)->invitee_name ?? '(tanpa undangan)',
                'wisher_name'  => $w->name,
                'preview'      => $short,
                'too_long'     => $words > 50,
                'full'         => $full,
            ];
        });

        return response()->json(['items' => $json]);
    }


     public function storeFromGuest(Request $request, Invitation $invitation)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:120'],
            'message' => ['required', 'string', 'max:1000'],
        ], [
            'name.required'    => 'Nama wajib diisi.',
            'message.required' => 'Ucapan wajib diisi.',
        ]);

        $data['invitation_id'] = $invitation->id;
        // is_public biarkan default true, atau bisa ambil dari form kalau mau

        Wish::create($data);

       return redirect()
    ->route('invite.show', $invitation)
    ->with([
        'wish_success' => 'Terima kasih atas ucapan dan doanya 🙏',
        'skip_cover'   => true,
    ]);
    }
}
