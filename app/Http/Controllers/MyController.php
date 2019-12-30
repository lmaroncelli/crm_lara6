<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class MyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
  
    public function __construct()
    {
    $this->middleware('auth');

    $colors['30'] = 'lightgreen';
    $colors['27'] = 'hotpink';
    $colors['26'] = 'aqua';
    $colors['10'] = 'yellow';
    $colors['5'] = 'orange';

    View::share('colors', $colors);

    }

}
