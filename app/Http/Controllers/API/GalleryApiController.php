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
        $galleries = Gallery::accessibleBy(auth()->user())->get();
        return response()->json($galleries);
    }

    public function store(GalleryRequest $request, \App\Services\GalleryService $galleryService)
    {
        $gallery = $galleryService->createGallery($request->validated(), auth()->user());
        return response()->json($gallery, 201);
    }

    public function show(Gallery $gallery)
    {
        return response()->json($gallery);
    }

    public function update(GalleryRequest $request, Gallery $gallery, \App\Services\GalleryService $galleryService)
    {
        $galleryService->updateGallery($gallery, $request->validated());
        return response()->json($gallery);
    }

    public function destroy(Gallery $gallery, \App\Services\GalleryService $galleryService)
    {
        $galleryService->deleteGallery($gallery);
        return response()->json(['message' => 'Gallery image deleted successfully']);
    }
}
