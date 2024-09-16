@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Reimburse')
@section('content_header_subtitle', 'Daftar Reimburse')

{{-- Content body: main page content --}}
@php
    $heads = [
        'NO',
        'Kode',
        'Judul',
        'Kategori',
        'Proyek',
        'Jumlah',
        'Status',
        'HR',
        'Finance',
        'Bukti Pembayaran',
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
                    <h3 class="card-title">Daftar Reimburse</h3>
                    @can('create', \App\Models\Reimburse::class)
                    <a href="{{ route('reimburse.create') }}" class="float-right btn btn-primary"><i class="fa fa-plus"></i></a>
                    @endcan
                </div>
                <div class="card-body">
                    @can('create', \App\Models\Reimburse::class)
                    <a href="{{ route('reimburse.report') }}" class="float-left mb-5 btn btn-success"><i class="fa fa-print"></i> Laporan</a>
                    @endcan
                    {{-- Minimal example / fill data using the component slot --}}
                    <x-adminlte-datatable id="table1" :heads="$heads">
                        @foreach($reimburses as $reimburse)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $reimburse->kode_reimburse }}</td>
                                <td>{{ $reimburse->title }}</td>
                                <td>{{ @$reimburse->kategori->name }}</td>
                                <td>{{ @$reimburse->proyek->name }}</td>
                                <td>{{ $reimburse->jumlah_total }}</td>
                                <td>{{ $reimburse->status_staff }}</td>
                                <td>{{ $reimburse->status_hr }}</td>
                                <td>{{ $reimburse->status_finance }}</td>
                                <td>
                                    @if($reimburse->transfer_proof !== null)
                                        <a target="_blank" href="{{ \Illuminate\Support\Facades\Storage::url($reimburse->transfer_proof) }}">
                                            <i class="fas fas-file"></i> Download File
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('reimburse.show', $reimburse->kode_reimburse) }} " class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                        <i class="fa fa-lg fa-fw fa-eye"></i>
                                    </a>
                                    @can('edit', $reimburse)
                                    <a href="{{ route('reimburse.edit', $reimburse) }} " class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                        <i class="fa fa-lg fa-fw fa-pen"></i>
                                    </a>
                                    @endcan
                                    @can('sendReimburse', $reimburse)
                                        <form action="{{ route('reimburse.send', $reimburse) }}" method="POST" >
                                            @csrf
                                            <button type="submit" class="btn btn-xs btn-default text-success mx-1 shadow" onclick="return confirm ('Yakin akan mengirim reimburse? informasi tidak bisa diubah setelah dikirim.')" title="Send">
                                                <i class="fa fa-lg fa-fw fa-paper-plane"></i>
                                            </button>
                                        </form>
                                    @endcan
                                    @can('hrAccept', $reimburse)
                                        <form action="{{ route('reimburse.hr-accept', $reimburse) }}" method="POST" >
                                            @csrf
                                            <button type="submit" class="btn btn-xs btn-default text-success mx-1 shadow" onclick="return confirm ('Yakin akan menyetujui reimburse dan kirim ke finance?')" title="Send">
                                                <i class="fa fa-lg fa-fw fa-check-circle"></i>
                                            </button>
                                        </form>
                                    @endcan
                                    @can('hrReject', $reimburse)
                                        <form action="{{ route('reimburse.hr-reject', $reimburse) }}" method="POST" >
                                            @csrf
                                            <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" onclick="return confirm ('Yakin akan menolak reimburse dan kirim kembali ke karyawan?')" title="Send">
                                                <i class="fa fa-lg fa-fw fa-times-circle"></i>
                                            </button>
                                        </form>
                                    @endcan
                                    @can('financeAccept', $reimburse)
                                        <form action="{{ route('reimburse.finance-accept', $reimburse) }}" method="POST" >
                                            @csrf
                                            <button type="submit" class="btn btn-xs btn-default text-success mx-1 shadow" onclick="return confirm ('Yakin akan menyetujui reimburse?')" title="Send">
                                                <i class="fa fa-lg fa-fw fa-check-circle"></i>
                                            </button>
                                        </form>
                                    @endcan
                                    @can('financeReject', $reimburse)
                                        <form action="{{ route('reimburse.finance-reject', $reimburse) }}" method="POST" >
                                            @csrf
                                            <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" onclick="return confirm ('Yakin akan menolak reimburse dan kirim kembali ke karyawan?')" title="Send">
                                                <i class="fa fa-lg fa-fw fa-times-circle"></i>
                                            </button>
                                        </form>
                                    @endcan
                                    @can('financeFinish', $reimburse)
                                        <a href="{{ route('reimburse.upload-proof', $reimburse) }}" class="btn btn-xs btn-default text-blue mx-1 shadow" title="Upload Bukti">
                                            <i class="fa fa-lg fa-fw fa-file-alt"></i>
                                        </a>
                                    @endcan
                                    @can('delete', $reimburse)
                                        <form action="{{ route('reimburse.destroy', $reimburse) }}" method="POST" >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" onclick="return confirm ('Yakin akan menghapus data?')" title="Delete">
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
