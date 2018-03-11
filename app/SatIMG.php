<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class SatIMG extends Model
{
	protected $table = 'sat_img';
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */

  protected $fillable = [
'sequence_id',
'timestamp',
'image_id',
'fragment_id',
'number_of_fragments',
'image_data',
  ];

	public $timestamps = false; //needed because I'm not using the default timestamp columns (updated_at, created_at), and otherwise php artisan tinker craps itself.

	public static $validation_rules = [];

	public function packet()
	{
		return $this->belongsTo('App\Packet');
	}
}
