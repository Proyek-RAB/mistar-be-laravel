<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\InteractsWithMedia;

class Infrastructure extends Model
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

    const THUMBNAIL_IMAGES = 'THUMBNAIL_IMAGES';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'sub_type',
        'status',
        'approved_status',
        'detail',
    ];

    protected $casts = [
        'approved_status' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::THUMBNAIL_IMAGES);
    }
}
