<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','title','type','make', 'model','color','photo','vehicle_condition','hours_price','	daily_price','weekly_price','mothly_price','status','created_at','updated_at'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

	public function getTypeAttribute($value){
		switch($value){
			case "1": return "Daily";break;
			case "2": return "Weekly"; break;
			case "3": return "Monthly";break;
		}
	}
}
