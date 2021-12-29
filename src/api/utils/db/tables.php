<?php

require_once __DIR__ . "/../../require.php";

class Buyer extends Entity{
    const tableName = 'buyers';
    const fields = ['email' => 's', 'password' => 's', 'name' => 's', 'surname' => 's'];
    const orderBy = 'email';
}

class Seller extends Entity {
    const tableName = 'sellers';
    const fields = ['email' => 's', 'password' => 's', 'rag_soc' => 's', 'piva' => 's'];
    const orderBy = 'email'; 
}

class Category extends Entity {
    const tableName = 'categories';
    const fields = ['name' => 's', 'description' => 's'];
    const orderBy = 'name';
}

class Tag extends Entity {
    const tableName = 'tags';
    const fields = ['name' => 's', 'description' => 's', 'example' => 's', 'example_desc' => 's', 'seller' => 'i', 'price' => 'd', 'sale_price' => 'd'];
    const orderBy = 'name';
}

class TagCategory extends Entity {
    const tableName = 'tag_categories';
    const fields = ['tag' => 'i', 'category' => 'i'];
    const orderBy = 'tag';
}

class Notification extends Entity {
    const tableName = 'notifications';
    const fields = [ 'order' => 'i', 'buyer' => 'i', 'timestamp' => 's', 'title' => 's', 'message' => 's', 'seen' => 'i'];
    const orderBy = 'timestamp';
}

class Order extends Entity {
    const tableName = 'orders';
    const fields = ['buyer' => 'i', 'timestamp' => 's', 'status' => 's', 'amount' => 'd'];
    const orderBy = 'timestamp';
}

class OrderTag extends Entity {
    const tableName = 'order_tags';
    const fields = ['order' => 'i', 'tag' => 'i', 'quantity' => 'i'];
    const orderBy = 'tag';
}

class Payment extends Entity {
    const tableName = 'payments';
    const fields = ['order' => 'i', 'timestamp' => 's', 'card-owner' => 's', 'card-number' => 's', 'card-expiry-year' => 's', 'card-expiry-month' => 's', 'card-cvc' => 's', 'amount' => 'd'];
    const orderBy = 'order';
}

class ShoppingCartTag extends Entity {
    const tableName = 'shoppingcart_tags';
    const fields = ['buyer' => 'i', 'tag' => 'i', 'quantity' => 'i'];
    const orderBy = 'tag';
}

class Wishlist extends Entity {
    const tableName = 'wishlists';
    const fields = ['name' => 's', 'buyer' => 'i'];
    const orderBy = 'name';
}

class WishlistTag extends Entity {
    const tableName = 'wishlist_tags';
    const fields = ['tag' => 'i', 'wishlist' => 'i'];
    const orderBy = 'tag';
}



?>