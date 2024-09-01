<?php

namespace App\Http\Controllers;

use App\Models\Reimburse;
use App\Models\ReimburseDetail;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class ReimburseDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $reimburse = Reimburse::findOrFail($id);
        return view('reimburse-detail.create', ['reimburse' => $reimburse]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        /** @var Reimburse $reimburse */
        $reimburse = Reimburse::findOrFail($id);
        $request->validate([
            'title' => ['required', 'max:50'],
            'file' => [
                'required',
                File::types(['pdf', 'jpeg', 'jpg', 'png'])
                ->max('2mb')
            ],
            'jumlah' => ['required', 'numeric']
        ]);
        $reimburseDetail = new ReimburseDetail();
        $reimburseDetail->fill($request->all());
        $reimburseDetail->reimburse_id = $id;
        /** @var UploadedFile $file */
        $file = $request->file;
        $reimburseDetail->file_path = $file->storeAs('berkas', sprintf("%s.%s", uniqid('file'), $file->extension()));
        $reimburseDetail->save();
        $reimburse->updateJumlah();
        return redirect()->route('reimburse.show', $reimburse);
    }

    /**
     * Display the specified resource.
     */
    public function show(ReimburseDetail $reimburseDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $reimburseDetail = ReimburseDetail::findOrFail($id);
        return view('reimburse-detail.edit', ['reimburseDetail' => $reimburseDetail]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $reimburseDetail = ReimburseDetail::findOrFail($id);
        /** @var Reimburse $reimburse */
        $reimburse = $reimburseDetail->reimburse;
        $request->validate([
            'title' => ['required', 'max:50'],
            'file' => [
                'nullable',
                File::types(['pdf', 'jpeg', 'jpg', 'png'])
                    ->max('2mb')
            ],
            'jumlah' => ['required', 'numeric']
        ]);
        $reimburseDetail->fill([
            'title' => $request->get('title'),
            'jumlah' => $request->get('jumlah'),
        ]);
        /** @var UploadedFile $file */
        $file = $request->file;
        if ($file) {
            Storage::delete($reimburseDetail->file_path);
            $reimburseDetail->file_path = $file->storeAs('berkas', sprintf("%s.%s", uniqid('file'), $file->extension()));
        }
        $reimburseDetail->save();
        $reimburse->updateJumlah();
        return redirect()->route('reimburse.show', $reimburse);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $reimburseDetail = ReimburseDetail::findOrFail($id);
        /** @var Reimburse $reimburse */
        $reimburse = $reimburseDetail->reimburse;
        Storage::delete($reimburseDetail->file_path);
        $reimburseDetail->delete();
        $reimburse->updateJumlah();
        return redirect()->route('reimburse.show', $reimburse);
    }
}
