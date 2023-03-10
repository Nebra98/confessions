<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Confession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'user_name', 'confession'
    ];

    public function scopeFilter($query, array $filters){

        if($filters['search'] ?? false){
            $query->where('confession', 'like', '%' . request('search') . '%')
                ->orWhere('id', 'like', '%' . request('search') . '%');
        }
    }

}
