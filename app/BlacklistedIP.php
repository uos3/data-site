<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlacklistedIP extends Model
{
	protected $table = 'ip_blacklist';
	
	public $timestamps = false; //not using default timestamp columns = Eloquent is a sad sad panda
	
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
   		'ip_address'
    ];
}
