<?php

require_once __DIR__ . "/../../require.php";

class OrdersApi extends EntityApi {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->get(ApiAuth::BUYER)
            ->post(ApiAuth::BUYER)
            ->build();
        parent::__construct(Order::class, $auth);
    }

    public function canAccess($element)
    {
        return $element["buyer"] == $_SESSION["user"]["id"];
    }

    public function onPost($params, $server=false) {


        $buyer = $_SESSION["user"]["id"];

        $shoppingCartItems = ShoppingCartsTagsApi::get(['buyer' => $buyer])->getData();
        if (count($shoppingCartItems) == 0) {
            return Response::badRequest("No items in shopping cart");
        }

        $status = "RECEIVED";
        $items = ShoppingCartsTagsApi::get([])->getData();
        
        $amount = array_reduce($items, function($acc, $item) {
            $tag = TagsApi::get(['id' => $item['tag']])->getData()[0];
            return $acc + ($tag["sale_price"] != null ? $tag["sale_price"] : $tag["price"]) * $item['quantity'];
        }, 0);

        $res = $this->entity::create([
            "buyer" => $buyer,
            "status" => $status,
            "amount" => $amount
        ]);

        if ($res) {
            $orderId = $res["id"];
            $orderTags = array_map(function($item) use ($orderId) {
                return [
                    "order" => $orderId,
                    "tag" => $item["tag"],
                    "quantity" => $item["quantity"]
                ];
            }, $items);
            foreach ($orderTags as $orderTag) {
                $result = OrdersTagsApi::post($orderTag, true);
                if ($result->getCode() != 201) {
                    return Response::badRequest("Error creating order tag");
                }
            }
        } else {
            return Response::badRequest("Error creating order");
        }

       
        foreach ($shoppingCartItems as $item) {
            $result = ShoppingCartsTagsApi::delete($item, true);
            if ($result->getCode() != 200) {
                return Response::badRequest("Error deleting shopping cart item");
            }
        }

        return Response::created($res); 

    }
}

?>