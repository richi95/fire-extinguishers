<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FireExtinguisher extends Model
{
    protected $fillable = [
        'place',
        'internal_identifier',
        'standby_location',
        'device_type',
        'serial_number',
        'date_of_manufacture',
        'comment',
    ];

    use HasFactory;

    function maintenance(){
        return $this->hasOne(Maintenance::class);
    }
}
