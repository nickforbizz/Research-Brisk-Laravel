<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $blog_id
 * @property int $user_id
 * @property string $comment
 * @property int $archived
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property Blog $blog
 */
class BlogsComment extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['blog_id', 'user_id', 'comment', 'archived', 'status', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function blog()
    {
        return $this->belongsTo('App\Models\Blog');
    }
}
