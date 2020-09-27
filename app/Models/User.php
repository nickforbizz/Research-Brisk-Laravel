<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $email
 * @property string $remember_token
 * @property int $user_level
 * @property string $names
 * @property string $password
 * @property string $image_file
 * @property int $status
 * @property int $archived
 * @property string $admin
 * @property string $created_at
 * @property string $updated_at
 * @property string $email_verified_at
 */
class User extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['email', 'remember_token', 'user_level', 'names', 'password', 'image_file', 'status', 'archived', 'admin', 'created_at', 'updated_at', 'email_verified_at'];

    /**
     * The connection name for the model.
     * 
     * @var string
     */
    protected $connection = 'mysql';

}
