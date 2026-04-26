<?php

namespace App\Http\Controllers\API;

use App\Models\Pedukuhan;
use App\Http\Requests\PedukuhanRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PedukuhanApiController extends Controller
{
    public function index()
    {
        $pedukuhans = Pedukuhan::withCount('posyandus')->get();
        return response()->json($pedukuhans);
    }

    public function store(PedukuhanRequest $request, \App\Services\PedukuhanService $pedukuhanService)
    {
        $pedukuhan = $pedukuhanService->createPedukuhan($request->validated());
        return response()->json($pedukuhan, 201);
    }

    public function show(Pedukuhan $pedukuhan)
    {
        return response()->json($pedukuhan);
    }

    public function update(PedukuhanRequest $request, Pedukuhan $pedukuhan, \App\Services\PedukuhanService $pedukuhanService)
    {
        $pedukuhanService->updatePedukuhan($pedukuhan, $request->validated());
        return response()->json($pedukuhan);
    }

    public function destroy(Pedukuhan $pedukuhan, \App\Services\PedukuhanService $pedukuhanService)
    {
        $pedukuhanService->deletePedukuhan($pedukuhan);
        return response()->json(['message' => 'Pedukuhan deleted successfully']);
    }
}
