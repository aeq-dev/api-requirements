<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PriceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            //'id' => $this->id,
            'original' => $this->original,
            'final' => $this->final,
            'discount_percentage' => $this->discount_percentage ? $this->discount_percentage . '%' : null,
            'currency' => $this->currency->code,
        ];
    }
}
