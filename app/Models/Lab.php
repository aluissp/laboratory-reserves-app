<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'description',
        'capacity',
    ];


    public function staffInCharge()
    {
        return $this->belongsTo(User::class, 'staff_in_charge');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
