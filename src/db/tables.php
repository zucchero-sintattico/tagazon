<?php

require_once(__DIR__ . '/entity.php');

class Buyer extends Entity{
    const tableName = 'buyers';
    const fields = ['email' => 's', 'password' => 's', 'name' => 's', 'surname' => 's'];
}

class Seller extends Entity {
    const tableName = 'sellers';
    const fields = ['email' => 's', 'password' => 's', 'rag_soc' => 's', 'piva' => 's'];
}

class Category extends Entity {
    const tableName = 'categories';
    const fields = ['name' => 's', 'description' => 's'];
}

class CreditCard extends Entity {
    const tableName = 'buyers';
    const fields = ['owner' => 's', 'number' => 's', 'expiration' => 's', 'cvv' => 's', 'buyer' => 'i'];
}

class Tag extends Entity {
    const tableName = 'tags';
    const fields = ['name' => 's', 'description' => 's', 'seller' => 'i', 'price' => 'd', 'sale_price' => 'd', 'image' => 's'];
}

class TagCategory extends Entity {
    const tableName = 'tag_categories';
    const fields = ['tag' => 'i', 'category' => 'i'];
}

class Notification extends Entity {
    const tableName = 'notifications';
    const fields = [ 'order' => 'i', 'buyer' => 'i', 'timestamp' => 's', 'message' => 's', 'seen' => 'b'];
}

class Order extends Entity {
    const tableName = 'orders';
    const fields = ['buyer' => 'i', 'timestamp' => 's', 'status' => 's', 'amount' => 'd'];
}

class OrderTag extends Entity {
    const tableName = 'order_tags';
    const fields = ['order' => 'i', 'tag' => 'i', 'quantity' => 'i'];
}

class Payment extends Entity {
    const tableName = 'payments';
    const fields = ['order' => 'i', 'creditcard' => 'i', 'timestamp' => 's'];
}

class ShoppingCart extends Entity {
    const tableName = 'shoppingcarts';
    const fields = ['buyer' => 'i'];
}

class ShoppingCartTag extends Entity {
    const tableName = 'shoppingcart_tags';
    const fields = ['tag' => 'i', 'shoppingcart' => 'i', 'quantity' => 'i'];
}

class Wishlist extends Entity {
    const tableName = 'wishlists';
    const fields = ['name' => 's', 'buyer' => 'i'];
}

class WishlistTag extends Entity {
    const tableName = 'wishlist_tags';
    const fields = ['tag' => 'i', 'wishlist' => 'i'];
}



?>