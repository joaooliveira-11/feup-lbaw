<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Invite extends Model
{
 
    use HasFactory;

    public $timestamps  = false;
    protected $table = 'invite';
    protected $primaryKey = 'invite_id';

    protected $fillable = [
        'title',
        'description',
        'create_date',
        'invited_by',
        'invited_to',
        'project_invite'
    ];
}