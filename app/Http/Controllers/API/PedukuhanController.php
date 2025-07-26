<?php

namespace App\Http\Controllers\Web;

use App\Models\Pedukuhan;
use App\Http\Requests\PedukuhanRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PedukuhanController extends Controller
{
    public function index()
    {
        // Menampilkan seluruh data Pedukuhan
        $pedukuhans = Pedukuhan::all();
        return view('admin.pedukuhan-management.index', compact('pedukuhans'));
    }

    public function create()
    {
        // Menampilkan formulir untuk membuat Pedukuhan baru
        return view('admin.pedukuhan-management.create');
    }

    public function store(PedukuhanRequest $request)
    {
        // Menambah data Pedukuhan baru
        Pedukuhan::create($request->validated());
        return redirect()->route('pedukuhans.index')->with('success', 'Pedukuhan created successfully.');
    }

    public function show(Pedukuhan $pedukuhan)
    {
        // Menampilkan detail dari Pedukuhan
        return view('admin.pedukuhan-management.details', compact('pedukuhan'));
    }

    public function edit(Pedukuhan $pedukuhan)
    {
        // Menampilkan formulir untuk mengedit data Pedukuhan
        return view('admin.pedukuhan-management.update', compact('pedukuhan'));
    }

    public function update(PedukuhanRequest $request, Pedukuhan $pedukuhan)
    {
        // Memperbarui data Pedukuhan
        $pedukuhan->update($request->validated());
        return redirect()->route('pedukuhans.index')->with('success', 'Pedukuhan updated successfully.');
    }

    public function destroy(Pedukuhan $pedukuhan)
    {
        // Menghapus data Pedukuhan
        $pedukuhan->delete();
        return redirect()->route('pedukuhans.index')->with('success', 'Pedukuhan deleted successfully.');
    }
}
