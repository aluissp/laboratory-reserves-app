<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255',],
            'assistants' => ['required', 'integer', 'min:1', 'max:1000'],
            'date' => ['required', 'date_format:d/m/Y'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'lab_id' => ['required', 'exists:labs,id']
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre',
            'description' => 'descripción',
            'assistant' => 'asistentes',
            'date' => 'fecha',
            'start_time' => 'hora inicial',
            'end_time' => 'hora final',
            'lab_id' => 'laboratorio',
        ];
    }
}
