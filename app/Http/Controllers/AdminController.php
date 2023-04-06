<?php

namespace App\Http\Controllers;


use App\Models\Book;
use App\Models\Catalog;
use App\Models\Member;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $total_anggota = Member::count();
        $total_buku = Book::count();
        $total_peminjaman = Transaction::whereMonth('date_start', date('m'))->count();
        $total_penerbit = Publisher::count();

        $data_donut = Book::select(DB::raw("COUNT(publisher_id) as total"))
        				->groupBy('publisher_id')
        				->orderBy('publisher_id', 'asc')
        				->pluck('total');
        $label_donut = Publisher::orderBy('publishers.id', 'asc')
        				->join('books','books.publisher_id','=','publishers.id')
        				->groupBy('name')
        				->pluck('name');

        // return $data_donut;

        $label_bar = ['Peminjaman', 'Pengembalian'];
        $data_bar = [];

        foreach ($label_bar as $key => $value) {
            $data_bar[$key]['label'] = $label_bar[$key];
            $data_bar[$key]['backgroundColor'] = $key == 0 ? 'rgba(60,141,100,0.9)' : 'rgba(210,214,222,1)';
            $data_month = [];

            foreach (range(1,12) as $month) {
            	if ($key == 0) {
            		$data_month[] = Transaction::select(DB::raw("COUNT(*) as total"))->whereMonth('date_start', $month)->first()->total;
            	} else {
            		$data_month[] = Transaction::select(DB::raw("COUNT(*) as total"))->whereMonth('date_end', $month)->first()->total;
            	}
            }
            $data_bar[$key]['data'] = $data_month;
        }

        // return $data_bar;

        return view ('admin.dashboard', compact('total_buku', 'total_anggota', 'total_peminjaman', 'total_penerbit', 'data_donut', 'label_donut', 'data_bar'));
    }

    public function katalog()
    {
        $data_katalog = Catalog::all();

        return view('admin.catalog.index', compact('data_katalog'));
    }

    public function penerbit()
    {
        return view('admin.publisher');
    }

    public function pengarang()
    {
        return view('admin.author');
    }

}
