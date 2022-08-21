<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLabRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->hasRole(config('role.admin'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'description' => [
                'required',
                'string',
                'max:255',
            ],
            'capacity' => ['required', 'integer', 'min:1', 'max:100'],
            'staff' => 'required|string|max:255'
        ];
    }

    public function messages()
    {
        return [
            // 'email.unique' => 'Ya hay un usuario registrado con el mismo correo.',
            // 'password_confirmation.same' => 'Las contraseñas no coinciden. Vuelve a intentarlo.'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre',
            'location' => 'ubicación',
            'description' => 'descripción',
            'capacity' => 'capacidad',
            'staff' => 'personal a cargo',
        ];
    }
}
