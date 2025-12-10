<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Essay extends Model
{
    protected $table = 'essay';
    protected $fillable = [
        'topic_id',
        'user_id',
        'situation',
        'answer',
        'mark',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
