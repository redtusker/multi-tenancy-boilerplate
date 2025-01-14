<?php

namespace App\Models\SuperAdmin\CompanyAndUserManagement;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\SuperAdmin\CompanyAndUserManagement\Team;

class TeamMember extends Model
{
    protected $primaryKey = 'team_member_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'team_id', 'user_id', 'role'
    ];

    // Relationships
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
