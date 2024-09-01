@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Reimburse')
@section('content_header_subtitle', 'Upload Bukti Transfer')

@section('content_body')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Kategori</h3>
                </div>
                <form method="POST" action="{{ route('reimburse.store-proof', $reimburse) }}" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label for="file">Berkas</label>
                            <input id="file"
                                   type="file"
                                   name="file"
                                   class="form-control @error('file') is-invalid @enderror">
                            @error('file')
                            <span id="file-error" class="error invalid-feedback">{{ $message }}</span>
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
