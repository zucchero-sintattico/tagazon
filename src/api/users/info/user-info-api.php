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
                $tag = TagsApi::get(["id" => $orderTag["tag"], "seller" => $user["id"]], true);
                if ($tag->getCode() == 200){
                    $data = $tag->getData()[0];
                    $balance += ($data["sale_price"] !== null ? $data["sale_price"] : $data["price"]) * $orderTag["quantity"];
                }
            }
            $user["balance"] = $balance;
        }

        return Response::ok($user, "User info");
    }
    
}

?>