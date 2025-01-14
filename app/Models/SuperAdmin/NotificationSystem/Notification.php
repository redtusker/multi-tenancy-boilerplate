<?php

namespace App\Models\SuperAdmin\NotificationSystem;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\SuperAdmin\TenantManagement\Tenant;

class Notification extends Model
{
    protected $primaryKey = 'notification_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'tenant_id',
        'user_id',
        'message',
        'status'
    ];

    // Relationships
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function template()
    {
        return $this->belongsTo(NotificationTemplate::class, 'template_id');
    }
}
