<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InfrastructureSubType;
use App\Models\InfrastructureEditHistory;
use App\Models\InfrastructureRequest;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Infrastructure extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    const TYPE_POINT = 'Titik';

    const TYPE_LINE = 'Garis';

    const TYPE_AREA = 'Bidang';

    const SUB_TYPE_CLEAN_WATER = 'Air Bersih';

    const SUB_TYPE_DIRTY_WATER = 'Air Kotor (Jamban)';

    const SUB_TYPE_WASTE = 'Persampahan';

    const SUB_TYPE_ROAD_DRAINAGE = 'Jalan & Drainase';

    const SUB_TYPE_PARKING_LOT = 'Lahan Parkir';

    const STATUS_GOOD = 'baik';

    const STATUS_REPAIR = 'perbaikan';

    const STATUS_BROKEN = 'rusak';

    const STATUS_APPROVAL_REQUESTED = 'requested';

    const STATUS_APPROVAL_APPROVED = 'accepted';

    const STATUS_APPROVAL_REJECTED = 'denied';

    const THUMBNAIL_IMAGES = 'THUMBNAIL_IMAGES';

    protected $guarded = [];
    protected $fillable = [
        'id',
        'name',
        'user_id',
        'sub_type_id',
        'sub_type',
        'type_id',
        'type',
        'zip_code',
        'details',
        'image',
        'status',
        'status_approval'
    ];

    protected $casts = [
        'image' => 'array'
    ];

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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::THUMBNAIL_IMAGES);
    }
}
