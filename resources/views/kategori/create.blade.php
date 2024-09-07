@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Kategori')
@section('content_header_subtitle', 'Tambah Kategori')

@section('content_body')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Kategori</h3>
                </div>
                <form method="POST" action="{{ route('kategori.store') }}">
                    <div class="card-body">
                            @csrf
                            <div class="form-group">
                                <label for="name">Kategori</label>
                                <input id="name"
                                   type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('kategori.index') }}" class="btn btn-warning">Kembali</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
