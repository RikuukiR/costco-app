<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'spec_code',
        'step_order',
        'step_description',
        'step_image_path',
    ];

    public $timestamps = true;
}
