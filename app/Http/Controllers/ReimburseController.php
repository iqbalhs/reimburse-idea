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
            'project_id' => ['required', 'integer', 'exists:proyek,id'],
            'category_id' => ['required', 'integer', 'exists:kategori,id'],
            'date' => ['required', 'date'],
            'remark' => ['required', 'string', 'max:500'],
        ]);
        $reimburse = new Reimburse();
        $reimburse->fill($request->all());
        $reimburse->staff_id = auth()->user()->id;
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
            'project_id' => ['required', 'integer', 'exists:proyek,id'],
            'category_id' => ['required', 'integer', 'exists:kategori,id'],
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
}
