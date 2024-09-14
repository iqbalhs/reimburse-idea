@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Reimburse')
@section('content_header_subtitle', $reimburseDetail->title)

@section('content_body')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Detail Reimburse</h3>
                </div>
                <form method="POST" enctype="multipart/form-data" action="{{ route('reimburse-detail.edit', $reimburseDetail->id_reimburse_detail) }}">
                    <div class="card-body">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input id="title"
                                   type="text"
                                   name="title"
                                   value="{{ $reimburseDetail->title }}"
                                   class="form-control @error('title') is-invalid @enderror">
                            @error('title')
                            <span id="title-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input id="jumlah"
                                   type="number"
                                   name="jumlah"
                                   value="{{ $reimburseDetail->jumlah }}"
                                   class="form-control @error('jumlah') is-invalid @enderror">
                            @error('jumlah')
                            <span id="jumlah-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="file">Berkas</label>
                            <input id="file"
                                   type="file"
                                   name="file"
                                   class="form-control @error('file') is-invalid @enderror">
                            @error('file')
                            <span id="file-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                            <span class="error invalid-feedback">Biarkan kosong jika tidak update file</span>
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
