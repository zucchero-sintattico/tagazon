<?php

require_once __DIR__ . "/../../require.php";

class UserInfoApi extends Api {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->get(ApiAuth::OPEN)
            ->build();
        parent::__construct($auth);
    }


    public function onGet($params){
        
        if (!isset($_SESSION["user"])){
            return Response::notFound("User not logged in");
        }

        $user = $_SESSION["user"];
        unset($user["password"]);

        if ($user["type"] == "seller"){
            $balance = 0;
            $orderTags = OrdersTagsApi::get([], true)->getData();
            foreach ($orderTags as $orderTag){
                $tag = TagsApi::get(["id" => $orderTag["tag"]], true)->getData()[0];
                $balance += ($tag["sale_price"] !== null ? $tag["sale_price"] : $tag["price"]) * $orderTag["quantity"];
            }
            $user["balance"] = $balance;
        }

        return Response::ok($user, "User info");
    }
    
}

?>