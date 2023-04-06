<?php

namespace App\Providers;

use App\Models\Member;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class LibraryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public $name, $days; 

    public function boot()
    {
        $members = Member::select('members.name','transactions.date_end','transactions.status')
					->join('transactions', 'members.id', '=', 'transactions.member_id')
					->orderBy('members.id')->get();	
        
        $transactions = Transaction::select(DB::raw('count(transactions.status) as time_limit', 'date_end'))->where('transactions.status', '=', 1, 'AND' ,'transactions.deleted_at', null)->get();
        $this->name = $members;
        $this->days = $transactions;
        view()->composer('layouts.admin', function($view) {
            $view->with([ 'notif_name' => $this->name, 'notif_days' => $this->days]);
        });
    }
}
