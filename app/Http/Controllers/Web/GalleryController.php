<?php

namespace App\Http\Controllers\Web;

use App\Models\Gallery;
use App\Http\Requests\GalleryRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::all();
        return view('admin.gallery-management.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery-management.create');
    }

    public function store(GalleryRequest $request)
    {
        Gallery::create($request->validated());
        return redirect()->route('galleries.index')->with('success', 'Gallery image uploaded successfully.');
    }

    public function show(Gallery $gallery)
    {
        return view('admin.gallery-management.details', compact('gallery'));
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery-management.update', compact('gallery'));
    }

    public function update(GalleryRequest $request, Gallery $gallery)
    {
        $gallery->update($request->validated());
        return redirect()->route('galleries.index')->with('success', 'Gallery image updated successfully.');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return redirect()->route('galleries.index')->with('success', 'Gallery image deleted successfully.');
    }
}
