<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'event_id';
    protected $fillable = ['event_id','category','event_name','event_description','event_location','event_date','event_host','event_time','event_artists','event_poster','created_at','updated_at'];
} 
