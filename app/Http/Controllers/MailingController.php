<?php

namespace App\Http\Controllers;

use App\Mailing;
use App\MailingList;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MailingController extends Controller
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
        return view('mailings.index')->with('mailings', Mailing::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mailings.create')->with('lists', MailingList::all());
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
            'name' => 'required|unique:mailings',
            'text' => 'required',
            'attachments' => 'nullable',
            'mailing_list_id' => 'required|integer',
            'send_at' => 'nullable'
        ]);

        Mailing::create($validated);

        return redirect()->route('mailings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mailing  $mailing
     * @return \Illuminate\Http\Response
     */
    public function show(Mailing $mailing)
    {
        $mailing->load(['mailingList']);
        return view('mailings.show')->with('mailing', $mailing);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mailing  $mailing
     * @return \Illuminate\Http\Response
     */
    public function edit(Mailing $mailing)
    {
        return view('mailings.edit')
            ->with('mailing', $mailing)
            ->with('lists', MailingList::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mailing  $mailing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mailing $mailing)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                Rule::unique('mailings')->ignore($mailing->id)
            ],
            'text' => 'required',
            'attachments' => 'nullable',
            'mailing_list_id' => 'required|integer',
            'send_at' => 'nullable'
        ]);

        $mailing->fill($validated);
        $mailing->save();

        return redirect()->route('mailings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mailing $mailing
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Mailing $mailing)
    {
        $mailing->delete();
        return redirect()->route('mailings.index');
    }

    /**
     * Send mailing to subscribers of mailing list
     *
     * @param Mailing $mailing
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send(Mailing $mailing) {
        $mailing->send();
        return redirect()->route('mailings.index');
    }
}
