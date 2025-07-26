<?php

namespace App\Http\Controllers\Web;

use App\Models\Posyandu;
use App\Http\Requests\PosyanduRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PosyanduController extends Controller
{
    public function index()
    {
        $posyandus = Posyandu::all();
        return view('admin.posyandu-management.index', compact('posyandus'));
    }

    public function create()
    {
        return view('admin.posyandu-management.create');
    }

    public function store(PosyanduRequest $request)
    {
        Posyandu::create($request->validated());
        return redirect()->route('posyandus.index')->with('success', 'Posyandu created successfully.');
    }

    public function show(Posyandu $posyandu)
    {
        return view('admin.posyandu-management.details', compact('posyandu'));
    }

    public function edit(Posyandu $posyandu)
    {
        return view('admin.posyandu-management.update', compact('posyandu'));
    }

    public function update(PosyanduRequest $request, Posyandu $posyandu)
    {
        $posyandu->update($request->validated());
        return redirect()->route('posyandus.index')->with('success', 'Posyandu updated successfully.');
    }

    public function destroy(Posyandu $posyandu)
    {
        $posyandu->delete();
        return redirect()->route('posyandus.index')->with('success', 'Posyandu deleted successfully.');
    }
}
