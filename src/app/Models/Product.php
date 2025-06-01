<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
use HasFactory;

protected $primaryKey = 'spec_code';
public $incrementing = false;
protected $keyType = 'string';

protected $fillable = [
'spec_code',
'name',
'image_path',
'price',
'target_weight',
'category',
];
}