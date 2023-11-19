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
    public function users() {
        return $this->belongsToMany(User::class, 'project_users', 'project_id', 'user_id');
    }
    /**
     * Get the tasks for the project.
     */
    public function tasks(): HasMany {
        return $this->hasMany(Task::class, 'project_task');
    }
    
}