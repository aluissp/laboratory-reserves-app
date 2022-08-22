<?php

namespace App\Http\Requests;

use App\Models\Lab;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        // dd(User::firstWhere('email', $this->staff)->id);
        // request()->staff = User::firstWhere('email', $this->staff)->id;

        dd($request->staff);
        return [
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255',],
            'capacity' => ['required', 'integer', 'min:1', 'max:100'],
            'staff' => [
                'required',
                'email',
                'exists:users,email',
                'unique:labs,staff_in_charge'
            ]
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
