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
        ];

        if ($this->isMethod('POST')) {
            $rules['photo'] = 'required|image|mimes:jpg,jpeg,png|max:2048';
        } else {
            $rules['photo'] = 'nullable|image|mimes:jpg,jpeg,png|max:2048';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul gambar wajib diisi.',
            'photo.required' => 'Foto gambar wajib diunggah.',
            'photo.image' => 'File yang diunggah harus berupa gambar.',
        ];
    }
}
