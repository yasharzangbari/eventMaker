<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    protected $primaryKey = 'party_id';
    protected $fillable = ['description' , 'theme_party' , 'start_date' , 'end_date', 'user_id'];
    protected $hidden = ['created_at' , 'updated_at'];
}
