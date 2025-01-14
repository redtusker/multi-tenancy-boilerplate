<?php

namespace App\Models\SuperAdmin\ProductConfiguration;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SuperAdmin\QuotationSystem\QuotationItem;

class ProductVariation extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'variation_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'stock',
        'is_active'
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(ProductDefinition::class, 'product_id');
    }

    public function attributes()
    {
        return $this->hasMany(ProductVariationAttribute::class, 'variation_id');
    }

    public function quotationItems()
    {
        return $this->hasMany(QuotationItem::class, 'variation_id');
    }
}
