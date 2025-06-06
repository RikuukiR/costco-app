<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecIngredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'spec_code',
        'ingredient_id',
        'quantity_per_unit',
        'unit',
    ];
}