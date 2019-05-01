<?php

namespace App\Http\Controllers;

use App\Subscriber;
use App\Test;
use App\TestResult;
use Illuminate\Http\Request;

class TestResultController extends Controller
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
    public function index(Subscriber $subscriber, Test $test)
    {
        $questions = $subscriber->questions()->where('test_id', $test->id)->get();
        return view('subscribers.testresult')
            ->with('questions', $questions)
            ->with('test', $test)
            ->with('subscriber', $subscriber);
    }

    public function zero(Subscriber $subscriber, Test $test)
    {
        $test_result = TestResult::where('subscriber_id', $subscriber->id)->where('test_id', $test->id)->first();
        $test_result->attempts = 0;
        $test_result->save();

        return redirect()->back();
    }
}
