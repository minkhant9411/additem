<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    // protected $guarded = [];
    protected $fillable = [
        'name',
        'cat_id',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }
}