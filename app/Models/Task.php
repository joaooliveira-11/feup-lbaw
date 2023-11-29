<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model {
    use HasFactory;
    public $timestamps  = false;
    protected $table = 'task';
    protected $primaryKey = 'task_id';

    // protected $fillable = ['title', 'description', 'priority', 'finish_date', 'state'];

    public function project(): BelongsTo {
        return $this->belongsTo(Project::class);
    }

    public function is_archived() {
        return $this->state == 'archived';
    }

    public function is_assigned() {
        return $this->state == 'assigned';
    }

}