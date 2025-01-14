<?php

namespace App\Models\SuperAdmin\CompanyAndUserManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SuperAdmin\CompanyAndUserManagement\Company;
use App\Models\SuperAdmin\CompanyAndUserManagement\TeamMember;

class Team extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'team_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'company_id',
        'name',
        'description'
    ];

    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function members()
    {
        return $this->hasMany(TeamMember::class, 'team_id');
    }
}
