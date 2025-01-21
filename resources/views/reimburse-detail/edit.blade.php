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
                            <label for="category_id">Kategori</label>
                            <select class="form-control @error('category_id') is-invalid @enderror"
                                    name="category_id">
                                @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}" @if($category->id === $reimburseDetail->category_id) selected @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <span id="category_id-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input id="jumlah"
                                   type="text"
                                   name="jumlah"
                                   data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digitsOptional': true, 'placeholder': '0', 'removeMaskOnSubmit': true, 'rightAlign': false"
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
