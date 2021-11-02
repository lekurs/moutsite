<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class FirstController
{
    public function index()
    {
        return view('pages.admin.index', [

        ]);
    }
}
