<?php

namespace App\Controllers;

class PagesController
{
    public function home() {
        echo "<h1>Welcome to the home page controller</h1>";
    }

    public function about() {
        echo "<h1>Welcome to the about page</h1>";
    }
}