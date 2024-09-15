@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Reimburse Detail')
@section('content_header_subtitle', $reimburse->title)

@section('content_body')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Detail Reimburse</h3>
                </div>
                <form method="POST" enctype="multipart/form-data" action="{{ route('reimburse-detail.store', $reimburse->kode_reimburse) }}">
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input id="title"
                                   type="text"
                                   name="title"
                                   class="form-control @error('title') is-invalid @enderror">
                            @error('title')
                            <span id="title-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input id="jumlah"
                                   type="text"
                                   name="jumlah"
                                   data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digitsOptional': true, 'placeholder': '0', 'removeMaskOnSubmit': true"
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
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('reimburse.show', $reimburse->kode_reimburse) }}" class="btn btn-warning">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
@push('js-user')
    <script>
        $('#jumlah').inputmask()
    </script>
@endpush
