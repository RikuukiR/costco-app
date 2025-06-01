<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    use HasFactory;

    protected $fillable = [
        'spec_code',
        'destroyed_weight',
        'actual_weight_1',
        'actual_weight_2',
        'actual_weight_3',
        'actual_weight_4',
        'actual_weight_5',
    ];
}