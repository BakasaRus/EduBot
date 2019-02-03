<?php

namespace App\Http\Controllers;

use App\MailingList;
use App\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MailingListController extends Controller
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
        return view('lists.index')->with('lists', MailingList::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subscribers = Subscriber::all();
        return view('lists.create')->with('subscribers', $subscribers);
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
            'name' => 'required|unique:mailing_lists',
            'subscribers' => 'nullable'
        ]);

        $list = new MailingList();
        $list->name = $validated['name'];
        $list->save();
        $list->subscribers()->attach($validated['subscribers'] ?? null);

        return redirect()->route('lists.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MailingList  $mailingList
     * @return \Illuminate\Http\Response
     */
    public function show(MailingList $mailingList)
    {
        $mailingList->load(['mailings', 'subscribers']);
        return view('lists.show')->with('list', $mailingList);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MailingList  $mailingList
     * @return \Illuminate\Http\Response
     */
    public function edit(MailingList $mailingList)
    {
        return view('lists.edit')
            ->with('list', $mailingList)
            ->with('subscribers', Subscriber::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MailingList  $mailingList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MailingList $mailingList)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                Rule::unique('mailing_lists')->ignore($mailingList->id),
            ],
            'subscribers' => 'nullable'
        ]);

        $mailingList->name = $validated['name'];
        $mailingList->save();
        $mailingList->subscribers()->sync($validated['subscribers'] ?? null);

        return redirect()->route('lists.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MailingList  $mailingList
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(MailingList $mailingList)
    {
        if ($mailingList->id == 1)
            return redirect()->route('lists.index');

        $mailingList->mailings()->delete();
        $mailingList->delete();

        return redirect()->route('lists.index');
    }
}
