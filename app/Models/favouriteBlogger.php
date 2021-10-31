<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class favouriteBlogger extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id','blogger_id',
    ];
    protected $hidden = ['created_at','updated_at'];
    public function product()
    {
      return $this->hasMany('App\Models\Product','product_id');
    }
    public function blogger()
    {
      return $this->hasMany('App\Models\Blogger','blogger_id');
    }
}
