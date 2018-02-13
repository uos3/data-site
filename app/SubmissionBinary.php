<?php

/*

TODO MIGRATION!
*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubmissionBinary extends Model
{
	protected $table = 'submissions_binary';
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

	public function submission()
	{
		return $this->belongsTo('App\Submission');
	}

}
