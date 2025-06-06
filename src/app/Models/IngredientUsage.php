<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'ingredient_id',
        'quantity_used',
        'used_at',
    ];
}