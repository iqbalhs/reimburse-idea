@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Reimburse')
@section('content_header_subtitle', $reimburse->title)

@php
    $heads = [
        'No',
        'Judul',
        'Berkas',
        'Jumlah',
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
                    <h3 class="card-title">Reimburse - {{ $reimburse->kode_reimburse }}</h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('reimburse.index') }}" class="btn btn-warning mb-1">Kembali</a>
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th>Kode</th>
                            <td> {{ $reimburse->kode_reimburse }} </td>
                        </tr>
                        <tr>
                            <th>Proyek</th>
                            <td> {{ $reimburse->proyek->name }} </td>
                        </tr>
                        <tr>
                            <th>Ketegori</th>
                            <td> {{ $reimburse->kategori->name }} </td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td> {{ $reimburse->date }} </td>
                        </tr>
                        <tr>
                            <th>Judul</th>
                            <td> {{ $reimburse->title }} </td>
                        </tr>

                        <tr>
                            <th>Jumlah</th>
                            <td> {{ Number::format($reimburse->jumlah_total) }} </td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td> {{ $reimburse->remark }} </td>
                        </tr>
                        <tr>
                            <th>Status Staff</th>
                            <td> {{ $reimburse->status_staff }} </td>
                        </tr>
                        <tr>
                            <th>Status HR</th>
                            <td> {{ $reimburse->status_hr }} </td>
                        </tr>
                        <tr>
                            <th>Status Finance</th>
                            <td> {{ $reimburse->status_finance }} </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Berkas</h3>
                    @can('sendReimburse', $reimburse)
                    <a href="{{ route('reimburse-detail.create', $reimburse) }}" class="float-right btn btn-primary"><i class="fa fa-plus"></i></a>
                    @endcan
                </div>
                <div class="card-body">
                    {{-- Minimal example / fill data using the component slot --}}
                    <x-adminlte-datatable id="table1" :heads="$heads">
                        @foreach($reimburse->reimburseDetail as $detail)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $detail->title }}</td>
                                <td>
                                    @if($detail->isImage())
                                        <a href="{{ \Illuminate\Support\Facades\Storage::url($detail->file_path) }}" target="_blank">
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($detail->file_path) }}"
                                                 class="img-md">
                                        </a>
                                    @else
                                        <a target="_blank" href="{{ \Illuminate\Support\Facades\Storage::url($detail->file_path) }}">
                                            <i class="fas fas-file"></i> Download File
                                        </a>
                                    @endif
                                <td>{{ Number::format($detail->jumlah) }}</td>
                                <td>
                                    @can('sendReimburse', $reimburse)
                                    <a href="{{ route('reimburse-detail.edit', $detail->id_reimburse_detail) }} " class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                        <i class="fa fa-lg fa-fw fa-pen"></i>
                                    </a>
                                    <form action="{{ route('reimburse-detail.destroy', $detail->id_reimburse_detail) }}" method="POST" >
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Yakin akan hapus data?')" type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                                            <i class="fa fa-lg fa-fw fa-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </div>
            </div>
        </div>
    </div>
@stop
