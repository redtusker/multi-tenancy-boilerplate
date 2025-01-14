<?php

namespace App\Models\SuperAdmin\CompanyAndUserManagement;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SuperAdmin\TenantManagement\Tenant;

class Company extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'company_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'tenant_id',
        'name'
    ];

    // Relationships
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'company_id');
    }

    public function teams()
    {
        return $this->hasMany(Team::class, 'company_id');
    }
}
