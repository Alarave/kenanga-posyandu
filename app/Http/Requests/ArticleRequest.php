<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|string|in:published,draft',
            'published_at' => 'nullable|date',
        ];

        if ($this->isMethod('POST')) {
            $rules['thumbnail'] = 'required|image|mimes:jpg,jpeg,png|max:2048';
        } else {
            $rules['thumbnail'] = 'nullable|image|mimes:jpg,jpeg,png|max:2048';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul artikel wajib diisi.',
            'content.required' => 'Konten artikel wajib diisi.',
        ];
    }
}
