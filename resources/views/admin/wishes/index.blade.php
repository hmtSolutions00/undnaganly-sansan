@extends('layouts.admin')

@section('title','Ucapan • Admin')

@push('styles')
<style>
  .table-tight th, .table-tight td { padding:.5rem .5rem; }
  .table-tight thead th { text-align:center; }
  .col-preview { min-width: 220px; }
  .col-actions { width: 80px; text-align: right; white-space: nowrap; }
  .preview-text { font-size:.9rem; color:#4b4b4b; }
  .badge-xs { font-size:.75rem; padding:.35em .65em; border-radius:.5rem; }
  .pagination { gap:.25rem; }
  .page-item .page-link { padding:.35rem .6rem; line-height:1.2; }
  .btn-icon { padding:.25rem .45rem; }
  .btn-icon i { font-size:1rem; line-height:1; }
</style>
@endpush

@php
  use Illuminate\Pagination\LengthAwarePaginator;

  // fallback nilai jika variabel belum dikirim controller
  $q = $q ?? request('q','');

  // fallback paginator kosong agar view tetap aman
  if (!isset($wishes)) {
    $wishes = new LengthAwarePaginator(collect(), 0, 10, 1, [
      'path' => request()->url(),
      'query'=> request()->query(),
    ]);
  }
@endphp

@section('content')
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="page-title m-0">Ucapan</h1>
  </div>

  {{-- Live Search (berdasarkan nama undangan) --}}
  <form method="GET" class="mb-3" onsubmit="return false;">
    <div class="row g-2 align-items-end">
      <div class="col-12 col-sm">
        <div class="input-group">
          <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
          <input type="text" name="q" id="liveSearchWishes" value="{{ $q }}" class="form-control"
                 placeholder="Cari berdasarkan nama undangan...">
        </div>
        <small id="liveHintWishes" class="text-muted d-block mt-1">Ketik untuk pencarian langsung…</small>
      </div>
      <div class="col-6 col-sm-2 d-grid">
        <a href="{{ route('admin.wishes.index') }}" class="btn btn-outline-gold">Reset</a>
      </div>
    </div>
  </form>

  @if($wishes->isEmpty())
    <div class="card empty-state">
      <div class="card-body text-center py-5">
        <i class="bi bi-chat-left-heart display-5 d-block mb-3 text-gold"></i>
        <h5 class="mb-2">Belum ada ucapan</h5>
        <p class="text-muted mb-0">Ucapan tamu akan muncul di sini setelah mereka mengisi.</p>
      </div>
    </div>
  @else
    <div class="rounded-3 shadow-sm">
      <table class="table table-hover table-sm align-middle m-0 table-tight">
        <thead class="table-gold">
          <tr>
            <th>Nama Undangan</th>
            <th>Pengucap</th>
            <th class="col-preview">Ucapan</th>
            <th class="col-actions">Aksi</th>
          </tr>
        </thead>
        <tbody class="table-group-divider" id="wishesTableBody">
          @foreach($wishes as $w)
            @php
              $full    = trim((string) $w->message);
              $words   = str_word_count(strip_tags($full));
              $short   = \Illuminate\Support\Str::words(strip_tags($full), 50, '…');
              $tooLong = $words > 50;
            @endphp
            <tr>
              <td class="fw-medium">{{ optional($w->invitation)->invitee_name ?? '(tanpa undangan)' }}</td>
              <td>{{ $w->name }}</td>
              <td><div class="preview-text">{{ $short }}</div></td>
              <td class="text-end">
                @if($tooLong)
                  <button type="button"
                          class="btn btn-outline-gold btn-sm btn-icon"
                          data-bs-toggle="modal"
                          data-bs-target="#wishModal"
                          data-invitee="{{ optional($w->invitation)->invitee_name ?? '(tanpa undangan)' }}"
                          data-wisher="{{ $w->name }}"
                          data-message="{{ e($full) }}">
                    <i class="bi bi-eye"></i>
                  </button>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-3 d-flex justify-content-center" id="paginationWrapWishes">
      {{ $wishes->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>
  @endif

  {{-- Modal Detail Ucapan --}}
  <div class="modal fade" id="wishModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border-radius:16px">
        <div class="modal-header">
          <h5 class="modal-title">Detail Ucapan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-2"><small class="text-muted">Nama Undangan</small><div id="mdInvitee" class="fw-semibold"></div></div>
          <div class="mb-2"><small class="text-muted">Pengucap</small><div id="mdWisher" class="fw-semibold"></div></div>
          <div class="mb-2"><small class="text-muted">Ucapan</small><div id="mdMessage" style="white-space:pre-wrap"></div></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-gold" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
(function(){
  const input   = document.getElementById('liveSearchWishes');
  const tbody   = document.getElementById('wishesTableBody');
  const pager   = document.getElementById('paginationWrapWishes');
  const hint    = document.getElementById('liveHintWishes');
  const LIVE_URL= @json(route('admin.wishes.live'));

  // Modal handlers
  const modalEl = document.getElementById('wishModal');
  if (modalEl) {
    modalEl.addEventListener('show.bs.modal', function (event) {
      const btn = event.relatedTarget;
      if (!btn) return;
      document.getElementById('mdInvitee').textContent = btn.getAttribute('data-invitee') || '';
      document.getElementById('mdWisher').textContent  = btn.getAttribute('data-wisher') || '';
      document.getElementById('mdMessage').textContent = btn.getAttribute('data-message') || '';
    });
  }

  // Debounce live search
  let t = null;
  function schedule() {
    clearTimeout(t);
    const q = (input.value || '').trim();

    if (!q) {
      pager?.classList.remove('d-none');
      hint && (hint.textContent = 'Ketik untuk pencarian langsung…');
      return;
    }
    pager?.classList.add('d-none');
    hint && (hint.textContent = 'Mencari…');
    t = setTimeout(()=>runLive(q), 250);
  }

  input.addEventListener('input', schedule);

  async function runLive(q) {
    try{
      const url = new URL(LIVE_URL, window.location.origin);
      if (q) url.searchParams.set('q', q);
      const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }});
      const data = await res.json();
      render(data.items || []);
      hint && (hint.textContent = (data.items && data.items.length) ? `Menampilkan ${data.items.length} hasil` : 'Tidak ada hasil');
    }catch(e){
      console.error(e);
      hint && (hint.textContent = 'Gagal memuat hasil');
    }
  }

  function render(items){
    const rows = items.map(it => {
      const eye = it.too_long ? `
        <button type="button"
                class="btn btn-outline-gold btn-sm btn-icon"
                data-bs-toggle="modal"
                data-bs-target="#wishModal"
                data-invitee="${escapeHtml(it.invitee_name)}"
                data-wisher="${escapeHtml(it.wisher_name)}"
                data-message="${escapeHtml(it.full)}">
          <i class="bi bi-eye"></i>
        </button>` : '';

      return `
        <tr>
          <td class="fw-medium">${escapeHtml(it.invitee_name)}</td>
          <td>${escapeHtml(it.wisher_name)}</td>
          <td><div class="preview-text">${escapeHtml(it.preview)}</div></td>
          <td class="text-end">${eye}</td>
        </tr>`;
    }).join('');

    tbody.innerHTML = rows || `<tr><td colspan="4" class="text-center py-4 text-muted">Tidak ada ucapan</td></tr>`;
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
