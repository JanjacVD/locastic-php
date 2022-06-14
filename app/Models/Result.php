<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'fullName',
        'raceTime',
        'distance',
        'placement',
        'race_id'
    ];
    use HasFactory;
}
