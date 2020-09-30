<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $email
 * @property string $subject
 * @property string $message
 * @property int $status
 * @property int $archived
 * @property string $created_at
 * @property string $updated_at
 */
class Enquiry extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'enquiry';

    /**
     * @var array
     */
    protected $fillable = ['email', 'subject', 'message', 'status', 'archived', 'created_at', 'updated_at'];

}
