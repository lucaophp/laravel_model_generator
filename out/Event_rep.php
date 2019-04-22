<?php
namespace App;


use Illuminate\Database\Eloquent\Model;
class Event_rep extends Model{
	protected $table = 'event_rep';
    protected $fillable = [
        'type_ev_id','datahora','latitude','longitude','photo','status','user_id'
    ];

}