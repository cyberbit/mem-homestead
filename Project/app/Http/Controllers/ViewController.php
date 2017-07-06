<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Note;
use Auth;

class ViewController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api');
    }
    
    /**
     * Test Blade view
     */
    public function blade(Request $request) {
        return view('blade', ['name' => 'Chad']);
    }
    
    /**
     * Dashboard view
     */
    public function dashboard(Request $request) {
        return view('dashboard');
    }
    
    /**
     * Login view
     */
    public function login(Request $request, $errors = []) {
        return view('login', $errors);
    }
}
