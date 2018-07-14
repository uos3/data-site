<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class SatGPS extends Model
{
	protected $table = 'sat_gps';
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */

  protected $fillable = [
'submission_id',
'timestamp',
'lat',
'lon',
'alt',
'hdop',
'vdop',
'pdop',
'tdop',
  ];

	protected $hidden = [
			'packet_id',

	];


	public $timestamps = false; //needed because I'm not using the default timestamp columns (updated_at, created_at), and otherwise php artisan tinker craps itself.

	public static $validation_rules = [];
}
