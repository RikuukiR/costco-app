<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destroy extends Model
{
    use HasFactory;

    protected $fillable = [
        'spec_code',
        'destroyed_weight',
        'destroy_date',
    ];
}