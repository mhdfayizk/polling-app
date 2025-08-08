<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function store(Request $request, Poll $poll)
    {
        $request->validate([
            'option_id' => ['required', 'exists:options,id'],
        ]);

        // Check if the option belongs to the poll
        $option = $poll->options()->findOrFail($request->option_id);

        // Check if user has already voted
        $existingVote = Vote::where('user_id', auth()->id())
                              ->where('poll_id', $poll->id)
                              ->first();

        if ($existingVote) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'You have already voted on this poll.'], 409);
            }
            return back()->with('error', 'You have already voted on this poll.');
        }

        Vote::create([
            'user_id' => auth()->id(),
            'option_id' => $option->id,
            'poll_id' => $poll->id,
        ]);

        // For AJAX requests, return updated poll data
        if ($request->expectsJson()) {
            $poll->load('options.votes'); // Reload relations to get updated counts
            $results = $poll->options->map(function ($option) {
                return [
                    'name' => $option->name,
                    'votes' => $option->votes->count(),
                ];
            });
            return response()->json([
                'message' => 'Vote cast successfully!',
                'results' => $results,
            ]);
        }

        return redirect()->route('polls.show', $poll)->with('success', 'Thank you for voting!');
    }
}