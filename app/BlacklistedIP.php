<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlacklistedIP extends Model
{
	protected $table = 'ip_blacklist';
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
   		'ip_address'
    ];
}
