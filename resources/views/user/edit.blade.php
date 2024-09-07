@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Pegawai')
@section('content_header_subtitle', 'Edit')

@section('content_body')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Pegawai</h3>
                </div>
                <form method="POST" action="{{ route('user.update', $user) }}">
                    @method('PUT')
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input id="name"
                                   type="text"
                                   name="name"
                                   value="{{ $user->name }}"
                                   class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control @error('role') is-invalid @enderror"
                                    name="role">
                                <option {{ $user->getRoleName() === 'superadmin' ? 'selected': ''}} value="superadmin">Superadmin</option>
                                <option {{ $user->getRoleName() === 'finance' ? 'selected': ''}} value="finance">Finance</option>
                                <option {{ $user->getRoleName() === 'hr' ? 'selected': ''}} value="hr">HR</option>
                                <option {{ $user->getRoleName() === 'karyawan' ? 'selected': ''}} value="karyawan">Karyawan</option>
                            </select>
                            @error('role')
                            <span id="nip-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nip">NIP</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">IDEA-</span>
                                </div>
                                <input id="nip"
                                       type="text"
                                       name="nip"
                                       value="{{ preg_replace('/[^0-9]/', '', $user->nip) }}"
                                       placeholder="0001"
                                       class="input-group form-control @error('nip') is-invalid @enderror">
                                @error('nip')
                                <span id="nip-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email"
                                   type="email"
                                   name="email"
                                   value="{{ $user->email }}"
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                            <span id="email-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                    <a href="{{ route('user.index') }}" class="btn btn-warning">Kembali</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
