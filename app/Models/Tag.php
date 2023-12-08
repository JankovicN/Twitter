<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tweet_id'
    ];

    public function tweet()
    {
        return $this->belongsTo(Tweet::class, 'tweet_id');
    }
}
