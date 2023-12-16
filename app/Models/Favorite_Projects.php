<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite_Projects extends Model {
    use HasFactory;

    protected $table = 'favorite_projects';
    public $timestamps = false;
    protected $primaryKey = ['project_id', 'user_id'];
    public $incrementing = false;

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}