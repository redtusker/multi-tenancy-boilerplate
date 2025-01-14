<?php

namespace App\Models\SuperAdmin\SubscriptionManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SuperAdmin\TenantManagement\Tenant;
use App\Models\SuperAdmin\UsageTracking\FeatureUsage;
use App\Models\SuperAdmin\SubscriptionManagement\BillingCycle;
use App\Models\SuperAdmin\SubscriptionManagement\SubscriptionPlan;
use App\Models\SuperAdmin\SubscriptionManagement\SubscriptionChange;

class Subscription extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'subscription_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'tenant_id',
        'plan_id',
        'start_date',
        'end_date',
        'status'
    ];

    // Relationships
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }

    public function featureUsage()
    {
        return $this->hasMany(FeatureUsage::class, 'subscription_id');
    }

    public function billingCycles()
    {
        return $this->hasMany(BillingCycle::class, 'subscription_id');
    }

    public function changes()
    {
        return $this->hasMany(SubscriptionChange::class, 'subscription_id');
    }
}
