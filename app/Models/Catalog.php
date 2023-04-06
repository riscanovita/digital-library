<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Catalog extends Model
{
    use SoftDeletes;

    use HasFactory;

    protected $fillable = ['name'];

    public function books()
    {
    	return $this->hasMany('App\Models\Book', 'catalog_id');
    }
}
