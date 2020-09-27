<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property int $user_id
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 */
class BlogTag extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['title', 'user_id', 'status', 'created_at', 'updated_at'];

    /**
     * The connection name for the model.
     * 
     * @var string
     */
    protected $connection = 'mysql';

}
