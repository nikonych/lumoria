<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Person;
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

    public function personDetails(Person $person): View
    {
        $person = $person->load('languages');

        $similarPeople = Person::whereHas('departments', function ($query) use ($person) {
            $query->whereIn('departments.id', $person->departments->pluck('id'));
        })
        ->where('id', '!=', $person->id)->get();

        return view('pages.people.details', compact('person', 'similarPeople'));
    }

    public function withAwards(): View
    {
        return view('pages.people.with-awards');
    }

    public function showByDepartmentSlug(string $slug): View
    {
        $department = Department::where('name', $slug)->firstOrFail();

        return view('pages.people.all-people', [
            'preselectedDepartmentId' => $department->id
        ]);
    }





}
