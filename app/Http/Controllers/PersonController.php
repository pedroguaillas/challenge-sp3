<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PersonController extends Controller
{
    public function index()
    {
        $people = Person::all();
        return Inertia::render('Person/Index', ['people' => $people]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'identification' => 'required|unique:App\Models\Person,identification|max:10',
            'first_name' => 'required|max:120',
            'last_name' => 'required|max:120',
            'birthdate' => 'required|date',
            'phone' => 'required|unique:App\Models\Person,phone|max:10',
            'civil_status' => 'required',
            'latitude' => 'required|decimal:0,7',
            'longitude' => 'required|decimal:0,7'
        ]);

        $person = new Person($request->input());
        $person->save();
    }

    public function update(Request $request, Person $person)
    {
        $person->update($request->all());
    }

    public function destroy(Person $person)
    {
        $person->delete();
    }
}
