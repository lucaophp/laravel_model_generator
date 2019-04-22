<?php
namespace App;


use Illuminate\Database\Eloquent\Model;
class {{ class_name }} extends Model{
	protected $table = '{{ table_name }}';
    protected $fillable = [
        {{ atts }}
    ];

}