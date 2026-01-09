<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminHseController extends Controller
{
    public function dashboard()
    {
        return view('hse.admin_dashboard');
    }
}