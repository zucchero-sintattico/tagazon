<?php

require_once __DIR__ . "/../../require.php";

class ShoppingCartsTagsApi extends EntityApi {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->get(ApiAuth::BUYER)
            ->post(ApiAuth::BUYER)
            ->put(ApiAuth::BUYER)
            ->delete(ApiAuth::BUYER)
            ->build();
        parent::__construct(ShoppingCartTag::class, $auth);
    }


    public function onPost($params, $server=false)
	{
        $params["buyer"] = $_SESSION["user"]["id"];
		$res = $this->entity::create($params);
        return $res ? Response::created($res) : Response::badRequest();
	}

    public function canAccess($element)
    {
        $buyer = $element["buyer"];
        $buyer = BuyersApi::get(["id" => $buyer])->getData();
        return count($buyer) == 1;
    }

    public function canCreate($params)
    {
        return $this->canAccess($params);
    }

    public function canModify($element)
    {
        return $this->canAccess($element);
    }

    public function canDelete($element)
    {
        return $this->canAccess($element);
    }

}

?>