<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    //
	protected $fillable = ['name', 'email', 'gender', 'phone', 'address', 'nationality', 'date_of_birth', 'education', 'preferred_contact'];
}
