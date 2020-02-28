<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvitedUser extends Model
{
    protected $fillable = ['user_id' , 'invite_user' , 'party_id' , 'party_date', 'is_come'];
    protected $hidden = ['created_at' , 'updated_at'];

    
    
}
