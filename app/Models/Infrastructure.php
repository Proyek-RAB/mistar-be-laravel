<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InfrastructureSubType;
use App\Models\InfrastructureEditHistory;
use App\Models\InfrastructureRequest;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Infrastructure extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = [];
    protected $fillable = [
        'id',
        'sub_type_id',
        'user_id',
        'name',
        'details',
        'status'
    ];

    // protected $casts = [
    //     'details' => 'array'
    // ];

    public function subType()
    {
        return $this->belongsTo(InfrastructureSubType::class, 'sub_type_id');
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function editHistories(): HasMany
    {
        return $this->hasMany(InfrastructureEditHistory::class);
    }

    public function requests(): HasMany
    {
        return $this->hasMany(InfrastructureRequest::class);
    }

}
