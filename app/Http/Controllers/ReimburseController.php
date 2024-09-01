<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Proyek;
use App\Models\Reimburse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ReimburseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('reimburse.index', [
            'reimburses' => Reimburse::all()
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
}
