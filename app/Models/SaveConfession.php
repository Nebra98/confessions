<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveConfession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'confession_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function confession()
    {
        return $this->belongsTo(Confession::class, 'confession_id');
    }

}
