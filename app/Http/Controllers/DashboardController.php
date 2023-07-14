<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function role() {
        return view('role');
    }

    public function user() {
        return view('user');
    }

    public function menu() {
        return view('menu');
    }
}
