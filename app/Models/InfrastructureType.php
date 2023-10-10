<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InfrastructureSubType;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InfrastructureType extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'name', 'icon_url'
    ];

    public function subTypes() : HasMany
    {
        return $this->hasMany(InfrastructureSubType::class, 'type_id');
    }
}
