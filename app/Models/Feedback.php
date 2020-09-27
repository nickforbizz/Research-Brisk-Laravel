<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $names
 * @property string $message
 * @property string $email
 * @property int $status
 * @property int $archived
 * @property string $created_at
 * @property string $updated_at
 */
class Feedback extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['names', 'message', 'email', 'status', 'archived', 'created_at', 'updated_at'];

    /**
     * The connection name for the model.
     * 
     * @var string
     */
    protected $connection = 'mysql';

}
