<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Infrastructure;
use App\Models\User;
use App\Models\InfrastructureRequestHistory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InfrastructureRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'infrastructure_id',
        'user_id',
    ];

    public function infrastructure(): BelongsTo
    {
        return $this->belongsTo(Infrastructure::class, 'infrastructure_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function infrastructure_request_histories(): HasMany
    {
        return $this->hasMany(InfrastructureRequestHistory::class);
    }
}
