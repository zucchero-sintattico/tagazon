<?php

require_once __DIR__ . "/../../require.php";

class ShoppingCartsTagsApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(ShoppingCartTag::class, Api::BUYER, Api::BUYER, Api::BUYER, Api::BUYER);
    }


    public function onPost($params, $server=false)
	{
        $params["buyer"] = $_SESSION["user"]["id"];
		$res = $this->entity::create($params);
		$this->setResponseCode(!is_null($res) ? 201 : 400);
		$this->setResponseMessage(!is_null($res) ? "Created" : "Bad request");
		$this->setResponseData(!is_null($res) ? $res : []);
	}

    public function canAccess($element)
    {
        $buyer = $element["buyer"];
        $buyer = BuyersApi::get(["id" => $buyer])["data"];
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