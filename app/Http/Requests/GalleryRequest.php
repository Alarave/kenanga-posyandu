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
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'posyandu_id' => 'nullable|exists:posyandus,id',
            'is_featured' => 'boolean',
        ];

        if ($this->isMethod('POST')) {
            $rules['photos'] = 'required|array';
            $rules['photos.*'] = [
                'required',
                'file',
                'max:1048576',
                function ($attribute, $value, $fail) {
                    $extension = strtolower($value->getClientOriginalExtension());
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'mp4', 'mov', 'avi', 'webm', 'mkv'];
                    if (! in_array($extension, $allowedExtensions)) {
                        $fail('Format file harus berupa gambar (jpg, jpeg, png, webp, gif) atau video (mp4, mov, avi, webm, mkv).');
                    }
                },
            ];
        } else {
            $rules['photos'] = 'nullable|array';
            $rules['photos.*'] = [
                'nullable',
                'file',
                'max:1048576',
                function ($attribute, $value, $fail) {
                    $extension = strtolower($value->getClientOriginalExtension());
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'mp4', 'mov', 'avi', 'webm', 'mkv'];
                    if ($value && ! in_array($extension, $allowedExtensions)) {
                        $fail('Format file harus berupa gambar (jpg, jpeg, png, webp, gif) atau video (mp4, mov, avi, webm, mkv).');
                    }
                },
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'photos.required' => 'Wajib memilih minimal satu file media.',
            'photos.*.file' => 'File yang diunggah tidak valid.',
            'photos.*.max' => 'Ukuran file tidak boleh melebihi 1GB.',
        ];
    }
}
