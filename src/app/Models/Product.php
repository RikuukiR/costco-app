<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

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

    /**
     * Route model bindingのキーをspec_codeに設定
     */
    public function getRouteKeyName()
    {
        return 'spec_code';
    }

    /**
     * 商品に紐づく調理手順を取得
     */
    public function recipeSteps()
    {
        return $this->hasMany(RecipeStep::class, 'spec_code', 'spec_code');
    }

    /**
     * 商品に紐づく使用食材を取得
     */
    public function specIngredients()
    {
        return $this->hasMany(SpecIngredient::class, 'spec_code', 'spec_code');
    }
}