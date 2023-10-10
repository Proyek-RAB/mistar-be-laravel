<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InfrastructureRequestHistory extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ['infrastructure_request_id', 'admin_id', 'details'];

    public function infrastructure_request() : BelongsTo
    {
        return $this->belongsTo(InfrastructureRequest::class, 'infrastructure_request_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
