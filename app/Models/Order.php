<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $order_category_id
 * @property int $order_format_id
 * @property int $order_language_id
 * @property string $title
 * @property string $email
 * @property string $pages
 * @property string $wordcount
 * @property string $duedate
 * @property string $notes
 * @property string $description
 * @property int $status
 * @property int $archived
 * @property string $created_at
 * @property string $updated_at
 * @property OrderCategory $orderCategory
 * @property OrderFormat $orderFormat
 * @property OrderLanguage $orderLanguage
 * @property User $user
 */
class Order extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'order_category_id', 'order_format_id', 'order_language_id', 'title', 'email', 'pages', 'wordcount', 'duedate', 'notes', 'description', 'status', 'archived', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderCategory()
    {
        return $this->belongsTo('App\Models\OrderCategory');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderFormat()
    {
        return $this->belongsTo('App\Models\OrderFormat');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderLanguage()
    {
        return $this->belongsTo('App\Models\OrderLanguage');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
