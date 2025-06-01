<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesForecast extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'product_name',
        'forecast_value',
    ];

    public $timestamps = true;
}