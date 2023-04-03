<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'item_name',
        'item_price',
        'item_detail',
        'item_image',
        'item_total_num',
        'ctg_id',
        'item_num',
        'user_id',
        'user_name',
    ];

    protected $primaryKey = 'item_id';
}
