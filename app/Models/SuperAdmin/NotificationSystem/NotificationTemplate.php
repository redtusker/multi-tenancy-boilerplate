<?php

namespace App\Models\SuperAdmin\NotificationSystem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SuperAdmin\TenantManagement\Tenant;

class NotificationTemplate extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'template_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'tenant_id',
        'template_name',
        'template_content'
    ];

    // Relationships
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'template_id');
    }
}
