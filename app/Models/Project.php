<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'project';
    protected $primaryKey = 'project_id';

    public function is_member(User $user) { 
        return $this->members()->contains('id', $user->id);
    }

    public function is_coordinator(User $user) {
        return $this->project_coordinator == $user->id;
    }

    public function coordinator() {
        return $this->belongsTo(User::class, 'project_coordinator');
    }

    public function members() {
        $project_users = $this->belongsToMany(User::class, 'project_users', 'project_id', 'user_id')->get();
        $coordinator = $this->coordinator()->first();

        $members = $project_users->push($coordinator);

        return $members->sortBy('username');
    }

    public function nonmembers(){
        $project_id = $this->project_id;

        return User::whereNotIn('id', function ($query) use ($project_id) {
                $query->select('user_id')
                ->from('project_users')
                ->where('project_id', '=', $project_id);
        })
        ->where('id', '!=', $this->project_coordinator)
        ->where('is_admin', '=', false)
        ->get();
    }

    public static function get_all_projects(User $user) {
        if ($user->is_admin) {
            return self::query();
        } else {
            $userProjectIds = $user->projects()->pluck('id');
            return self::whereIn('project_id', $userProjectIds)
                       ->orWhere('is_public', true);
        }
    }
    

    public function tasks(): HasMany {
        return $this->hasMany(Task::class, 'project_task');
    }
    
    public function messages(): HasMany {
        return $this->hasMany(Message::class, 'project_message');
    }

    public function favorites(): HasMany {
        return $this->hasMany(Favorite_Projects::class, 'project_id');
    }

    public function is_favorite(User $user) {
        return $this->favorites()->where('user_id', $user->id)->exists();
    }

}