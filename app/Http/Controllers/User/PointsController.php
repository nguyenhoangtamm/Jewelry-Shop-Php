<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PointsController extends Controller
{
    public function index(Request $request)
    {
        // Placeholder: render a simple points page
        return view('user.points.index');
    }
}
