<?php

namespace App\Models\SuperAdmin\SubscriptionManagement;

use Illuminate\Database\Eloquent\Model;
use App\Models\SuperAdmin\SubscriptionManagement\PlanFeature;
use App\Models\SuperAdmin\SubscriptionManagement\Subscription;

class SubscriptionPlan extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'plan_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'description',
        'billing_cycle',
        'auto_renew'
    ];

    // Relationships
    public function features()
    {
        return $this->hasMany(PlanFeature::class, 'plan_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }
}
