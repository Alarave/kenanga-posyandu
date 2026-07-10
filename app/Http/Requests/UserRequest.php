<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all users to make this request
    }

    public function rules()
    {
        $userRouteParam = $this->route('user');
        $userId = is_object($userRouteParam) ? $userRouteParam->id : $userRouteParam;

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($userId),
            ],
            'password' => $userId
                ? ['nullable', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()]
                : ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()],
            'role' => 'required|string|in:superadmin,admin,kader,admin1,admin2,kader1,kader2',
            'is_active' => 'sometimes|boolean',
            'cadre_role' => 'nullable|string|max:255',
            'ttl' => 'nullable|string|max:255',
            'nik' => 'nullable|string|max:16',
            'pendidikan' => 'nullable|string|in:SD,SMP,SLTA,Diploma,Sarjana,Magister,Doktor',
            'alamat' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Email pengguna wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password pengguna wajib diisi.',
        ];
    }
}
