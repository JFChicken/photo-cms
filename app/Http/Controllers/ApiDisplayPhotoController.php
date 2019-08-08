<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiDisplayPhotoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('api');
    }

    public function foo(){

        dd('here');
    }
}
