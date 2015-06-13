<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Frame extends Model
{
    protected $table = 'frames';
    protected $fillable = ['game_id','user_id','n'];
}
