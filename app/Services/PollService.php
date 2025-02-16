<?php

namespace App\Services;

use App\Models\Poll;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PollService
{
    public function createPoll(array $data): Poll
    {
        DB::beginTransaction();
        try {
            $data['user_id'] = auth()->id();
            $poll = Poll::create($data);

            if (!empty($data['options'])) {
                $options = $data['options'];

                foreach ($options as $option) {
                    $poll->options()->create(['option' => $option['option']]);
                }
            }

            DB::commit();
            return $poll;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getPoll(int $id): Poll
    {
        return Poll::findOrFail($id);
    }

    public function getPolls()
    {
        return Poll::query()
            ->with('options')
            ->withTotalVotes()
            ->get();
    }

    public function getUserPolls()
    {
        $userId = auth()->id();

        return Poll::query()
            ->where('user_id', $userId)
            ->withTotalVotes()
            ->get();
    }

    public function getPollDetails(Poll $poll): Poll
    {
        return $poll->withDetails()->first();
    }

    public function vote(Poll $poll, int $optionId): Poll
    {
        $option = $poll->options()->findOrFail($optionId);
        $option->increment('votes');
        auth()->user()->polls()->attach($poll);

        return $poll;
    }

    public function deletePoll(Poll $poll): void
    {
        $poll->delete();
    }

    public function updatePoll(Poll $poll, array $data): Poll
    {
        DB::beginTransaction();
        try {
            $poll->update($data);

            if (!empty($data['options'])) {
                $options = $data['options'];

                $createdOrUpdatedOptionIds = [];

                foreach ($options as $option) {
                    if (isset($option['id'])) {
                        $poll->options()->findOrFail($option['id'])->update($option);
                        $createdOrUpdatedOptionIds[] = $option['id'];
                    } else {
                        $createdOption = $poll->options()->create(['option' => $option['option']]);
                        $createdOrUpdatedOptionIds[] = $createdOption->id;
                    }
                }


                if (!empty($createdOrUpdatedOptionIds)) {
                    $poll->options()
                        ->whereNotIn('id', $createdOrUpdatedOptionIds)
                        ->delete();
                }
            }

            DB::commit();
            return $poll;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function filterUndefinedOptions(array $options): array
    {
        return array_filter($options, function ($option) {
            return isset($option['id']);
        });
    }
}
