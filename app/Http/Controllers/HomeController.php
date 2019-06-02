<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       
        $rol= auth()->user()->rol;
    
        switch ($rol) {
        case 0:
            
            return view('home');
            break;
        case 1:
            return view('home_1');
            break;
        case 2:
            return view('home_2');
            break;


        default:
            return 'listo';
            return view('home');
            break;
        }
        
       
    }
}
