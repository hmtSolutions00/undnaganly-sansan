@extends('layouts.admin')

@section('title', 'Buat Undangan • Admin')

@push('styles')
<style>
  .form-card{ background:#fff;border-radius:16px;border:1px solid rgba(0,0,0,.06); box-shadow:0 10px 30px rgba(0,0,0,.06); }
  .back-link{ display:inline-flex;align-items:center;gap:.4rem;text-decoration:none;color:var(--ink); }
  .share-preview{ background:#fffef9;border:1px dashed rgba(212,175,55,.6); border-radius:12px; }
  .slug-hint{font-size:.78rem;color:#7A6F61}
  .fake-input{ background:#fff;border:1px solid rgba(0,0,0,.08); padding:.65rem .8rem;border-radius:10px;font-family:ui-monospace,Menlo,Consolas,monospace;overflow:auto; }
  .btn[disabled]{ opacity:.6; cursor:not-allowed; }
</style>
@endpush

@section('content')

  {{-- Top bar back --}}
  <div class="d-flex align-items-center justify-content-between mb-3">
    <a href="{{ route('admin.invitations.index') }}" class="back-link">
      <i class="bi bi-arrow-left-short" style="font-size:1.35rem"></i>
      <span>Kembali</span>
    </a>
    <strong class="text-gold">Buat Undangan</strong>
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
    $baseDomain = rtrim(config('app.invite_base_domain', env('INVITE_BASE_DOMAIN','https://andre-yohani.undanganly.com')), '/');
    // flag dari server: apakah baru saja tersimpan?
    $createdSlug = session('created_slug');
    $createdName = session('created_name');
    $isSaved = filled($createdSlug);
  @endphp

  <div class="form-card p-3 p-sm-4">
    <form method="POST" action="{{ route('admin.invitations.store') }}" id="createForm" novalidate>
      @csrf
      <div class="mb-3">
        <label class="form-label fw-semibold">Nama yang diundang</label>
        <input type="text" class="form-control form-control-lg" name="invitee_name" id="invitee_name"
               placeholder="Contoh: Bapak/Ibu Andi & Keluarga"
               value="{{ old('invitee_name', $createdName) }}" required>
      </div>

      <div class="mb-2">
        <label class="form-label fw-semibold">Slug</label>
        <input type="text" class="form-control" name="slug" id="slug"
               placeholder="Akan diisi otomatis dari nama"
               value="{{ old('slug', $createdSlug) }}">
        <div class="slug-hint mt-1">
          Hanya huruf kecil, angka, dan strip (-). Bisa diubah manual.
        </div>
      </div>

      {{-- Share Preview (live) --}}
      <div class="share-preview p-3 p-sm-4 mt-3" id="shareBlock" style="display:none;">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h6 class="m-0">Tautan Undangan</h6>
          <span class="badge bg-warning-subtle text-dark">Preview</span>
        </div>

        <div class="fake-input small mb-3" id="previewLink">{{ $baseDomain }}/-</div>

        <div class="row g-2">
          <div class="col-12 col-sm-6">
            <button class="btn btn-outline-gold w-100" type="button" id="btnCopy" {{ $isSaved ? '' : 'disabled' }}>
              <i class="bi bi-clipboard me-1"></i> Salin Tautan
            </button>
          </div>
          <div class="col-12 col-sm-6">
            <a class="btn btn-gold w-100 {{ $isSaved ? '' : 'disabled' }}" id="btnWa" href="#" target="_blank" rel="noopener"
               aria-disabled="{{ $isSaved ? 'false' : 'true' }}">
              <i class="bi bi-whatsapp me-1"></i> Share WhatsApp
            </a>
          </div>
        </div>

        <div class="mt-3">
          <label class="form-label fw-semibold">Pesan WhatsApp</label>
          <textarea class="form-control" id="waMessage" rows="3" placeholder="[MASUKKAN PESAN ANDA TERLBIH DAHULU]">[MASUKKAN PESAN ANDA TERLBIH DAHULU]</textarea>
          <div class="form-text">
            @if(!$isSaved)
              Simpan undangan terlebih dahulu untuk mengaktifkan tombol salin & WhatsApp.
            @else
              Pesan akan dikirim bersama tautan di atas.
            @endif
          </div>
        </div>
      </div>

      <div class="d-grid mt-4">
        <button type="submit" class="btn btn-gold btn-lg">
          <i class="bi bi-check2-circle me-1"></i> Simpan Undangan
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
  const HARDCODED_PHONE = '6281234567890'; // ganti sesuai kebutuhan
  const IS_SAVED        = @json($isSaved);  // true jika barusan disimpan (ada flash)
  // ===================================

  const nameInput  = document.getElementById('invitee_name');
  const slugInput  = document.getElementById('slug');
  const shareBlock = document.getElementById('shareBlock');
  const previewLink= document.getElementById('previewLink');
  const btnCopy    = document.getElementById('btnCopy');
  const btnWa      = document.getElementById('btnWa');
  const waMessage  = document.getElementById('waMessage');

  // Slugify sederhana
  function slugify(str){
    return (str || '')
      .toString()
      .normalize('NFD').replace(/[\u0300-\u036f]/g,'')
      .toLowerCase()
      .replace(/[^a-z0-9\s-]/g,'')
      .trim()
      .replace(/\s+/g,'-')
      .replace(/-+/g,'-');
  }

  function buildShareUrl(){
    const slug = (slugInput.value || '').trim();
    return BASE_DOMAIN + '/' + (slug || '-');
  }

  function refreshPreview(){
    const hasName = (nameInput.value || '').trim().length > 0;
    shareBlock.style.display = hasName ? '' : 'none';
    previewLink.textContent = buildShareUrl();
    updateWaHref();
  }

  function updateWaHref(){
    const msg = (waMessage.value || '').trim();
    const link = buildShareUrl();
    const finalMsg = msg.length ? (msg + '\n' + link) : link;
    const encoded = encodeURIComponent(finalMsg);
    const hrefWithPhone = `https://wa.me/${HARDCODED_PHONE}?text=${encoded}`;
    const hrefPicker    = `https://wa.me/?text=${encoded}`;

    // default: direct ke nomor tertentu
    btnWa.setAttribute('href', hrefWithPhone);
    // kalau mau share tanpa nomor: gunakan hrefPicker
    // btnWa.setAttribute('href', hrefPicker);
  }

  // Kunci tombol sampai tersimpan
  function setButtonsEnabled(enabled){
    if(btnCopy){
      btnCopy.disabled = !enabled;
    }
    if(btnWa){
      if(enabled){
        btnWa.classList.remove('disabled');
        btnWa.setAttribute('aria-disabled','false');
      }else{
        btnWa.classList.add('disabled');
        btnWa.setAttribute('aria-disabled','true');
        btnWa.setAttribute('href', '#'); // cegah klik
      }
    }
  }

  // Auto slug—hanya kalau user belum mengedit slug manual
  let userEditedSlug = false;
  slugInput.addEventListener('input', () => {
    userEditedSlug = true;
    refreshPreview();
  });

  nameInput.addEventListener('input', () => {
    if(!userEditedSlug || !slugInput.value){
      slugInput.value = slugify(nameInput.value);
    }
    refreshPreview();
    // Saat mengetik (belum tersimpan), tombol tetap disabled:
    if(!IS_SAVED) setButtonsEnabled(false);
  });

  waMessage.addEventListener('input', updateWaHref);

  // Copy
  if(btnCopy){
    btnCopy.addEventListener('click', () => {
      if(btnCopy.disabled) return;
      const text = buildShareUrl();
      navigator.clipboard.writeText(text).then(() => toast('Tautan disalin'))
      .catch(() => {
        const ta = document.createElement('textarea');
        ta.value = text; document.body.appendChild(ta);
        ta.select(); document.execCommand('copy'); ta.remove();
        toast('Tautan disalin');
      });
    });
  }

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

  // Inisialisasi
  // Jika barusan disimpan (flash session ada), tombol aktif; kalau tidak, disabled.
  setButtonsEnabled(IS_SAVED);
  refreshPreview();

})();
</script>
@endpush
