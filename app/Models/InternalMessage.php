<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalMessage extends Model
{
    //
    protected $fillable = ['sender_email', 'subject', 'body', 'is_read'];
}
