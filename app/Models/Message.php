<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Message extends Model
{
 
    use HasFactory;

    public $timestamps  = false;
    protected $table = 'message';
    protected $primaryKey = 'message_id';

    public function messaged_by() {
        return $this->belongsTo(User::class, 'message_by');
    }
}