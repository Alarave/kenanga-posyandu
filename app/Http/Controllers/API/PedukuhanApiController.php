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
        $pedukuhans = Pedukuhan::all();
        return response()->json($pedukuhans);
    }

    public function store(PedukuhanRequest $request)
    {
        $pedukuhan = Pedukuhan::create($request->validated());
        return response()->json($pedukuhan, 201);
    }

    public function show(Pedukuhan $pedukuhan)
    {
        return response()->json($pedukuhan);
    }

    public function update(PedukuhanRequest $request, Pedukuhan $pedukuhan)
    {
        $pedukuhan->update($request->validated());
        return response()->json($pedukuhan);
    }

    public function destroy(Pedukuhan $pedukuhan)
    {
        $pedukuhan->delete();
        return response()->json(['message' => 'Pedukuhan deleted successfully']);
    }
}
