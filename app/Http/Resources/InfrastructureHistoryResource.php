<?php

namespace App\Http\Resources;

use App\Models\Infrastructure;
use App\Models\InfrastructureSubType;
use App\Models\InfrastructureType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InfrastructureHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $thumbnailImages = $this->getMedia(Infrastructure::THUMBNAIL_IMAGES);
        $thumbnailImageUrls = [];
        foreach ($thumbnailImages as $file) {
            $thumbnailImageUrls[] = $file->getFullUrl();
        }

        $details = json_decode(json_decode($this->details));
        $details->description->contact_person = substr_replace($details->description->contact_person, '*****', 0, 5);

        $subType = InfrastructureSubType::query()->where('name', $this->sub_type)->first();
        $subTypeIconUrl = $subType->icon_url;

        $type = InfrastructureType::query()->where('name', $this->type)->first();
        $typeIconUrl = $type->icon_url;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'type_icon_url' => $typeIconUrl,
            'sub_type' => $this->sub_type,
            'sub_type_icon_url' => $subTypeIconUrl,
            'address' => $details->address,
        ];
    }
}
