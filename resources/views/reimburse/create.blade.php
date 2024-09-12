@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Reimburse')
@section('content_header_subtitle', 'Tambah Reimburse')

@section('content_body')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Reimburse</h3>
                </div>
                <form method="POST" action="{{ route('reimburse.store') }}">
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
                            <label for="project_id">Proyek</label>
                            <select class="form-control @error('project_id') is-invalid @enderror"
                                    name="project_id">
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
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
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <span id="category_id-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="date">Tanggal</label>
                            <input id="date"
                                   type="date"
                                   name="date"
                                   class="form-control @error('date') is-invalid @enderror">
                            @error('date')
                            <span id="date-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="remark">Keterangan</label>
                            <textarea class="form-control @error('remark') is-invalid @enderror" name="remark" id="" cols="30" rows="4"></textarea>
                            @error('remark')
                            <span id="remark-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="/reimburse" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
