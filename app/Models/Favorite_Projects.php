<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project_Users extends Model {
    use HasFactory;

    public $timestamps  = false;

    protected $table = 'favorite_projects';
}