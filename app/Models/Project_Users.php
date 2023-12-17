<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project_Users extends Model
{
    use HasFactory;

    protected $table = 'project_users';
    public $timestamps = false;
    public $incrementing = false;
}