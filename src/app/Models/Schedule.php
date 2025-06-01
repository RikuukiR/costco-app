<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'spec_code',
        'scheduled_date',
        'scheduled_time',
        'quantity_cell',
    ];
}