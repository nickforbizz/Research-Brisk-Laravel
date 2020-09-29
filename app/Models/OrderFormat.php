<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $description
 * @property string $remember_token
 * @property int $active
 * @property int $archived
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property GuestOrder[] $guestOrders
 * @property Order[] $orders
 */
class OrderFormat extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'description', 'remember_token', 'active', 'archived', 'status', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function guestOrders()
    {
        return $this->hasMany('App\Models\GuestOrder');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
}
