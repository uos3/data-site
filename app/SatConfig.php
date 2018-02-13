<?php

/*

TODO MIGRATION!
*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class SatConfig extends Model
{
	protected $table = 'sat_config';
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */

  protected $guarded = [
    'timestamp',
  ];

	public $timestamps = false; //needed because I'm not using the default timestamp columns (updated_at, created_at), and otherwise php artisan tinker craps itself.

	public static $validation_rules = [];

	public function packet()
	{
		return $this->belongsTo('App\Packet');
	}

}
