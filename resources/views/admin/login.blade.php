@extends('layouts.admin')

@section('title', 'Login Admin')

@push('styles')
<style>
  .login-card{
      max-width:420px;
      margin:40px auto;
      border-radius:16px;
      border:1px solid rgba(0,0,0,.06);
      box-shadow:0 10px 30px rgba(0,0,0,.08);
      background:#fff;
  }
</style>
@endpush

@section('content')
  <div class="login-card p-4 p-sm-4">
      <h4 class="mb-3 text-center">Login Admin</h4>

      @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      @if(session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      @if ($errors->any())
          <div class="alert alert-danger">
              <ul class="mb-0 ps-3">
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

      <form method="POST" action="{{ route('admin.login.submit') }}">
          @csrf

          <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text"
                     name="username"
                     class="form-control @error('username') is-invalid @enderror"
                     value="{{ old('username') }}"
                     placeholder="Masukkan username admin">
              @error('username')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>

          <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password"
                     name="password"
                     class="form-control @error('password') is-invalid @enderror"
                     placeholder="Password admin">
              @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>

          <div class="d-grid">
              <button type="submit" class="btn btn-gold">
                  <i class="bi bi-box-arrow-in-right me-1"></i> Login
              </button>
          </div>
      </form>
  </div>
@endsection
