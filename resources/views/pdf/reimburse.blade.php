<h1><b>Laporan Reimburse</b></h1><br><br>


<table>
    <tr>
        <th>NO</th>
        <th>Kode</th>
        <th>Judul</th>
        <th>Kategori</th>
        <th>Proyek</th>
        <th>Jumlah</th>
        <th>Status</th>
        <th>HR</th>
        <th>Finance</th>
    </tr>
    @php($i = 1)
    @foreach($reimburses as $reimburse)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $reimburse->kode_reimburse }}</td>
            <td>{{ $reimburse->title }}</td>
            <td>{{ $reimburse->kategori->name }}</td>
            <td>{{ $reimburse->proyek->name }}</td>
            <td>{{ $reimburse->jumlah_total }}</td>
            <td>{{ $reimburse->status_staff }}</td>
            <td>{{ $reimburse->status_hr }}</td>
            <td>{{ $reimburse->status_finance }}</td>
        </tr>
    @endforeach
</table>
