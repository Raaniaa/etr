<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class favouriteBlogger extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id','blooger_id',
    ];
    protected $hidden = ['created_at','updated_at'];
}
