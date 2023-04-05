<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['article_id', 'subject', 'body'];


    /**
     * Get the post that owns the comment.
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
