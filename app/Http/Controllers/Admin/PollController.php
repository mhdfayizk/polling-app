<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poll;
use Illuminate\Http\Request;

class PollController extends Controller
{
    public function index()
    {
        $polls = Poll::latest()->paginate(10);
        return view('admin.polls.index', compact('polls'));
    }

    public function create()
    {
        return view('admin.polls.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'options' => 'required|array|min:2|max:5',
            'options.*' => 'required|string|max:255',
        ]);

        $poll = Poll::create(['question' => $validated['question']]);

        foreach ($validated['options'] as $optionText) {
            $poll->options()->create(['name' => $optionText]);
        }

        return redirect()->route('admin.polls.index')->with('success', 'Poll created successfully.');
    }

    public function show(Poll $poll)
    {
        $poll->load('options.votes');
        return view('admin.polls.show', compact('poll'));
    }


    public function edit(Poll $poll)
    {
        $poll->load('options');
        return view('admin.polls.edit', compact('poll'));
    }

    public function update(Request $request, Poll $poll)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'options' => 'required|array|min:2|max:5',
            'options.*' => 'required|string|max:255',
        ]);
        
        $poll->update(['question' => $validated['question']]);

        // Simple approach: delete old options and create new ones
        $poll->options()->delete(); 

        foreach ($validated['options'] as $optionText) {
            $poll->options()->create(['name' => $optionText]);
        }

        return redirect()->route('admin.polls.index')->with('success', 'Poll updated successfully.');
    }

    public function destroy(Poll $poll)
    {
        $poll->delete();
        return redirect()->route('admin.polls.index')->with('success', 'Poll deleted successfully.');
    }
}