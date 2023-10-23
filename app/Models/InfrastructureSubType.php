<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InfrastructureType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InfrastructureSubType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_id',
        'name',
        'icon_url'
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(InfrastructureType::class, 'type_id');
    }
}
