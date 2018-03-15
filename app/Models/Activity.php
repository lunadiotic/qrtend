<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['user_id', 'log', 'date'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
