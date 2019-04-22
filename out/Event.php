<?php
namespace App;


use Illuminate\Database\Eloquent\Model;
class Event extends Model{
	protected $table = 'event';
    protected $fillable = [
        'event_rep_id','user_id','estimative','accept','datahora','obs','level'
    ];

}