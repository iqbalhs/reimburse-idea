@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Proyek')
@section('content_header_subtitle', 'Tambah')

@section('content_body')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Proyek</h3>
                </div>
                <form method="POST" action="{{ route('proyek.store') }}">
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label for="name">Proyek</label>
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
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
