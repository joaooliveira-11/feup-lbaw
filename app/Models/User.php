<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'photo',
        'google_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    
    /**
     * Get the interests for a user.
     */
    public function interests()
    {
        return $this->belongsToMany(Interest::class, 'user_interests', 'user_id', 'interest_id');
    }

    /**
     * Get the skills for a user.
     */ 
    public function skills() {
        return $this->belongsToMany(Skill::class, 'user_skills', 'user_id', 'skill_id');
    }

    public function isAdmin() {
        return $this->is_admin;
    }

    public function projects() {
        $worker_projects = $this->belongsToMany(Project::class, 'project_users', 'user_id', 'project_id')->get();
        $coordinator_projects = $this->hasMany(Project::class, 'project_coordinator')->get();
        return $worker_projects->merge($coordinator_projects);
    }
    
    public function notifications() {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function tasks() {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function upcoming_tasks() {
        return $this->tasks()
            ->where('finish_date', '>', now())
            ->where('state', 'assigned')
            ->orderBy('finish_date', 'asc')
            ->limit(6)
            ->get();
    }
}
