<?php

namespace App\Models\SuperAdmin\ProductConfiguration;

use Illuminate\Database\Eloquent\Model;
use App\Models\SuperAdmin\ProductConfiguration\ProductVariation;

class ProductVariationAttribute extends Model
{
    protected $primaryKey = 'variation_attribute_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'variation_id', 'attribute_name', 'attribute_value'
    ];

    // Relationships
    public function variation()
    {
        return $this->belongsTo(ProductVariation::class, 'variation_id');
    }
}
