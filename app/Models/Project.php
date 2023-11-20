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

    /**
     * Get the user that owns the card.
     */
    public function user(): BelongsTo {
        return $this->emitedBy(User::class);
    }

    public function is_member(User $user) {
        return ($this->hasMany('App\Models\Project_Users','project_id')->where('user_id', $user->id)->get()->isNotEmpty());
    }

    public function is_coordinator(User $user) {
        return $this->project_coordinator == $user->id;
    }

    public function users() {
        return $this->belongsToMany(User::class, 'project_users', 'project_id', 'user_id');
    }

    public function usersNotInProject()
{
    $projectId = $this->project_id;

    return User::whereNotIn('id', function ($query) use ($projectId) {
        $query->select('user_id')
            ->from('project_users')
            ->where('project_id', '=', $projectId);
    })->get();
}

    public function coordinator() {
        return $this->belongsTo(User::class, 'project_coordinator');
    }
    /**
     * Get the tasks for the project.
     */
    public function tasks(): HasMany {
        return $this->hasMany(Task::class, 'project_task');
    }
    
}