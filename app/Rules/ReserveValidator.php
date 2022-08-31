<?php

namespace App\Rules;

use App\Models\Lab;
use App\Models\LabsSchedule;
use App\Models\Reservation;
use Illuminate\Contracts\Validation\Rule;

class ReserveValidator implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id = null, $date = null, $initialHour = null, $finalHour = null, $lab_id = null)
    {
        $this->start_time = LabsSchedule::firstWhere('name', 'start_time')->hour;
        $this->end_time = LabsSchedule::firstWhere('name', 'end_time')->hour;

        $this->id = $id;
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
            $pass = $value >= $this->start_time;

            if (!$pass) {
                $this->message = "La hora inicial debe ser mayor de las $this->start_time horas.";
            }
        } else if ($attribute == 'end_time') {
            $pass = $value <= $this->end_time;

            if (!$pass) {
                $this->message = "La hora final debe ser menor de las $this->end_time horas.";
            }
        } else if ($attribute == 'lab_id') {
            $reservation = null;
            if (!is_null($this->id)) {
                $reservation = Reservation::firstWhere('id', $this->id);
            }

            $reservations = Lab::firstWhere('id', $value)
                ?->reservations
                ->where('date', $this->date)
                ->sortBy('start_time')
                ->all();
            $pass = !is_null($reservations);
            if ($pass) {
                $pass = empty($reservations);
                if (!$pass) {
                    $pass = $this->checkSchedule($reservations, $reservation);
                }
            } else {
                $this->message = "El laboratorio seleccionado no existe.";
            }
        } else if ($attribute == 'assistants') {
            $lab = Lab::firstWhere('id', $this->lab_id);
            $pass = !is_null($lab);

            if ($pass) {
                $pass = $value <= $lab->capacity;

                if (!$pass) {
                    $this->message = "Espacio insuficiente. La capacidad máxima es de $lab->capacity.";
                }
            } else {
                $this->message = "Por favor eliga un laboratorio.";
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

    private function checkSchedule($reservations, $reservation = null)
    {
        $pass = false;

        $schedule = $this->loadAvailableSchedule($reservations);

        foreach ($schedule as $available) {
            $pass = $this->initialHour >= $available['start_time']
                && $this->finalHour <= $available['end_time'];
            if ($pass) break;
        }


        if (!is_null($reservation) && !$pass) {
            foreach ($reservations as $reserve) {
                $exists = $this->initialHour >= $reserve->start_time
                    && $this->finalHour <= $reserve->end_time;
                if ($exists) {
                    $isSameHour = $this->initialHour >= $reservation->start_time && $this->finalHour <= $reservation->end_time;
                    $pass = $reservation->id === $reserve->id && $isSameHour;
                    break;
                }
            }
        }

        if (!$pass) {
            $this->loadAvailableScheduleMessage($reservations);
        }
        return $pass;
    }

    private function loadAvailableSchedule($reservationsOrigin)
    {
        $schedule = [];
        $reservations = [];

        foreach ($reservationsOrigin as $reserve) {
            $reservations[] = $reserve;
        }

        $aux = $reservations[0];
        if ($aux->start_time > $this->start_time) {
            $schedule[] = [
                'start_time' => $this->start_time,
                'end_time' => $aux->start_time
            ];
        }

        for ($i = 1; $i < count($reservations); $i++) {
            $aux = $reservations[$i - 1];
            if ($aux->end_time != $reservations[$i]->start_time) {
                $schedule[] = [
                    'start_time' => $aux->end_time,
                    'end_time' => $reservations[$i]->start_time
                ];
            }
        }

        $aux = $reservations[count($reservations) - 1];
        if ($aux->end_time < $this->end_time) {
            $schedule[] = [
                'start_time' => $aux->end_time,
                'end_time' => $this->end_time
            ];
        }
        return $schedule;
    }

    private function loadAvailableScheduleMessage($reservationsOrigin)
    {
        $reservations = [];
        foreach ($reservationsOrigin as $reserve) {
            $reservations[] = $reserve;
        }

        $this->message = "El horario disponible para el $this->date es:\n";
        $aux = $reservations[0];
        if ($aux->start_time > $this->start_time) {
            $this->message .= "- Desde $this->start_time horas hasta las $aux->start_time horas.\n";
        }

        for ($i = 1; $i < count($reservations); $i++) {
            $aux = $reservations[$i - 1];
            if ($aux->end_time != $reservations[$i]->start_time) {
                $this->message .= "- Desde $aux->end_time horas hasta las {$reservations[$i]->start_time} horas.\n";
            }
        }

        $aux = $reservations[count($reservations) - 1];
        if ($aux->end_time < $this->end_time) {
            $this->message .= "- Desde $aux->end_time horas hasta las $this->end_time horas.";
        }
    }
}
