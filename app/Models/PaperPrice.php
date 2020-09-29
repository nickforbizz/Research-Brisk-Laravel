<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $price
 * @property string $pages
 * @property string $description
 * @property int $archived
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class PaperPrice extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'price', 'pages', 'description', 'archived', 'status', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
