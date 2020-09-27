<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $message
 * @property int $status
 * @property int $archived
 * @property string $created_at
 * @property string $updated_at
 */
class Chat extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'message', 'status', 'archived', 'created_at', 'updated_at'];

    /**
     * The connection name for the model.
     * 
     * @var string
     */
    protected $connection = 'mysql';

}
