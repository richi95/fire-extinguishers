<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $fillable = ['service_date', 'first_qt', 'second_qt', 'third_qt', 'fourth_qt', 'comment'];
    use HasFactory;
}
