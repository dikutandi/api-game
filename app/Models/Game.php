<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $table = 'games';

    protected $fillable = [
        'user_id',
        'token_id',
        'game',
        'skor',
        'date',
    ];

    protected $dates = [
        'created_at', 'updated_at', 'date',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
