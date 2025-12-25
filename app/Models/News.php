<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /** @use HasFactory<\Database\Factories\NewsFactory> */
    use HasFactory;

    protected $fillable = ['title', 'image', 'author_id', 'body'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    


}
