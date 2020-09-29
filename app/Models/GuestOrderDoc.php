<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $order_id
 * @property int $user_id
 * @property string $name
 * @property string $media_link
 * @property string $extension
 * @property string $type
 * @property int $remember_token
 * @property int $status
 * @property int $archived
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property GuestOrder $guestOrder
 */
class GuestOrderDoc extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['order_id', 'user_id', 'name', 'media_link', 'extension', 'type', 'remember_token', 'status', 'archived', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function guestOrder()
    {
        return $this->belongsTo('App\Models\GuestOrder', 'order_id');
    }
}
