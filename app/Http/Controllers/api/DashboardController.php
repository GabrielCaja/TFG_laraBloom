<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
    // Aquí podemos pasar datos necesarios al dashboard
    return view('dashboard', ['apiData' => []]);
    }
}