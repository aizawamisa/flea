<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sold_item extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'user_id', 'payment_id'];
}
