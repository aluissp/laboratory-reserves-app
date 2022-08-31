<?php

namespace App\Http\Requests;

use App\Rules\ReserveValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
            'description' => ['required', 'string', 'max:255',],
            'assistants' => [
                'required', 'integer', 'min:1', 'max:1000',
                new ReserveValidator(null, null, null, null, $this->lab_id)
            ],
            'date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'start_time' => [
                'required', 'date_format:H:i:s', 'before:end_time',
                new ReserveValidator()
            ],
            'end_time' => [
                'required', 'date_format:H:i:s', 'after:start_time',
                new ReserveValidator()
            ],
            'lab_id' => [
                'required', 'exists:labs,id',
                new ReserveValidator($this->id, $this->date, $this->start_time, $this->end_time, null)
            ],
            'color' => 'string|max:20'
        ];
    }

    public function messages()
    {
        return [
            'start_time.before' => 'El campo hora inicial debe ser una hora anterior a hora final.',
            'end_time.after' => 'El campo hora final debe ser una hora posterior a hora inicial.',
            'date.after_or_equal' => 'El campo fecha debe ser una fecha posterior o igual a la fecha de hoy.'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre',
            'description' => 'descripción',
            'assistants' => 'asistentes',
            'date' => 'fecha',
            'start_time' => 'hora inicial',
            'end_time' => 'hora final',
            'lab_id' => 'laboratorio',
        ];
    }
}
