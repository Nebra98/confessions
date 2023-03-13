<?php

namespace App\Http\Controllers;

use App\Models\Confession;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConfessionController extends Controller
{
    /**
     * @return View
     */
    public function index() : View
    {
        $confessions = Confession::latest()->paginate(5);

        return view('confessions.index')->with('confessions', $confessions);
    }

    /**
     * @return View
     */
    public function create() : View
    {
        return view('confessions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formFields = $request->validate([
           'user_name' => 'required',
            'confession' => 'required|max:1000'
        ]);

        Confession::create($formFields);

        return redirect('/')->with('success', 'Ispovijest je uspješno kreirana!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
