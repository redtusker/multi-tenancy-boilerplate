<?php

namespace App\Models\SuperAdmin\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuperAdmin extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'super_admin_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'username',
        'email',
        'password_hash'
    ];

    // Relationships
    public function dispatchApplications()
    {
        return $this->hasMany(Application::class, 'super_admin_id');
    }

    public function logs()
    {
        return $this->hasMany(SuperAdminLog::class, 'super_admin_id');
    }
}
