<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $order_id
 * @property string $name
 * @property string $media_link
 * @property string $extension
 * @property int $remember_token
 * @property int $status
 * @property int $archived
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class NilOrderDoc extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'order_id', 'name', 'media_link', 'extension', 'remember_token', 'status', 'archived', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The connection name for the model.
     * 
     * @var string
     */
    protected $connection = 'mysql';

}
