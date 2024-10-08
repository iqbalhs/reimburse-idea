@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Pegawai')
@section('content_header_subtitle', 'Data Pegawai')

{{-- Content body: main page content --}}
@php
    $heads = [
        'No',
        'NIP',
        'Name',
        'Email',
        'Role',
        ['label' => 'Actions', 'no-export' => true, 'width' => 5],
    ];
@endphp
@section('content_body')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Daftar Pegawai</h2>
                    <a href="{{ route('user.create') }}" class="float-right btn btn-primary"><i class="fa fa-plus"></i></a>
                </div>
                <div class="card-body">
                    {{-- Minimal example / fill data using the component slot --}}
                    <x-adminlte-datatable id="table1" :heads="$heads">
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $user->nip }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->getRoleNames()->implode(',') }}</td>
                                <td>
                                    <a href="{{ route('user.edit', $user) }} " class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                        <i class="fa fa-lg fa-fw fa-pen"></i>
                                    </a>
                                    <form action="{{ route('user.destroy', $user) }}" method="POST" >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow"onclick="return confirm ('Yakin akan menghapus data?')" title="Delete">
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
