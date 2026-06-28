<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'posyandu_id' => 'nullable|exists:posyandus,id',
            'is_featured' => 'boolean',
            'folder_id' => 'nullable|exists:gallery_folders,id',
        ];

        if ($this->isMethod('POST')) {
            $rules['photos'] = 'required|array|min:1';
            $rules['photos.*'] = 'file|mimes:jpg,jpeg,png,webp,gif,mp4,mov,avi,webm,mkv|max:20480';
        } else {
            $rules['photos'] = 'nullable|file|mimes:jpg,jpeg,png,webp,gif,mp4,mov,avi,webm,mkv|max:20480';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul galeri wajib diisi.',
            'photos.required' => 'File galeri wajib diunggah.',
            'photos.*.file' => 'File yang diunggah tidak valid.',
            'photos.*.mimes' => 'Format file harus berupa gambar (jpg, jpeg, png, webp, gif) atau video (mp4, mov, avi, webm, mkv).',
            'photos.*.max' => 'Ukuran file tidak boleh melebihi 20MB.',
        ];
    }
}
