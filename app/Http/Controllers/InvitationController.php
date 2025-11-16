<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));
        $invitations = Invitation::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where('invitee_name', 'like', "%{$q}%")
                      ->orWhere('slug', 'like', "%{$q}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.invitations.index', compact('invitations'));
    }

    public function create()
    {
        return view('admin.invitations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invitee_name' => ['required', 'string', 'min:2', 'max:120'],
            'slug'         => ['nullable', 'string', 'min:2', 'max:140',
                               'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                               'unique:invitations,slug'],
        ], [
            'invitee_name.required' => 'Nama yang diundang wajib diisi.',
            'slug.regex'            => 'Slug hanya boleh huruf kecil, angka, dan strip (-).',
        ]);

        // Generate slug otomatis jika tidak diisi
        if (empty($validated['slug'])) {
            $base = Str::slug($validated['invitee_name']);
            $slug = $base ?: Str::random(8);
            $i = 2;
            while (Invitation::where('slug', $slug)->exists()) {
                $slug = $base.'-'.$i++;
            }
            $validated['slug'] = $slug;
        }

        $invitation = Invitation::create($validated);

        // ⬅️ balik ke halaman create (tetap di halaman yang sama)
        //     kirimkan flash agar tombol share/copy aktif
        return back()->with([
            'success'      => 'Undangan berhasil dibuat.',
            'created_slug' => $invitation->slug,
            'created_name' => $invitation->invitee_name,
        ]);
    }

    public function edit(Invitation $invitation)
    {
        return view('admin.invitations.edit', compact('invitation'));
    }

  public function update(Request $request, Invitation $invitation)
{
    $validated = $request->validate([
        'invitee_name' => ['required', 'string', 'min:2', 'max:120'],
        'slug'         => ['required', 'string', 'min:2', 'max:140',
                           'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                           'unique:invitations,slug,' . $invitation->id],
        'is_opened'    => ['sometimes', 'boolean'],
    ]);

    $oldName = $invitation->invitee_name;
    $oldSlug = $invitation->slug;
    $newName = $validated['invitee_name'];

    // Cek apakah nama berubah dan slug lama masih default (belum custom)
    $defaultOldSlug = \Str::slug($oldName);

    if ($newName !== $oldName && $oldSlug === $defaultOldSlug) {
        // Jika hanya typo nama, perbarui slug otomatis
        $newSlug = \Str::slug($newName);
        $i = 2;
        while (Invitation::where('slug', $newSlug)->where('id', '!=', $invitation->id)->exists()) {
            $newSlug = \Str::slug($newName) . '-' . $i++;
        }
        $validated['slug'] = $newSlug;
    }

    $invitation->update($validated);

    return redirect()
        ->route('admin.invitations.edit', $invitation)
        ->with('success', 'Undangan berhasil diperbarui.');
}


    public function destroy(Invitation $invitation)
    {
        $invitation->delete();

        return redirect()
            ->route('admin.invitations.index')
            ->with('success', 'Undangan berhasil dihapus.');
    }

    public function live(Request $request)
{
    $q = trim($request->get('q', ''));
    $items = Invitation::query()
        ->when($q !== '', function ($query) use ($q) {
            $query->where('invitee_name', 'like', "%{$q}%");
        })
        ->latest()
        ->limit(30) // batasi hasil
        ->get();

    $base = rtrim(config('app.invite_base_domain', env('INVITE_BASE_DOMAIN', 'https://my-domainwedding.undnaganly.com')), '/');

    return response()->json([
        'items' => $items->map(function ($x) use ($base) {
            return [
                'id'        => $x->id,
                'name'      => $x->invitee_name,
                'is_opened' => (bool)$x->is_opened,
                'slug'      => $x->slug,
                'share_url' => $base . '/' . $x->slug,
                'edit_url'  => route('admin.invitations.edit', $x),
                'del_url'   => route('admin.invitations.destroy', $x),
                'wa_url'    => 'https://wa.me/?text=' . rawurlencode("Halo {$x->invitee_name}, ini undangan kami:\n{$base}/{$x->slug}"),
            ];
        }),
    ]);
}

}
