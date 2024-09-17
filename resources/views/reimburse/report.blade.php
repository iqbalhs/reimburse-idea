@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Reimburse')
@section('content_header_subtitle', 'Laporan')

@section('content_body')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Export Laporan</h3>
                </div>
                <form method="POST" action="{{ route('reimburse.report') }}">
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label for="project_id">Proyek</label>
                            <select class="form-control @error('project_id') is-invalid @enderror"
                                    name="project_id">
                                <option value="">- Semua -</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->proyek_id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                            @error('project_id')
                            <span id="project_id-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category_id">Kategori</label>
                            <select class="form-control @error('category_id') is-invalid @enderror"
                                    name="category_id">
                                <option value="">- Semua -</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <span id="category_id-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai</label>
                            <input id="start_date"
                                   type="date"
                                   name="start_date"
                                   class="form-control @error('start_date') is-invalid @enderror">
                            @error('start_date')
                            <span id="date-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="end_date">Tanggal Akhir</label>
                            <input id="end_date"
                                   type="date"
                                   name="end_date"
                                   class="form-control @error('end_date') is-invalid @enderror">
                            @error('end_date')
                            <span id="date-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="format">Format</label>
                            <select class="form-control @error('format') is-invalid @enderror"
                                    name="format">
                                <option value="Excel">Excel</option>
                                <option value="PDF">PDF</option>
                            </select>
                            @error('format')
                            <span id="format-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('reimburse.index') }}" class="btn btn-warning">Kembali</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
