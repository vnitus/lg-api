<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = $request->user();

        $vendor = $user->vendor;

        return [
            'external_order_id' => $this->id,
            'buyer_first_name' => $this->first_name,
            'buyer_last_name' => $this->last_name,
            'buyer_shipping_address_1' => $this->address_1,
            'buyer_shipping_address_2' => $this->address_2,
            'buyer_shipping_city' => $this->city,
            'buyer_shipping_state' => $this->state,
            'buyer_shipping_postal' => $this->postal_code,
            'buyer_shipping_country' => $this->country,
            'print_line_items' => OrderLineItemResource::collection($vendor->orderLineItems),
        ];
    }
}
