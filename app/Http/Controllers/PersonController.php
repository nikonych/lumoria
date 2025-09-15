<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\View\View;

class PersonController extends Controller
{
    public function index(): View
    {
        return view('pages.people');
    }

    public function all(): View
    {
        return view('pages.people.all-people');
    }
}
