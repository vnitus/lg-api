<?php

namespace App\Http\Resources;

use App\Models\OrderLineItem;
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

        // Return different format of Order for each Vendor
        return match ($vendor->api_format) {
            'marco_fine_arts' => $this->formatMarcoFineArts($vendor),
            default => $this->formatDefault($vendor),
        };
    }

    /**
     * Custom format of Order resource for Marco Fine Arts vendor
     *
     * @param $vendor
     * @return array
     */
    private function formatMarcoFineArts($vendor)
    {
        return [
            'external_order_id' => strval($this->id), // They want string instead of number for this field
            'buyer_first_name' => $this->first_name,
            'buyer_last_name' => $this->last_name,
            'buyer_shipping_address_1' => $this->address_1,
            'buyer_shipping_address_2' => $this->address_2,
            'buyer_shipping_city' => $this->city,
            'buyer_shipping_state' => $this->state,
            'buyer_shipping_postal' => $this->postal_code,
            'buyer_shipping_country' => $this->country,
            'print_line_items' => OrderLineItemResource::collection(OrderLineItem::where([
                'vendor_id' => $vendor->id,
                'order_id' => $this->id
            ])->get()),
        ];
    }

    /**
     * Custom format of Order resource for other vendors
     *
     * @param $vendor
     * @return array
     */
    private function formatDefault($vendor)
    {
        return [
            'order_id' => $this->id,
            'buyer_first_name' => $this->first_name,
            'buyer_last_name' => $this->last_name,
            'buyer_shipping_address_1' => $this->address_1,
            'buyer_shipping_address_2' => $this->address_2,
            'buyer_shipping_city' => $this->city,
            'buyer_shipping_state' => $this->state,
            'buyer_shipping_postal' => $this->postal_code,
            'buyer_shipping_country' => $this->country,
            'order_line_items' => OrderLineItemResource::collection(OrderLineItem::where([
                'vendor_id' => $vendor->id,
                'order_id' => $this->id
            ])->get()),
        ];
    }
}
