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
        $posyandus = Posyandu::all();
        return response()->json($posyandus);
    }

    public function store(PosyanduRequest $request)
    {
        $posyandu = Posyandu::create($request->validated());
        return response()->json($posyandu, 201);
    }

    public function show(Posyandu $posyandu)
    {
        return response()->json($posyandu);
    }

    public function update(PosyanduRequest $request, Posyandu $posyandu)
    {
        $posyandu->update($request->validated());
        return response()->json($posyandu);
    }

    public function destroy(Posyandu $posyandu)
    {
        $posyandu->delete();
        return response()->json(['message' => 'Posyandu deleted successfully']);
    }
}
