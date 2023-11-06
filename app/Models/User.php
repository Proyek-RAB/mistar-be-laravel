<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\InfrastructureRequest;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\InfrastructureRequestHistory;
use App\Models\Infrastructure;
use App\Models\InfrastructureEditHistory;

/**
 * @property int $id
 * @property string $type
 * @property string $full_name
 * @property string $email
 * @property string $password
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_MEMBER = 'MEMBER';

    const ROLE_ADMIN = 'ADMIN';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'type',
        'role',
        'full_name',
        'email',
        'password',
        'avatar_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function infraRequest() : HasMany
    {
        return $this->hasMany(InfrastructureRequest::class, 'user_id');
    }

    public function infraReqHistory() : HasMany
    {
        return $this->hasMany(InfrastructureRequestHistory::class, 'user_id');
    }

    public function infrastructure() : HasMany
    {
        return $this->hasMany(Infrastructure::class, 'user_id');
    }

    public function infraEditHistory() : HasMany
    {
        return $this->hasMany(InfrastructureEditHistory::class, 'user_id');
    }
}
