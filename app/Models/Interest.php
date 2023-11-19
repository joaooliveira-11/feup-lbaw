<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Interest extends Model
{
    use HasFactory;

    protected $table = 'interest';
    protected $primaryKey = 'interest_id';

    public function users()
{
    return $this->belongsToMany(User::class, 'user_interests', 'interest_id', 'user_id');
}

    public static function getAllInterests()
    {
        return self::all();
    }

    
}