@extends('layouts.admin')

@section('title', 'Ubah Undangan • Admin')

@push('styles')
<style>
  .form-card{ background:#fff;border-radius:16px;border:1px solid rgba(0,0,0,.06); box-shadow:0 10px 30px rgba(0,0,0,.06); }
  .back-link{ display:inline-flex;align-items:center;gap:.4rem;text-decoration:none;color:var(--ink); }
  .share-preview{ background:#fffef9;border:1px dashed rgba(212,175,55,.6); border-radius:12px; }
  .fake-input{ background:#fff;border:1px solid rgba(0,0,0,.08); padding:.65rem .8rem;border-radius:10px;font-family:ui-monospace,Menlo,Consolas,monospace;overflow:auto; }
  .form-switch .form-check-input{ width:2.25em; height:1.15em; }
  .form-switch .form-check-label{ user-select:none; }
</style>
@endpush

@section('content')

  {{-- Top bar back --}}
  <div class="d-flex align-items-center justify-content-between mb-3">
    <a href="{{ route('admin.invitations.index') }}" class="back-link">
      <i class="bi bi-arrow-left-short" style="font-size:1.35rem"></i>
      <span>Kembali</span>
    </a>
    <strong class="text-gold">Ubah Undangan</strong>
  </div>

  {{-- Alert sukses / error --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger">
      <div class="fw-semibold mb-1">Periksa input Anda:</div>
      <ul class="m-0 ps-3">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @php
    $baseDomain = rtrim(config('app.invite_base_domain', env('INVITE_BASE_DOMAIN','https://andre-sansan.undanganly.com')), '/');
    $finalSlug  = $invitation->slug;           // slug tidak ditampilkan & tidak diubah otomatis
    $shareUrl   = $baseDomain . '/' . $finalSlug;
  @endphp

  <div class="form-card p-3 p-sm-4">
    <form method="POST" action="{{ route('admin.invitations.update', $invitation) }}" id="editForm" novalidate>
      @csrf
      @method('PUT')

      {{-- hidden slug supaya validasi controller (slug required) tetap terpenuhi --}}
      <input type="hidden" name="slug" value="{{ $finalSlug }}">

      <div class="mb-3">
        <label class="form-label fw-semibold">Nama yang diundang</label>
        <input type="text" class="form-control form-control-lg" name="invitee_name" id="invitee_name"
               placeholder="Contoh: Bapak/Ibu Andi & Keluarga"
               value="{{ old('invitee_name', $invitation->invitee_name) }}" required>
      </div>

      <div class="mb-3">
        <div class="form-check form-switch d-flex align-items-center gap-2">
          {{-- kirim 0 saat unchecked --}}
          <input type="hidden" name="is_opened" value="0">
          <input class="form-check-input" type="checkbox" role="switch" id="is_opened"
                 name="is_opened" value="1" {{ old('is_opened', $invitation->is_opened) ? 'checked' : '' }}>
          <label class="form-check-label" for="is_opened">
            <span class="me-1">Viewed:</span>
            <span id="viewedLabel">{{ old('is_opened', $invitation->is_opened) ? 'Yes' : 'No' }}</span>
          </label>
        </div>
        <div class="form-text">Tandai apakah undangan ini sudah dibuka.</div>
      </div>

      {{-- Share Preview (selalu tampil pada edit) --}}
      <div class="share-preview p-3 p-sm-4 mt-3" id="shareBlock">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h6 class="m-0">Tautan Undangan</h6>
          <span class="badge bg-warning-subtle text-dark">Live</span>
        </div>

        <div class="fake-input small mb-3" id="previewLink">{{ $shareUrl }}</div>

        <div class="row g-2">
          <div class="col-12 col-sm-6">
            <button class="btn btn-outline-gold w-100" type="button" id="btnCopy">
              <i class="bi bi-clipboard me-1"></i> Salin Tautan
            </button>
          </div>
          <div class="col-12 col-sm-6">
            <a class="btn btn-gold w-100" id="btnWa" href="#" target="_blank" rel="noopener">
              <i class="bi bi-whatsapp me-1"></i> Share WhatsApp
            </a>
          </div>
        </div>

        <div class="mt-3">
          <label class="form-label fw-semibold">Pesan WhatsApp</label>
          <textarea class="form-control" id="waMessage" rows="3" placeholder="[MASUKKAN PESAN ANDA TERLBIH DAHULU]">[MASUKKAN PESAN ANDA TERLBIH DAHULU]</textarea>
          <div class="form-text">Pesan akan dikirim bersama tautan di atas.</div>
        </div>
      </div>

      <div class="d-grid mt-4">
        <button type="submit" class="btn btn-gold btn-lg">
          <i class="bi bi-check2-circle me-1"></i> Simpan Perubahan
        </button>
      </div>
    </form>
  </div>

@endsection

@push('scripts')
<script>
(function(){
  // ====== KONFIGURASI HARDCODE ======
  const BASE_DOMAIN     = @json($baseDomain);
  const FINAL_SLUG      = @json($finalSlug);      // slug fix (hidden field)
  const HARDCODED_PHONE = '6281234567890';        // ubah sesuai kebutuhan
  // ===================================

  const previewLink = document.getElementById('previewLink');
  const btnCopy     = document.getElementById('btnCopy');
  const btnWa       = document.getElementById('btnWa');
  const waMessage   = document.getElementById('waMessage');
  const viewed      = document.getElementById('is_opened');
  const viewedLabel = document.getElementById('viewedLabel');

  const shareUrl = `${BASE_DOMAIN}/${FINAL_SLUG}`;
  previewLink.textContent = shareUrl;

  function updateWaHref(){
    const msg = (waMessage.value || '').trim();
    const finalMsg = msg.length ? (msg + '\n' + shareUrl) : shareUrl;
    const encoded = encodeURIComponent(finalMsg);
    btnWa.setAttribute('href', `https://wa.me/${HARDCODED_PHONE}?text=${encoded}`);
    // atau tanpa nomor tujuan:
    // btnWa.setAttribute('href', `https://wa.me/?text=${encoded}`);
  }

  // Copy link
  btnCopy.addEventListener('click', () => {
    navigator.clipboard.writeText(shareUrl).then(() => toast('Tautan disalin'))
    .catch(() => {
      const ta = document.createElement('textarea');
      ta.value = shareUrl; document.body.appendChild(ta);
      ta.select(); document.execCommand('copy'); ta.remove();
      toast('Tautan disalin');
    });
  });

  // Ubah label viewed
  viewed.addEventListener('change', () => {
    viewedLabel.textContent = viewed.checked ? 'Yes' : 'No';
  });

  function toast(msg){
    let el = document.getElementById('simple-toast');
    if(!el){
      el = document.createElement('div');
      el.id = 'simple-toast';
      el.style.position='fixed';
      el.style.left='50%';
      el.style.bottom='80px';
      el.style.transform='translateX(-50%)';
      el.style.background='#D4AF37';
      el.style.color='#111';
      el.style.padding='10px 14px';
      el.style.borderRadius='10px';
      el.style.boxShadow='0 8px 30px rgba(0,0,0,.15)';
      el.style.zIndex='2000';
      document.body.appendChild(el);
    }
    el.textContent = msg;
    el.style.opacity='1';
    setTimeout(()=>{ el.style.opacity='0'; }, 1600);
  }

  // init
  updateWaHref();
  waMessage.addEventListener('input', updateWaHref);
})();
</script>
@endpush
