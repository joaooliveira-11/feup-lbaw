<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project_Users extends Model
{
    use HasFactory;

    public $timestamps  = false;

    protected $table = 'project_users';

    protected $primaryKey = ['project_id', 'user_id'];
}