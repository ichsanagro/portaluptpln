<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserHseController extends Controller
{
    public function dashboard()
    {
        return view('hse.hse_dashboard');
    }
}