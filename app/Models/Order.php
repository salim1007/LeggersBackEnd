<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'firstname', 'lastname', 'email', 'phone', 'country', 'city', 'state', 'zip', 'postalcode', 'payment_id', 'payment_mode', 'tracking_no', 'status', 'remark'
    ];

    public function orderitems()
    {

        return $this->hasMany(Orderitem::class, 'order_id', 'id');
    }
}
