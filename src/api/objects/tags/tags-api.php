<?php

require_once __DIR__ . "/../../require.php";

class TagsApi extends EntityApi {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->get(ApiAuth::OPEN)
            ->post(ApiAuth::SELLER)
            ->put(ApiAuth::SELLER)
            ->delete(ApiAuth::SELLER)
            ->build();
        parent::__construct(Tag::class, $auth);
    }

    public function canModify($element)
    {
        return $element["seller"] == $_SESSION["user"]["id"];
    }

    public function canDelete($element)
    {
        return $this->canModify($element);
    }


    public function onPost($params, $server=true){

        $seller = $_SESSION["user"]["id"];

        $tag = [
            "name" => $params["name"],
            "description" => $params["description"],
            "example" => $params["example"],
            "example_desc" => $params["example_desc"],
            "seller" => $seller,
            "price" => $params["price"],
            "sale_price" => $params["sale_price"]
        ];

        $res = Tag::create($tag);

        if ($res){
            
            $categories = $params["categories"];
            foreach ($categories as $category){
                $tag_category = [
                    "tag" => $res["id"],
                    "category" => $category
                ];
                $resCat = TagsCategoriesApi::post($tag_category, true);
                if ($resCat->getCode() != 201){
                    return Response::badRequest("Error while creating tag category");
                }
            }
            return Response::created($tag);
        } else {
            return Response::badRequest("Cannot create tag");
        }

        
    }
}

?>