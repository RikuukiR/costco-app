<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolumeDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'volume_id',
        'cell_number',
        'actual_weight',
        'calculated_price',
    ];
}