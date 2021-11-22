<?php

namespace App\Controllers;


class ProductController
{

    public function getProduct($id) {
        echo "<h1>Trying to get product with id {$id}</h1>";
    }
}