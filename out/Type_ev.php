<?php
namespace App;


use Illuminate\Database\Eloquent\Model;
class Type_ev extends Model{
	protected $table = 'type_ev';
    protected $fillable = [
        'name','description'
    ];

}