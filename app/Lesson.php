<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['title', 'body'];

    protected $table = 'lessons';
    protected $hidden = ['updated_at'];
}
