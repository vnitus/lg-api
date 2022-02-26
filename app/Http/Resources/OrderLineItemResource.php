<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderLineItemResource extends JsonResource
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
            'external_order_line_item_id' => $this->id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'image_url' => $this->product()->exists() ?
                ($this->product->creative()->exists() ?
                    $this->product->creative->image_url
                    : null
                )
                : null,
        ];
    }
}
