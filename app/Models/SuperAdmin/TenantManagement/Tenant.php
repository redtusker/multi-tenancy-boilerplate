<?php

namespace App\Models\SuperAdmin\TenantManagement;

use Illuminate\Database\Eloquent\Model;
use App\Models\SuperAdmin\General\AuditLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SuperAdmin\General\Application;
use App\Models\SuperAdmin\QuotationSystem\Quotation;
use App\Models\SuperAdmin\TenantManagement\TenantSetting;
use App\Models\SuperAdmin\CompanyAndUserManagement\Company;
use App\Models\SuperAdmin\SubscriptionManagement\Subscription;
use App\Models\SuperAdmin\TenantManagement\TenantConfiguration;

class Tenant extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'tenant_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'application_id',
        'name'
    ];

    // Relationships
    public function dispatchApplication()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function companies()
    {
        return $this->hasMany(Company::class, 'tenant_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'tenant_id');
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class, 'tenant_id');
    }

    public function settings()
    {
        return $this->hasMany(TenantSetting::class, 'tenant_id');
    }

    public function configurations()
    {
        return $this->hasMany(TenantConfiguration::class, 'tenant_id');
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class, 'tenant_id');
    }
}
