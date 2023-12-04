<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Notification extends Model
{
 
    use HasFactory;

    public $timestamps  = false;
    protected $table = 'notification';
    protected $primaryKey = 'notification_id';

    protected $fillable = [
        'create_Date',
        'emited_by',
        'emited_to',
        'viewed',
        'type',
        'date'
    ];
}