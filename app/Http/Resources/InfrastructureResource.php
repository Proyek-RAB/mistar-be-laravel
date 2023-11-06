<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InfrastructureResource extends JsonResource
{
    public static $wrap = 'infrastruktur';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'sub_type' => $this->sub_type,
            'status' => $this->status,
            'approved_status' => $this->approved_status,
            'details' => json_decode(json_decode($this->details)),
            'images' => $this->image,
            'created_by' => $this->user->full_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
