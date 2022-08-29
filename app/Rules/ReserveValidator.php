<?php

namespace App\Rules;

use App\Models\Lab;
use App\Models\LabsSchedule;
use Illuminate\Contracts\Validation\Rule;

class ReserveValidator implements Rule
{
    private $message;
    private $start_time;
    private $end_time;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($date = null, $initialHour = null, $finalHour = null, $lab_id = null)
    {
        $this->start_time = LabsSchedule::firstWhere('name', 'start_time')->hour;
        $this->end_time = LabsSchedule::firstWhere('name', 'end_time')->hour;

        $this->date = $date;
        $this->initialHour = $initialHour;
        $this->finalHour = $finalHour;

        $this->lab_id = $lab_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $pass = false;

        if ($attribute == 'start_time') {
            $pass = $value . ':00' >= $this->start_time;

            if (!$pass) {
                $this->message = "La hora inicial debe ser mayor de las $this->start_time horas.";
            }
        } else if ($attribute == 'end_time') {
            $pass = $value . ':00' <= $this->end_time;

            if (!$pass) {
                $this->message = "La hora final debe ser menor de las $this->end_time horas.";
            }
        } else if ($attribute == 'lab_id') {
            // falta validar que no se repita horarios
            $lab = Lab::firstWhere('id', $value);
            $pass = true;
        } else if ($attribute == 'assistants') {
            $lab = Lab::firstWhere('id', $this->lab_id);
            $pass = !is_null($lab);

            if ($pass) {
                $pass = $value <= $lab->capacity;

                if (!$pass) {
                    $this->message = "Espacio insuficiente. La capacidad máxima es de $lab->capacity.";
                }
            }
        }

        return $pass;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
