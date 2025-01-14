<?php

namespace App\Models;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

abstract class BaseSuperAdmin extends Model
{
    // Define common properties or methods that will be shared among all models extending this class

    // Example: Common timestamp format
    protected $dateFormat = 'Y-m-d H:i:s';

    // Example: Common method to format dates
    public function getFormattedDate($date)
    {
        return \Carbon\Carbon::parse($date)->format('d-m-Y');
    }

    // Example: Common scope for active records
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    // Example: Common method to generate UUIDs
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         if (empty($model->{$model->getKeyName()})) {
    //             $model->{$model->getKeyName()} = (string) \Illuminate\Support\Str::uuid();
    //         }
    //     });
    // }

    // Example: Common method to get model's table name
    public function getTableName()
    {
        return $this->getTable();
    }

    // Example: Common method to get model's primary key
    public function getPrimaryKey()
    {
        return $this->getKeyName();
    }

    // Example: Common method to get model's primary key value
    public function getPrimaryKeyValue()
    {
        return $this->getKey();
    }

    // Example: Common method to check if model is new
    public function isNew()
    {
        return !$this->exists;
    }

    // Example: Common method to get model's attributes as array
    public function getAttributesArray()
    {
        return $this->attributesToArray();
    }

    public static function getFillableColumns()
    {
        // return Schema::getColumnListing((new static)->getTable());
        $allColumns = Schema::getColumnListing((new static)->getTable());
        $hiddenColumns = (new static)->getHidden();
        $defaultColumns = [
            'id',
            'created_at',
            'updated_at',
            'deleted_at',
            'email_verified_at'
        ];

        return array_diff($allColumns, $hiddenColumns, $defaultColumns);
    }
}
