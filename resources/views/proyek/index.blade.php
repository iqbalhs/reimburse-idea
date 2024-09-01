@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Proyek')
@section('content_header_subtitle', 'Daftar Proyek')

{{-- Content body: main page content --}}
@php
    $heads = [
        'ID',
        'Name',
        ['label' => 'Actions', 'no-export' => true, 'width' => 5],
    ];

    $btnEdit = '<a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                    <i class="fa fa-lg fa-fw fa-pen"></i>
                </a>';
    $btnDelete = '<a class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                      <i class="fa fa-lg fa-fw fa-trash"></i>
                  </a>';
    $btnDetails = '<a class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                       <i class="fa fa-lg fa-fw fa-eye"></i>
                   </a>';
@endphp
@section('content_body')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Proyek</h3>
                    <a href="{{ route('proyek.create') }}" class="float-right btn btn-primary"><i class="fa fa-plus"></i></a>
                </div>
                <div class="card-body">
                    {{-- Minimal example / fill data using the component slot --}}
                    <x-adminlte-datatable id="table1" :heads="$heads">
                        @foreach($proyeks as $proyek)
                            <tr>
                                <td>{{ $proyek->id }}</td>
                                <td>{{ $proyek->name }}</td>
                                <td>
                                    <a href="{{ route('proyek.edit', $proyek) }} " class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                        <i class="fa fa-lg fa-fw fa-pen"></i>
                                    </a>
                                    <form action="{{ route('proyek.destroy', $proyek) }}" method="POST" >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                                            <i class="fa fa-lg fa-fw fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </div>
            </div>
        </div>
    </div>
@stop
