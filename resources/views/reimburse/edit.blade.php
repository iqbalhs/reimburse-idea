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
                    <h3 class="card-title">Tambah Reimburse</h3>
                </div>
                <form method="POST" action="{{ route('reimburse.update', $reimburse) }}">
                    <div class="card-body">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input id="title"
                                   type="text"
                                   name="title"
                                   value="{{ $reimburse->title }}"
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
                                    <option value="{{ $project->project_id }}" @if($project->id === $reimburse->project_id) selected @endif>{{ $project->name }}</option>
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
                                    <option value="{{ $category->category_id }}" @if($category->id === $reimburse->category_id) selected @endif>{{ $category->name }}</option>
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
                                   value="{{ $reimburse->date }}"
                                   class="form-control @error('date') is-invalid @enderror">
                            @error('date')
                            <span id="date-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="remark">Keterangan</label>
                            <textarea class="form-control @error('remark') is-invalid @enderror" name="remark" id="" cols="30" rows="4">{{ $reimburse->remark }}</textarea>
                            @error('remark')
                            <span id="remark-error" class="error invalid-feedback">{{ $message }}</span>
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
