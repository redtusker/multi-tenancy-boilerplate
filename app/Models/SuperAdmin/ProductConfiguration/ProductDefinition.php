<?php

namespace App\Models\SuperAdmin\ProductConfiguration;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SuperAdmin\ProductConfiguration\ProductAttribute;
use App\Models\SuperAdmin\ProductConfiguration\ProductVariation;

class ProductDefinition extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'product_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'description',
        'category',
        'type'
    ];

    // Relationships
    public function variations()
    {
        return $this->hasMany(ProductVariation::class, 'product_id');
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id');
    }
}
