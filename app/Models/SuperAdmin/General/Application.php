<?php

namespace App\Models\SuperAdmin\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SuperAdmin\TenantManagement\Tenant;

class Application extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'application_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name', 'description', 'default_config'
    ];

    protected $casts = [
        'default_config' => 'array',
    ];

    // Relationships
    public function super_admin()
    {
        return $this->belongsTo(SuperAdmin::class, 'super_admin_id');
    }

    public function tenants()
    {
        return $this->hasMany(Tenant::class, 'application_id');
    }
}
