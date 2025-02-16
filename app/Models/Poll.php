<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'question'];

    public function options(): HasMany
    {
        return $this->hasMany(PollOption::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function hasUserVoted(): bool
    {
        if (!auth()->check()) {
            return false;
        }

        return $this->users()->where('user_id', auth()->id())->exists();
    }

    public function scopeWithTotalVotes(Builder $query): Builder
    {
        return $query
            ->withSum('options', 'votes');
    }
}
