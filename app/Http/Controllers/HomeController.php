<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\Catalog;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $members = Member::with('user')->get();
        // $books = Book::with('publisher')->get();
        // $publishers = Publisher::with('books')->get();
         // $authors = Author::with('books')->get();
        // $catalogs = Catalog::with('books')->get();

        // no 1
        // $data1 = Member::select('*')
        //               ->where('members.role','=','admin')
        //               ->get();

        // no 2
        // $data2 = Member::select('*')
        //               ->where('members.role','!=','admin')
        //               ->get();

        // no 3
        // $data3 = Member::select('members.id','members.name')
        //               ->join('transactions','members.id','=','transactions.member_id')
        //               ->where('transactions.date_start', NULL)
        //               ->get();

        // no 4
        // $data4 = Member::select('members.id','members.name','members.phone_number')
        //               ->join('transactions','members.id','=','transactions.member_id')
        //               ->orderBy('member_id', 'asc')
        //               ->get();

        //no 5
        // $data5 = Member::select('members.id','members.name','members.phone_number')
        //               ->join('transactions','members.id','=','transactions.member_id')
        //               ->join('transaction_details','transactions.id','=','transaction_details.transaction_id')
        //               ->where('transaction_details.qty','>', 1)
        //               ->get();

        // no 6
        // $data6 = Member::select('members.name','members.phone_number','members.address','transactions.date_start','transactions.date_end')
        //               ->join('transactions','members.id','=','transactions.member_id')
        //               ->get();

        //  // no 7
        // $data7 = Member::select('members.name','members.phone_number','members.address','transactions.date_start','transactions.date_end')
        //               ->join('transactions','members.id','=','transactions.member_id')
        //               ->whereMonth('transactions.date_end','=', '06')
        //               ->get();

        // no 8
        // $data8 = Member::select('members.name','members.phone_number','members.address','transactions.date_start','transactions.date_end')
        //               ->join('transactions','members.id','=','transactions.member_id')
        //               ->whereMonth('transactions.date_start','=', '05')
        //               ->get();

        // // no 9
        // $data9 = Member::select('members.name','members.phone_number','members.address','transactions.date_start','transactions.date_end')
        //               ->join('transactions','members.id','=','transactions.member_id')
        //               ->whereMonth('transactions.date_end','=', '06', 'AND' ,'transactions.date_end','=','06')
        //               ->get();

        // no 10
        // $data10 = Member::select('members.name','members.phone_number','members.address','transactions.date_start','transactions.date_end')
        //               ->join('transactions','members.id','=','transactions.member_id')
        //               ->where('members.address','LIKE','%Bandung%')
        //               ->get();

        // no 11
        // $data11 = Member::select('members.name','members.phone_number','members.address','transactions.date_start','transactions.date_end')
        //               ->join('transactions','members.id','=','transactions.member_id')
        //               ->where('members.address','LIKE','%Bandung%','AND','members.gender','LIKE','%female%')
        //               ->get();

        // no 12
        // $data12 = Member::select('members.name','members.phone_number','members.address','transactions.date_start','transactions.date_end','transaction_details.book_id','transaction_details.qty')
        //               ->join('transactions','members.id','=','transactions.member_id')
        //               ->join('transaction_details','transactions.id','=','transaction_details.transaction_id')
        //               ->where('transaction_details.qty','>', 1)
        //               ->get();

        // no 13 X
        // $data13 = Member:: selectRaw('members.name,members.phone_number,members.address,transactions.date_start,
        //     transactions.date_end,transaction_details.book_id,transaction_details.qty,books.title,books.price,
        //     transaction_details.qty * books.price as total_harga')
        //               ->join('transactions','members.id','=','transactions.member_id')
        //               ->join('transaction_details','transactions.id','=','transaction_details.transaction_id')
        //               ->join('books','books.id','=','transaction_details.book_id')
        //               ->get();

         // no 14
        // $data14 = Member::select('members.name','members.phone_number','members.address','transactions.date_start',
        //     'transactions.date_end','transaction_details.book_id','transaction_details.qty','books.title','publishers.name','authors.name','catalogs.name')
        //               ->join('transactions','members.id','=','transactions.member_id')
        //               ->join('transaction_details','transactions.id','=','transaction_details.transaction_id')
        //               ->join('books','books.id','=','transaction_details.book_id')
        //               ->join('publishers','publishers.id','=','books.id')
        //               ->join('authors','authors.id','=','books.id')
        //               ->join('catalogs','catalogs.id','=','books.id')
        //               ->get();

        // no 15
        // $data15 = Catalog::select('*','books.title')
        //               ->join('books','books.catalog_id','=','catalogs.id')
        //               ->get();

        // no 16
        // $data16 = Book::select('*','publishers.name')
        //               ->leftJoin('publishers','books.publisher_id','=','publishers.id')
        //               ->get();

         // no 17
        // $data17 = Book::selectRaw('books.author_id, COUNT(books.qty) as amount')
        //               ->where('books.author_id','=','PG05')
        //               ->get();

        // no 18
        // $data18 = Book::select('*')
        //               ->where('books.price','>','10000')
        //               ->get();

        // no 19
        // $data19 = Book::select('*')
        //               ->join('authors','books.author_id','=','authors.id')
        //               ->where('authors.name','LIKE','%Penerbit 01%','AND','books.qty','>', 10)
        //               ->get();

        // no 20
        // $data20 = Member::select('*')
        //               ->whereMonth('members.created_at','=','06')
        //               ->get();


        // return $data20;

        // return view('home');
    }
    public function dashboard()
    {
        $total_anggota = Member::count();
        $total_buku = Book::count();
        $total_penerbit = Publisher::count();
        $total_peminjaman = Transaction::whereMonth('date_start', date('m'))->count();

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

        // return $data_month;

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

    public function spatie()
    {
        // $role = Role::create(['name' => 'admin']);                                                      //create admin di table role
        // $permission = Permission::create(['name' => 'index transaction']);                              //create index transaction di table permission

        // $role->givePermissionTo($permission);
        // $permission->assignRole($role);

        // $user = auth()->user();                          //user yang sedang login
        // $user->assignRole('admin');                      //memberikan user role
        // return $user;

        // $user = User::where('id', 2)->first();
        // $user->assignRole('admin');

        // $user = User::with('roles')->get();
        // return $user;

        // $user = auth()->user();
        // $user->removeRole('admin');                      //menghapus role

        // $user = User::where('id', 2)->first();
        // $user->removeRole('admin');
    }

}
