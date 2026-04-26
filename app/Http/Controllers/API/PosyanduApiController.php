<?php

namespace App\Http\Controllers\API;

use App\Models\Posyandu;
use App\Http\Requests\PosyanduRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PosyanduApiController extends Controller
{
    public function index()
    {
        $posyandus = Posyandu::with('pedukuhan')->get();
        return response()->json($posyandus);
    }

    public function store(PosyanduRequest $request, \App\Services\PosyanduService $posyanduService)
    {
        $posyandu = $posyanduService->createPosyandu($request->validated());
        return response()->json($posyandu, 201);
    }

    public function show(Posyandu $posyandu)
    {
        return response()->json($posyandu);
    }

    public function update(PosyanduRequest $request, Posyandu $posyandu, \App\Services\PosyanduService $posyanduService)
    {
        $posyanduService->updatePosyandu($posyandu, $request->validated());
        return response()->json($posyandu);
    }

    public function destroy(Posyandu $posyandu, \App\Services\PosyanduService $posyanduService)
    {
        $posyanduService->deletePosyandu($posyandu);
        return response()->json(['message' => 'Posyandu deleted successfully']);
    }
}
