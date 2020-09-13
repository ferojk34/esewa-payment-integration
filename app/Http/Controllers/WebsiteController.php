<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class WebsiteController extends Controller
{
    public function checkoutForm()
    {         
        return view('website.checkout');
    }
}
