<?php

namespace App\Http\Controllers;

use App\Http\Requests\PollRequest;
use App\Models\Poll;
use Illuminate\Http\Request;
use App\Services\PollService;
use Inertia\Inertia;

class PollController extends Controller
{
    public function __construct(private readonly PollService $pollService)
    {
    }

    public function index()
    {
        $polls = $this->pollService->getPolls();

        return Inertia::render('Polls/Index', [
            'polls' => $polls,
        ]);
    }

    public function create()
    {
        return Inertia::render('Polls/Create');
    }

    public function edit()
    {
        return Inertia::render('Polls/Edit');
    }

    public function show(Poll $poll)
    {
        $poll->load('options');
        $poll->loadSum('options', 'votes');
        $poll->has_voted = $poll->hasUserVoted();

        return Inertia::render('Polls/Show', [
            'poll' => $poll,
        ]);
    }

    public function store(PollRequest $request)
    {
        $data = $request->validated();

        $poll = $this->pollService->createPoll($data);

        return to_route('polls.index');
    }

    public function update(Poll $poll, PollRequest $request)
    {
        $data = $request->validated();
        $poll = $this->pollService->updatePoll($poll, $data);

        return to_route('polls.index');
    }

    public function destroy(Poll $poll)
    {
        $this->pollService->deletePoll($poll);

        return to_route('polls.index');
    }

    public function getUserPolls()
    {
        $polls = $this->pollService->getUserPolls();

        return Inertia::render('Polls/UserPolls', [
            'polls' => $polls,
        ]);
    }

    public function vote(Request $request, Poll $poll)
    {
        $request->validate([
            'option_id' => 'required|exists:poll_options,id',
        ]);

        $optionId = $request->input('option_id');

        $poll = $this->pollService->vote($poll, $optionId);

        return to_route('polls.show', $poll);
    }
}
