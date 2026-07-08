<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\PosyanduRequest;
use App\Models\Posyandu;
use Illuminate\Http\Request;

class PosyanduController extends Controller
{
    public function index(Request $request)
    {
        $posyandus = Posyandu::with('pedukuhan')
            ->when($request->search, fn ($q, $s) => $q->where(function ($q) use ($s) {
                $searchTerm = '%'.strtolower($s).'%';
                $q->whereRaw('LOWER(name) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(unique_code) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(address) LIKE ?', [$searchTerm]);
            }))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('livewire.admin.posyandu-management.index', compact('posyandus'));
    }

    public function create()
    {
        return view('livewire.admin.posyandu-management.create');
    }

    public function store(PosyanduRequest $request, \App\Services\PosyanduService $posyanduService)
    {
        $posyanduService->createPosyandu($request->validated());

        return redirect()->route('admin.posyandu.index')
            ->with('success', 'Posyandu berhasil ditambahkan.');
    }

    public function show(Posyandu $posyandu)
    {
        $posyandu->load('pedukuhan');

        return view('livewire.admin.posyandu-management.details', compact('posyandu'));
    }

    public function edit(Posyandu $posyandu)
    {
        return view('livewire.admin.posyandu-management.update', compact('posyandu'));
    }

    public function update(PosyanduRequest $request, Posyandu $posyandu, \App\Services\PosyanduService $posyanduService)
    {
        $posyanduService->updatePosyandu($posyandu, $request->validated());

        return redirect()->route('admin.posyandu.index')
            ->with('success', 'Posyandu berhasil diperbarui.');
    }

    public function destroy(Posyandu $posyandu, \App\Services\PosyanduService $posyanduService)
    {
        $posyanduService->deletePosyandu($posyandu);

        return redirect()->route('admin.posyandu.index')
            ->with('success', 'Posyandu berhasil dihapus.');
    }
}
