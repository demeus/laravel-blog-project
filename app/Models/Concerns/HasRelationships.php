<?php

namespace App\Models\Concerns;

use App\Models\Tag;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasRelationships
{
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags() : MorphMany
    {
        return $this->morphMany(Tag::class, 'taggable');
    }

    //    public function categories() : BelongsToMany
    //    {
    //        return $this->belongsToMany(Category::class);
    //    }

    public function author() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_like')->withTimestamps();
    }
}
