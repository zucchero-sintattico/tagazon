<?php

class Buyer {
    const tableName = 'buyers';
    const fields = ['email' => 's', 'password' => 's', 'name' => 's', 'surname' => 's'];
}

class Seller {
    const tableName = 'sellers';
    const fields = ['email' => 's', 'password' => 's', 'rag_soc' => 's', 'piva' => 's'];
}

class Category {
    const tableName = 'categories';
    const fields = ['name' => 's', 'description' => 's'];
}

class CreditCard {
    const tableName = 'buyers';
    const fields = ['owner' => 's', 'number' => 's', 'expiration' => 's', 'cvv' => 's', 'buyer' => 'i'];
}

class Tag {
    const tableName = 'tags';
    const fields = ['name' => 's', 'description' => 's', 'seller' => 'i', 'price' => 'f', 'sale_price' => 'f', 'image' => 's'];
}

class TagCategory {
    const tableName = 'tag_categories';
    const fields = ['tag' => 'i', 'category' => 'i'];
}

class Notification {
    const tableName = 'notifications';
    const fields = [ 'order' => 'i', 'buyer' => 'i', 'timestamp' => 's', 'message' => 's', 'seen' => 'b'];
}

class Order {
    const tableName = 'orders';
    const fields = ['buyer' => 'i', 'timestamp' => 's', 'status' => 's', 'amount' => 'f'];
}

class OrderTag{
    const tableName = 'order_tags';
    const fields = ['order' => 'i', 'tag' => 'i', 'quantity' => 'i'];
}

class Payment{
    const tableName = 'payments';
    const fields = ['order' => 'i', 'creditcard' => 'i', 'timestamp' => 's'];
}

class ShoppingCart {
    const tableName = 'shoppingcarts';
    const fields = ['buyer' => 'i'];
}

class ShoppingCartTag {
    const tableName = 'shoppingcart_tags';
    const fields = ['tag' => 'i', 'shoppingcart' => 'i', 'quantity' => 'i'];
}

class Wishlist {
    const tableName = 'wishlists';
    const fields = ['name' => 's', 'buyer' => 'i'];
}

class WishlistTag {
    const tableName = 'wishlist_tags';
    const fields = ['tag' => 'i', 'wishlist' => 'i'];
}



?>