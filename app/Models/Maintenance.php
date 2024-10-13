<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'scheduled_date',
        'description',
        'status'
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
