<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
use App\Enums\StatusFinance;
use App\Enums\StatusHr;
use App\Enums\StatusKaryawan;
use App\Models\Kategori;
use App\Models\Proyek;
use App\Models\Reimburse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Spatie\LaravelPdf\Facades\Pdf;

class ReimburseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reimburses = Reimburse::query();
        if (auth()->user()->hasRole(RolesEnum::HR)) {
            $reimburses->hrViewable();
        }
        if (auth()->user()->hasRole(RolesEnum::FINANCE)) {
            $reimburses->financeViewable();
        }
        return view('reimburse.index', [
            'reimburses' => $reimburses->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reimburse.create', [
            'projects' => Proyek::all(),
            'categories' => Kategori::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:50'],
            'project_id' => ['required', 'integer', 'exists:proyek,proyek_id'],
            'category_id' => ['required', 'integer', 'exists:kategori,category_id'],
            'date' => ['required', 'date'],
            'remark' => ['required', 'string', 'max:500'],
        ]);
        $reimburse = new Reimburse();
        $reimburse->fill($request->all());
        $reimburse->nip = auth()->user()->nip;
        $reimburse->generateKode();
        $reimburse->save();
        return redirect()->route('reimburse.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reimburse $reimburse)
    {
        return view('reimburse.show', ['reimburse' => $reimburse]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reimburse $reimburse)
    {
        return view('reimburse.edit', [
            'reimburse' => $reimburse,
            'projects' => Proyek::all(),
            'categories' => Kategori::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reimburse $reimburse)
    {
        $request->validate([
            'title' => ['required', 'max:50'],
            'project_id' => ['required', 'integer', 'exists:proyek,proyek_id'],
            'category_id' => ['required', 'integer', 'exists:kategori,category_id'],
            'date' => ['required', 'date'],
            'remark' => ['required', 'string', 'max:500'],
        ]);
        $reimburse->fill($request->all());
        $reimburse->save();
        return redirect()->route('reimburse.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reimburse $reimburse)
    {
        $reimburse->delete();
        return redirect()->route('reimburse.index');
    }

    public function send($id)
    {
        /** @var Reimburse $reimburse */
        $reimburse = Reimburse::findOrFail($id);
        $reimburse->status_staff = StatusKaryawan::SENT;
        $reimburse->save();
        return redirect()->route('reimburse.index');
    }

    public function hrAccept($id)
    {
        /** @var Reimburse $reimburse */
        $reimburse = Reimburse::findOrFail($id);
        $reimburse->status_hr = StatusHr::ACCEPT;
        $reimburse->save();
        return redirect()->route('reimburse.index');
    }

    public function hrReject($id)
    {
        /** @var Reimburse $reimburse */
        $reimburse = Reimburse::findOrFail($id);
        $reimburse->status_hr = StatusHr::REJECT;
        $reimburse->status_staff = StatusKaryawan::DRAFT;
        $reimburse->save();
        return redirect()->route('reimburse.index');
    }

    public function financeAccept($id)
    {
        /** @var Reimburse $reimburse */
        $reimburse = Reimburse::findOrFail($id);
        $reimburse->status_finance = StatusFinance::ACCEPT;
        $reimburse->save();
        return redirect()->route('reimburse.index');
    }

    public function financeReject($id)
    {
        /** @var Reimburse $reimburse */
        $reimburse = Reimburse::findOrFail($id);
        $reimburse->status_finance = StatusHr::REJECT;
        $reimburse->status_hr = StatusHr::REJECT;
        $reimburse->status_staff = StatusKaryawan::DRAFT;
        $reimburse->save();
        return redirect()->route('reimburse.index');
    }

    public function uploadProof($id)
    {
        /** @var Reimburse $reimburse */
        $reimburse = Reimburse::findOrFail($id);
        return view('reimburse.upload-proof', [
            'reimburse' => $reimburse,
        ]);
    }

    public function storeProof(Request $request, $id)
    {
        /** @var Reimburse $reimburse */
        $reimburse = Reimburse::findOrFail($id);
        $request->validate([
            'file' => [
                'nullable',
                \Illuminate\Validation\Rules\File::types(['pdf', 'jpeg', 'jpg', 'png'])
                    ->max('2mb')
            ],
        ]);

        /** @var UploadedFile $file */
        $file = $request->file;
        $reimburse->transfer_proof = $file->storeAs('berkas', sprintf("proof_%s.%s", uniqid('file'), $file->extension()));
        $reimburse->status_finance = StatusFinance::FINISH;
        $reimburse->save();
        return redirect()->route('reimburse.index');
    }

    public function report()
    {
        return view('reimburse.report', [
            'projects' => Proyek::all(),
            'categories' => Kategori::all()
        ]);
    }

    public function exportReport(Request $request)
    {
        $request->validate([
            'proyek_id' => ['nullable'],
            'category_id' => ['nullable'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'format' => ['required'],
        ]);
        if ($request->get('format') == 'PDF') {
            return $this->exportPdf($request);

        }
        $this->exportExcel($request);
    }

    private function exportExcel(Request $request)
    {
        $reimburses = Reimburse::query();
        $reimburses->whereBetween(
            column: 'date',
            values: [$request->start_date, $request->end_date]
        );
        if (!empty($request->proyek_id)) {
            $reimburses->where('proyek_id', $request->proyek_id);
        }
        if (!empty($request->category_id)) {
            $reimburses->where('category_id', $request->category_id);
        }
        clock($request->all());
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Laporan Reimburse');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A2', 'NO')
            ->setCellValue('B2', 'Kode')
            ->setCellValue('C2', 'Judul')
            ->setCellValue('D2', 'Kategori')
            ->setCellValue('E2', 'Proyek')
            ->setCellValue('F2', 'Jumlah')
            ->setCellValue('G2', 'Status')
            ->setCellValue('H2', 'HR')
            ->setCellValue('I2', 'Finance');
        $row = 3;
        $i = 1;
        foreach ($reimburses->get() as $reimburse) {
            $sheet->setCellValue("A$row", $i++)
                ->setCellValue("B$row", $reimburse->kode_reimburse)
                ->setCellValue("C$row", $reimburse->title)
                ->setCellValue("D$row", $reimburse->kategori->name)
                ->setCellValue("E$row", $reimburse->proyek->name)
                ->setCellValue("F$row", $reimburse->jumlah_total)
                ->setCellValue("G$row", $reimburse->status_staff)
                ->setCellValue("H$row", $reimburse->status_hr)
                ->setCellValue("I$row", $reimburse->status_finance);
            $row++;
        }

        $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
        $fileName = 'Report.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
    }

    private function exportPdf(Request $request)
    {
        $reimburses = Reimburse::query();
        $reimburses->whereBetween(
            column: 'date',
            values: [$request->start_date, $request->end_date]
        );
        if (!empty($request->proyek_id)) {
            $reimburses->where('proyek_id', $request->proyek_id);
        }
        if (!empty($request->category_id)) {
            $reimburses->where('category_id', $request->category_id);
        }

        $mpdf = new \Mpdf\Mpdf();
        $i = 1;
        $html = <<<HTML
<h1><b>Laporan Reimburse</b></h1><br><br>


<table style="border: 1px solid">
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
HTML;
        foreach ($reimburses->get() as $reimburse) {
            $html .= "<tr>
            <td>$i</td>
            <td>$reimburse->kode_reimburse</td>
            <td>$reimburse->title</td>
            <td>{$reimburse->kategori->name}</td>
            <td>{$reimburse->proyek->name}</td>
            <td>$reimburse->jumlah_total</td>
            <td>$reimburse->status_staff</td>
            <td>$reimburse->status_hr</td>
            <td>$reimburse->status_finance</td>
        </tr>";
            $i++;
        }
        $html .= <<<HTML
</table>
HTML;

        $mpdf->WriteHTML($html);
        return $mpdf->Output();
    }
}
