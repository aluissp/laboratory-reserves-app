<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'surname' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')
                    ->ignore(User::firstWhere('id', $this->id))
            ],
            'password' => ['required', 'string', 'min:8'],
            'password_confirmation' => ['required', 'string', 'min:8', 'same:password'],
            'role' => 'required|string|max:255',
            'major' => 'nullable|string|max:255'
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'Ya hay un usuario registrado con el mismo correo.',
            'password_confirmation.same' => 'Las contraseñas no coinciden. Vuelve a intentarlo.'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre',
            'surname' => 'apellido',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'password_confirmation' => 'confirmar contraseña',
            'role' => 'rol',
            'major' => 'carrera',
        ];
    }
}
