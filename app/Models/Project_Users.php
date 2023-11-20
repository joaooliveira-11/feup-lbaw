<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Project_Users extends Pivot
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'project_users';

    protected $primaryKey = ['project_id', 'user_id'];

    protected $fillable = ['project_id', 'user_id'];
}