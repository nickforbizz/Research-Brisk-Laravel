<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $order_category_id
 * @property int $order_format_id
 * @property int $user_id
 * @property int $order_language_id
 * @property int $pages
 * @property int $word_count
 * @property string $order_number
 * @property string $title
 * @property string $notes
 * @property string $email
 * @property int $status
 * @property string $nil
 * @property int $archived
 * @property string $created_at
 * @property string $updated_at
 */
class NilOrder extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['order_category_id', 'order_format_id', 'user_id', 'order_language_id', 'pages', 'word_count', 'order_number', 'title', 'notes', 'email', 'status', 'nil', 'archived', 'created_at', 'updated_at'];

    /**
     * The connection name for the model.
     * 
     * @var string
     */
    protected $connection = 'mysql';

}
