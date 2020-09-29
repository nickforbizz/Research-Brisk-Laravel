<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $order_category_id
 * @property int $order_format_id
 * @property int $order_language_id
 * @property string $title
 * @property string $email
 * @property string $pages
 * @property string $wordcount
 * @property string $notes
 * @property string $description
 * @property int $status
 * @property int $archived
 * @property string $created_at
 * @property string $updated_at
 * @property OrderCategory $orderCategory
 * @property OrderFormat $orderFormat
 * @property OrderLanguage $orderLanguage
 * @property GuestOrderDoc[] $guestOrderDocs
 */
class GuestOrder extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['order_category_id', 'order_format_id', 'order_language_id', 'title', 'email', 'pages', 'wordcount', 'notes', 'description', 'status', 'archived', 'created_at', 'updated_at'];

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function guestOrderDocs()
    {
        return $this->hasMany('App\Models\GuestOrderDoc', 'order_id');
    }
}
