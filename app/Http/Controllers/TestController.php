<?php

namespace App\Http\Controllers;

use App\Test;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TestController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tests.index')->with('tests', Test::withCount('questions')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:tests',
            'description' => 'required',
            'time_limit' => 'required|min:1',
            'max_attempts' => 'required|min:1'
        ]);

        Test::create($validated);

        return redirect()->route('tests.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        return view('tests.show')->with('test', $test->load('questions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        return view('tests.edit')->with('test', $test);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Test $test)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                Rule::unique('tests')->ignore($test->id),
            ],
            'description' => 'required',
            'time_limit' => 'required|min:1',
            'max_attempts' => 'required|min:1'
        ]);

        $test->fill($validated);
        $test->save();

        return redirect()->route('tests.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Test $test
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Test $test)
    {
        $test->delete();
        return redirect()->route('tests.index');
    }

    public function change(Test $test)
    {
        $test->is_available = !$test->is_available;
        $test->save();

        return redirect()->back();
    }
}
