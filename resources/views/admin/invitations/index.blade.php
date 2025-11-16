@extends('layouts.admin')

@section('title', 'Undangan • Admin')

@push('styles')
<style>
  /* Header th rata tengah & ukuran ringkas */
  .table-tight th, .table-tight td { padding: .5rem .5rem; }
  .table-tight thead th { text-align: center; }

  /* Kolom viewed kecil & center */
  .col-viewed { width: 82px; text-align: center; }

  /* Kolom aksi compact & no-wrap agar tak pecah baris */
  .col-actions { width: 200px; text-align: right; white-space: nowrap; }

  /* Badge kecil */
  .badge-xs { font-size: .75rem; padding: .35em .65em; border-radius: .5rem; }

  /* Tombol ikon lebih rapat */
  .btn-icon { padding: .25rem .45rem; }
  .btn-icon i { font-size: 1rem; line-height: 1; }
  /* Pagination rapi */
  .pagination { gap: .25rem; }
  .page-item .page-link { padding: .35rem .6rem; line-height: 1.2; }
</style>
@endpush

@section('content')
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="page-title m-0">Undangan</h1>
    <a href="{{ route('admin.invitations.create') }}" class="btn btn-gold">
      <i class="bi bi-plus-lg me-1"></i> Tambah Undangan
    </a>
  </div>

  {{-- Pencarian sederhana --}}
<form method="GET" class="mb-3" onsubmit="return false;">
  <div class="input-group">
    <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
    <input type="text" id="liveSearch" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama yang diundang...">
    <button class="btn btn-outline-gold d-none d-sm-inline" type="button" id="btnSearchSubmit">Cari</button>
  </div>
  <small id="liveHint" class="text-muted d-block mt-1">Ketik untuk pencarian langsung…</small>
</form>


  @if($invitations->isEmpty())
    <div class="card empty-state">
      <div class="card-body text-center py-5">
        <i class="bi bi-card-list display-5 d-block mb-3 text-gold"></i>
        <h5 class="mb-2">Data undangan belum dibuat</h5>
        <p class="text-muted mb-4">Mulai dengan membuat undangan baru untuk mengirim tautan ke tamu.</p>
        <a href="{{ route('admin.invitations.create') }}" class="btn btn-gold">
          <i class="bi bi-plus-lg me-1"></i> Buat Undangan
        </a>
      </div>
    </div>
  @else
    {{-- table-sm untuk tampilan rapat; hilangkan min-width agar muat di layar kecil --}}
    <div class="rounded-3 shadow-sm">
      <table class="table table-hover table-sm align-middle m-0 table-tight">
        <thead class="table-gold">
          <tr>
            <th>Nama Tamu</th>
            <th class="col-viewed">Viewed</th>
            <th class="col-actions">Aksi</th>
          </tr>
        </thead>
        <tbody class="table-group-divider" id="invTableBody">
          @foreach($invitations as $invitation)
            @php
              $shareUrl = $invitation->share_url ?? (rtrim(config('app.invite_base_domain', env('INVITE_BASE_DOMAIN', 'https://andre-sansan.undnaganly.com')), '/').'/'.$invitation->slug);
              $waText = rawurlencode("Halo {$invitation->invitee_name}, ini undangan kami:\n{$shareUrl}");
              $waUrl  = "https://wa.me/?text={$waText}";
            @endphp
            <tr>
              <td class="fw-medium">{{ $invitation->invitee_name }}</td>
              <td class="text-center">
                @if($invitation->is_opened)
                  <span class="badge bg-success-subtle text-success badge-xs">Yes</span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary badge-xs">No</span>
                @endif
              </td>
              <td class="text-end">
                <div class="btn-group" role="group">
                  <button
                    class="btn btn-outline-gold btn-sm btn-icon"
                    data-action="copy"
                    data-link="{{ $shareUrl }}"
                    title="Salin tautan">
                    <i class="bi bi-clipboard"></i>
                  </button>
                  <a class="btn btn-outline-gold btn-sm btn-icon" href="{{ $waUrl }}" target="_blank" title="Share WhatsApp">
                    <i class="bi bi-whatsapp"></i>
                  </a>
                  <a href="{{ route('admin.invitations.edit', $invitation) }}" class="btn btn-outline-gold btn-sm btn-icon" title="Ubah">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <form action="{{ route('admin.invitations.destroy', $invitation) }}" method="POST" onsubmit="return confirm('Hapus undangan ini?')" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-gold btn-sm btn-icon" title="Hapus">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- Pagination (jika pakai paginate()) --}}
  <div class="mt-3 d-flex justify-content-center" id="paginationWrap">
  {{ $invitations->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}
</div>

  @endif
  @push('scripts')
<script>
(function(){
  const input   = document.getElementById('liveSearch');
  const tbody   = document.getElementById('invTableBody');
  const pager   = document.getElementById('paginationWrap');
  const hint    = document.getElementById('liveHint');

  const routes = {
    live: @json(route('admin.invitations.live'))
  };

  // Debounce helper
  let t = null;
  input.addEventListener('input', function(){
    clearTimeout(t);
    const q = (this.value || '').trim();
    if(q.length === 0){
      // kosong -> reload halaman agar kembali pakai pagination server (atau kamu bisa fetch page 1)
      pager?.classList.remove('d-none');
      hint && (hint.textContent = 'Ketik untuk pencarian langsung…');
      return;
    }
    hint && (hint.textContent = 'Mencari…');
    pager?.classList.add('d-none');
    t = setTimeout(()=> runLive(q), 250);
  });

  async function runLive(q){
    try{
      const url = new URL(routes.live, window.location.origin);
      url.searchParams.set('q', q);
      const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }});
      const data = await res.json();
      renderRows(data.items);
      hint && (hint.textContent = data.items.length ? `Menampilkan ${data.items.length} hasil` : 'Tidak ada hasil');
    }catch(e){
      console.error(e);
      hint && (hint.textContent = 'Gagal memuat hasil');
    }
  }

  function renderRows(items){
    const rows = items.map(item => {
      const viewedBadge = item.is_opened
        ? '<span class="badge bg-success-subtle text-success badge-xs">Yes</span>'
        : '<span class="badge bg-secondary-subtle text-secondary badge-xs">No</span>';
      return `
        <tr>
          <td class="fw-medium">${escapeHtml(item.name)}</td>
          <td class="text-center">${viewedBadge}</td>
          <td class="text-end">
            <div class="btn-group" role="group">
              <button class="btn btn-outline-gold btn-sm btn-icon" data-action="copy" data-link="${item.share_url}" title="Salin tautan">
                <i class="bi bi-clipboard"></i>
              </button>
              <a class="btn btn-outline-gold btn-sm btn-icon" href="${item.wa_url}" target="_blank" title="Share WhatsApp">
                <i class="bi bi-whatsapp"></i>
              </a>
              <a href="${item.edit_url}" class="btn btn-outline-gold btn-sm btn-icon" title="Ubah">
                <i class="bi bi-pencil"></i>
              </a>
              <form action="${item.del_url}" method="POST" onsubmit="return confirm('Hapus undangan ini?')" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-outline-gold btn-sm btn-icon" title="Hapus">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>`;
    }).join('');
    tbody.innerHTML = rows || `<tr><td colspan="3" class="text-center py-4 text-muted">Tidak ada hasil</td></tr>`;
  }

  function escapeHtml(str){
    return (str ?? '').toString()
      .replace(/&/g,'&amp;').replace(/</g,'&lt;')
      .replace(/>/g,'&gt;').replace(/"/g,'&quot;')
      .replace(/'/g,'&#39;');
  }
})();
</script>
@endpush

@endsection
