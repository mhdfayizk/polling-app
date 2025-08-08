<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\Http\Request;

class PollController extends Controller
{
    /**
     * Display a listing of all polls.
     */
    public function index()
    {
        $polls = Poll::with('options')->latest()->get();
        return view('polls.index', compact('polls'));
    }

    /**
     * Display a specific poll with options and results.
     */
    public function show(Poll $poll)
    {
        $poll->load('options.votes');
        return view('polls.show', compact('poll'));
    }
}