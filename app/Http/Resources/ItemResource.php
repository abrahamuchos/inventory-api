<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int                             $id
 * @property string                          $name
 * @property int                             $stock
 * @property string                          $sku
 * @property float                           $retail_price
 * @property int                             $user_id
 * @property int                             $reorder_level
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User           $user
 */
class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->user_id,
            'name' => $this->name,
            'stock' => $this->stock,
            'sku' => $this->sku,
            'reorderLevel' => $this->reorder_level,
            'user' => new UserResource($this->whenLoaded('user'))
        ];
    }
}
