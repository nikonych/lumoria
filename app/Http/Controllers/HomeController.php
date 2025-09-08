<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        if (Auth::check()) {
            $user = Auth::user();
            return view('pages.home', compact('user'));
        } else {
            return view('pages.home');
        }
    }
}
