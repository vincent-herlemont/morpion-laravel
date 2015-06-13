<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'games';
    protected $fillable = ['name','user1_id','user2_id'];
}
