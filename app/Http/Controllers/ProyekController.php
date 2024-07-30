<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use Illuminate\Http\Request;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('proyek.index', [
            'proyeks' => Proyek::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('proyek.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:50']
        ]);
        Proyek::create($request->all());
        return redirect()->route('proyek.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proyek $proyek)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proyek $proyek)
    {
        return view('proyek.edit', ['proyek' => $proyek]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proyek $proyek)
    {
        $request->validate([
            'name' => ['required', 'max:50']
        ]);
        $proyek->update($request->all());
        return redirect()->route('proyek.index')
            ->with('success', 'Proyek berhasil diedit.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proyek $proyek)
    {
        $proyek->delete();
        return redirect()->route('proyek.index');
    }
}
