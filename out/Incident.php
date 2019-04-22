<?php
namespace App;


use Illuminate\Database\Eloquent\Model;
class Incident extends Model{
	protected $table = 'incident';
    protected $fillable = [
        'description','longitude','latitude','time','obs'
    ];

}