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
        $user = $request->user();

        $vendor = $user->vendor;

        // Return different format of Order Line Item for each Vendor
        return match ($vendor->api_format) {
            'marco_fine_arts' => $this->formatMarcoFineArts(),
            default => $this->formatDefault(),
        };
    }

    /**
     * Custom format of Order Line Item resource for Marco Fine Arts vendor
     *
     * @return array
     */
    private function formatMarcoFineArts()
    {
        return [
            'external_order_line_item_id' => strval($this->id), // They want string instead of number for this field
            'product_id' => strval($this->product_id), // They want string instead of number for this field
            'quantity' => strval($this->quantity), // They want string instead of number for this field
            'image_url' => $this->product()->exists() ?
                ($this->product->creative()->exists() ?
                    $this->product->creative->image_url
                    : null
                )
                : null,
        ];
    }

    /**
     * Custom format of Order Line Item resource for other vendors
     *
     * @return array
     */
    private function formatDefault()
    {
        return [
            'order_line_item_id' => $this->id,
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
