<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $blog_id
 * @property string $host
 * @property string $created_at
 * @property string $updated_at
 */
class BlogView extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['blog_id', 'host', 'created_at', 'updated_at'];

    /**
     * The connection name for the model.
     * 
     * @var string
     */
    protected $connection = 'mysql';

}
