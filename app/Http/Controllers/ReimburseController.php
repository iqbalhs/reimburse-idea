<?php

namespace App\Http\Controllers;

use App\Models\Reimburse;
use Illuminate\Http\Request;

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
        return view('reimburse.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:50']
        ]);
        Reimburse::create($request->all());
        return redirect()->route('reimburse.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reimburse $reimburse)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reimburse $reimburse)
    {
        return view('reimburse.edit', ['reimburse' => $reimburse]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reimburse $reimburse)
    {
        $request->validate([
            'name' => ['required', 'max:50']
        ]);
        $reimburse->update($request->all());
        return redirect()->route('reimburse.index')
            ->with('success', 'Reimburse berhasil diedit.');
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
