<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Poll;

class PollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    protected $model = Poll::class;
    public function run(): void
    {
        // Create 30 polls
        Poll::factory(30)->create();
    }
}
