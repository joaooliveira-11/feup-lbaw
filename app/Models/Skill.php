<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Skill extends Model
{
    use HasFactory;

    protected $table = 'skill';
    protected $primaryKey = 'skill_id';

    public function users()
{
    return $this->belongsToMany(User::class, 'user_skills', 'skill_id', 'user_id');
}
    
}