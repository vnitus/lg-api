<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Spatie\ArrayToXml\ArrayToXml;

class OrderController extends Controller
{
    /**
     * @param Request $request
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Authenticated user (via Sanctum)
        $user = $request->user();

        // Retrieved Vendor of this User
        $vendor = $user->vendor;

        // Reject an invalid vendor (or authenticated user without a vendor)
        if (!$vendor) {
            return false;
        }

        // XML
        if ($vendor->api_format === 'xml') {
            $output = [];

            // Retrieve all Order Line Items of this Vendor, then group by order_id
            $orderLineItemsByOrderId = $vendor->orderLineITems->groupBy('order_id');

            if (!empty($orderLineItemsByOrderId)) {
                // Initiate the array for XML output
                $output = [
                    'order' => []
                ];

                // Walk through each Order and its Order Line Items
                foreach ($orderLineItemsByOrderId as $orderId => $orderLineItems) {
                    // Retrieve the Order
                    $order = Order::findorFail($orderId);

                    // Compose the order node
                    $orderNode = [
                        'order_number' => $orderId,
                        'customer_data' => [
                            'first_name' => $order->first_name,
                            'last_name' => $order->last_name,
                            'address_1' => $order->address_1,
                            'address_2' => $order->address_2,
                            'city' => $order->city,
                            'state' => $order->state,
                            'zip' => $order->postal_code,
                            'country' => $order->country,
                        ]
                    ];

                    // If the Order has some Order Line Items
                    if ($orderLineItems->count() > 0) {
                        // Compose the items node
                        $orderNode['items'] = [
                            'item' => []
                        ];

                        // Walk through each Order Line Item to compose each item node
                        foreach ($orderLineItems as $orderLineItem) {
                            $orderNode['items']['item'][] = [
                                'order_line_item_id' => $orderLineItem->id,
                                'product_id' => optional($orderLineItem->product)->id,
                                'quantity' => $orderLineItem->quantity,
                                'image_url' => optional(optional($orderLineItem->product)->creative)->image_url,
                            ];
                        }
                    }

                    $output['order'][] = $orderNode;
                }
            }

            return response(ArrayToXml::convert($output, 'orders'), 200, [
                'Content-Type' => 'application/xml'
            ]);
        }
        // JSON
        else {
            return OrderResource::collection($vendor->orderLineItems->map(function ($orderLineItem) {
                return $orderLineItem->order;
            }));
        }
    }
}
