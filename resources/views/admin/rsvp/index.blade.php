@extends('layouts.admin')

@section('title','Kehadiran / RSVP • Admin')

@push('styles')
<style>
  .table-tight th, .table-tight td { padding: .5rem .5rem; }
  .table-tight thead th { text-align: center; }
  .col-status { width: 120px; text-align: center; }
  .badge-xs { font-size: .75rem; padding: .35em .65em; border-radius: .5rem; }
  .pagination { gap: .25rem; }
  .page-item .page-link { padding: .35rem .6rem; line-height: 1.2; }
</style>
@endpush
@php
  use Illuminate\Pagination\LengthAwarePaginator;
  use Illuminate\Support\Collection;

  // Fallback nilai form
  $q = $q ?? request('q', '');
  $status = $status ?? request('status', '');

  // Fallback paginator kosong jika $rsvps belum dikirim controller
  if (!isset($rsvps)) {
      $rsvps = new LengthAwarePaginator(
          collect(), // items kosong
          0,         // total
          10,        // per page
          1,         // current page
          ['path' => request()->url(), 'query' => request()->query()]
      );
  }
@endphp
@section('content')
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="page-title m-0">Kehadiran</h1>
  </div>

  {{-- Pencarian & filter --}}
<form method="GET" class="mb-3" onsubmit="return false;">
  <div class="row g-2 align-items-end">
    {{-- Input pencarian nama --}}
    <div class="col-12 col-sm">
      <div class="input-group">
        <span class="input-group-text bg-light">
          <i class="bi bi-search"></i>
        </span>
        <input type="text"
               name="q"
               id="liveSearchRsvp"
               value="{{ $q }}"
               class="form-control"
               placeholder="Cari nama tamu...">
      </div>
      <small id="liveHintRsvp" class="text-muted d-block mt-1">
        Ketik untuk pencarian langsung…
      </small>
    </div>

    {{-- Filter status kehadiran --}}
    <div class="col-6 col-sm-3">
      @php $currStatus = $status; @endphp
      <label for="statusFilter" class="form-label fw-semibold small mb-1">
        Status Kehadiran
      </label>
      <select name="status" id="statusFilter" class="form-select">
        <option value="" {{ $currStatus==='' ? 'selected' : '' }}>Semua status</option>
        <option value="hadir" {{ $currStatus==='hadir' ? 'selected' : '' }}>Hadir</option>
        <option value="tidak_hadir" {{ $currStatus==='tidak_hadir' ? 'selected' : '' }}>Tidak hadir</option>
      </select>
    </div>

    {{-- Tombol reset --}}
    <div class="col-6 col-sm-2 d-grid">
      <a href="{{ route('admin.rsvp.index') }}" class="btn btn-outline-gold">
        Reset
      </a>
    </div>
  </div>
</form>
  @if($rsvps->isEmpty())
    <div class="card empty-state">
      <div class="card-body text-center py-5">
        <i class="bi bi-people display-5 d-block mb-3 text-gold"></i>
        <h5 class="mb-2">Belum ada data kehadiran</h5>
        <p class="text-muted mb-0">RSVP akan muncul di sini saat tamu mengisi.</p>
      </div>
    </div>
  @else
    <div class="rounded-3 shadow-sm">
      <table class="table table-hover table-sm align-middle m-0 table-tight">
        <thead class="table-gold">
          <tr>
            <th>Nama Tamu</th>
            <th class="col-status">Status</th>
          </tr>
        </thead>
       <tbody class="table-group-divider" id="rsvpTableBody">
  @foreach($rsvps as $r)
    <tr>
      <td class="fw-medium">{{ $r->name }}</td>
      <td class="text-center">
        @if($r->status === 'hadir')
          <span class="badge bg-success-subtle text-success badge-xs">Hadir</span>
        @else
          <span class="badge bg-secondary-subtle text-secondary badge-xs">Tidak hadir</span>
        @endif
      </td>
    </tr>
  @endforeach
</tbody>
      </table>
    </div>

   <div class="mt-3 d-flex justify-content-center" id="paginationWrapRsvp">
  {{ $rsvps->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}
</div>

  @endif
  @push('scripts')
<script>
(function(){
  const input   = document.getElementById('liveSearchRsvp');
  const filter  = document.getElementById('statusFilter');
  const tbody   = document.getElementById('rsvpTableBody');
  const pager   = document.getElementById('paginationWrapRsvp');
  const hint    = document.getElementById('liveHintRsvp');

  const LIVE_URL = @json(route('admin.rsvp.live'));

  let timer = null;
  function scheduleSearch() {
    clearTimeout(timer);
    const q = (input.value || '').trim();
    const status = (filter.value || '').trim();

    // jika kosong semua, tampilkan kembali pagination server
    if (!q && !status) {
      pager?.classList.remove('d-none');
      hint && (hint.textContent = 'Ketik untuk pencarian langsung…');
      return;
    }
    pager?.classList.add('d-none');
    hint && (hint.textContent = 'Mencari…');
    timer = setTimeout(() => runLive(q, status), 250);
  }

  input.addEventListener('input', scheduleSearch);
  filter.addEventListener('change', scheduleSearch);

  async function runLive(q, status){
    try{
      const url = new URL(LIVE_URL, window.location.origin);
      if(q) url.searchParams.set('q', q);
      if(status) url.searchParams.set('status', status);
      const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }});
      const data = await res.json();
      renderRows(data.items || []);
      hint && (hint.textContent = (data.items && data.items.length) ? `Menampilkan ${data.items.length} hasil` : 'Tidak ada hasil');
    }catch(err){
      console.error(err);
      hint && (hint.textContent = 'Gagal memuat hasil');
    }
  }

  function renderRows(items){
    const rows = items.map(r => {
      const badge = (r.status === 'hadir')
        ? '<span class="badge bg-success-subtle text-success badge-xs">Hadir</span>'
        : '<span class="badge bg-secondary-subtle text-secondary badge-xs">Tidak hadir</span>';
      return `
        <tr>
          <td class="fw-medium">${escapeHtml(r.name)}</td>
          <td class="text-center">${badge}</td>
        </tr>`;
    }).join('');
    tbody.innerHTML = rows || `<tr><td colspan="2" class="text-center py-4 text-muted">Tidak ada hasil</td></tr>`;
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
