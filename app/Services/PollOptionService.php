<?php

namespace App\Services;

use App\Models\PollOption;

class PollOptionService
{
    public function createPollOption(array $data): PollOption
    {
        return PollOption::create($data);
    }

    public function updatePollOption(PollOption $option, array $data): PollOption
    {
        $option->update($data);
        return $option;
    }

    public function deletePollOption(PollOption $option): void
    {
        $option->delete();
    }
}