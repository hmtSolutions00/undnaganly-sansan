<nav class="app-bottom-nav shadow-lg">
  <div class="container d-flex justify-content-between">
    <a href="{{ route('admin.invitations.index') }}"
       class="nav-item {{ request()->routeIs('admin.invitations.*') ? 'active' : '' }}">
      <i class="bi bi-card-list"></i>
      <span>Undangan</span>
    </a>

    <a href="{{ route('admin.rsvp.index') }}"
       class="nav-item {{ request()->routeIs('admin.rsvp.*') ? 'active' : '' }}">
      <i class="bi bi-person-check"></i>
      <span>Kehadiran</span>
    </a>

    <a href="{{ route('admin.wishes.index') }}"
       class="nav-item {{ request()->routeIs('admin.wishes.*') ? 'active' : '' }}">
      <i class="bi bi-chat-left-heart"></i>
      <span>Ucapan</span>
    </a>

    {{-- Akun: buka modal logout, tidak redirect ke halaman --}}
    <a href="#"
       class="nav-item"
       data-bs-toggle="modal"
       data-bs-target="#logoutModal"
       onclick="event.preventDefault();">
      <i class="bi bi-person-circle"></i>
      <span>Akun</span>
    </a>
  </div>
</nav>

{{-- Modal Logout Admin --}}
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-3">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="logoutModalLabel">Logout Admin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <p class="mb-0">
          Anda yakin ingin keluar dari halaman admin?
        </p>
      </div>

      <div class="modal-footer border-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          Batal
        </button>

        <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
          @csrf
          <button type="submit" class="btn btn-danger">
            <i class="bi bi-box-arrow-right me-1"></i> Logout
          </button>
        </form>
      </div>
    </div>
  </div>
</div>