<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite_Projects extends Model {
    use HasFactory;

    protected $table = 'favorite_projects';
    public $timestamps = false;
    public $incrementing = false;

}