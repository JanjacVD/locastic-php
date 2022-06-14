<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    protected $fillable = ['raceName', 'date'];

    public function results(){
        return $this->hasMany(Result::class);
    }

    use HasFactory;
}
