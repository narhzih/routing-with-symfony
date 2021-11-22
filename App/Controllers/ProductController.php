<?php

namespace App\Controllers;


class ProductController
{

    public function getProduct($id, $userId) {
        echo "<h1>Trying to get product with id {$id}</h1>";
        echo "<h1>Trying to get product with id {$userId}</h1>";
    }
}