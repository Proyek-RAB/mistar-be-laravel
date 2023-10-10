<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InfrastructureEditHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'infrastructure_id',
        'user_id',
        'details',
    ];
    // protected $casts = [
    //     'details'=>"array"
    // ];
    public function infrastructure(): BelongsTo
    {
        return $this->belongsTo(Infrastructure::class, 'infrastructure_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
