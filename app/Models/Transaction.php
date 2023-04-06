<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    
    use HasFactory;

    protected $fillable = ['member_id', 'date_start', 'date_end', 'status'];

    public function tranDetails()
    {
    	return $this->hasMany('App\Models\TransactionDetail', 'transaction_id');
    }
}
