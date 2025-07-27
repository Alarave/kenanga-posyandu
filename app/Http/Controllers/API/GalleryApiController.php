<?php

namespace App\Http\Controllers\API;

use App\Models\Gallery;
use App\Http\Requests\GalleryRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GalleryApiController extends Controller
{
    public function index()
    {
        $galleries = Gallery::all();
        return response()->json($galleries);
    }

    public function store(GalleryRequest $request)
    {
        $gallery = Gallery::create($request->validated());
        return response()->json($gallery, 201);
    }

    public function show(Gallery $gallery)
    {
        return response()->json($gallery);
    }

    public function update(GalleryRequest $request, Gallery $gallery)
    {
        $gallery->update($request->validated());
        return response()->json($gallery);
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return response()->json(['message' => 'Gallery image deleted successfully']);
    }
}
