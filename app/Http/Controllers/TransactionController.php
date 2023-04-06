<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->role('admin')){

         $transactions = Transaction::with('tranDetails')->get();

        } else {
            return abort('403');
        }

        return view ('admin.transaction.index', compact('transactions'));

    }

    public function api(Request $request)
    {
        if ($request->status == '1' || $request->status == '0') {

            $transactions = Transaction::selectRaw('sum(transaction_details.qty) as total_buku, sum(transaction_details.qty*books.price) as total_bayar,
            transactions.*, members.name')
                ->join('transaction_details','transaction_details.transaction_id','=','transactions.id')
                ->join('members','members.id','=','transactions.member_id')
                ->join('books', 'books.id','=','transaction_details.book_id')
                ->groupBy('transaction_details.transaction_id')
                ->where('status', $request->status)
                ->get();

        } elseif ($request->date_start ) {
            $transactions = Transaction::selectRaw('sum(transaction_details.qty) as total_buku, sum(transaction_details.qty*books.price) as total_bayar,
            transactions.*, members.name')
                ->join('transaction_details','transaction_details.transaction_id','=','transactions.id')
                ->join('members','members.id','=','transactions.member_id')
                ->join('books', 'books.id','=','transaction_details.book_id')
                ->groupBy('transaction_details.transaction_id')
                ->whereMonth('date_start', $request->date_start)
                ->get();
        } else {
            $transactions = Transaction::selectRaw('sum(transaction_details.qty) as total_buku, sum(transaction_details.qty*books.price) as total_bayar,
            transactions.*, members.name')
                ->join('transaction_details','transaction_details.transaction_id','=','transactions.id')
                ->join('members','members.id','=','transactions.member_id')
                ->join('books', 'books.id','=','transaction_details.book_id')
                ->groupBy('transaction_details.transaction_id')
                ->get();
        }

        $datatables = datatables()->of($transactions)
                                ->addColumn('durasi', function($transaction) {
                                return lama_pinjam($transaction->date_start, $transaction->date_end);
                                 })
                                ->addColumn('status', function($transaction) {
                                return status($transaction->status);
                                 })
                                 ->addColumn('total_bayar', function($transaction) {
                                    return numberWithSpaces($transaction->total_bayar);
                                })
                                ->addColumn('date_start', function($transaction) {
                                    return convert_date($transaction->date_start);
                                })
                                ->addColumn('date_end', function($transaction) {
                                    return convert_date($transaction->date_end);
                                })

                                ->addIndexColumn();

        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $transactions = Transaction::all();
        $tranDetails = TransactionDetail::all();
        $books = Book::all();
        $members = Member::all();

        return view ('admin.transaction.create', compact('transactions','books', 'tranDetails','members'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'member_id' => 'required',
            'date_start' => 'required|date',
            'date_end' => 'required|date',
            'book_id' => 'required',
            'status' => 'required',
        ]);

        $transaction = Transaction::create([
            'member_id' => $request->member_id,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'status' => $request->status
        ]);

        foreach($request->book_id as $row => $val){
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'book_id' => $request->book_id[$row],
                'qty' => 1
            ]);

             $stok = DB::table('books')->where('id', '=', $val)->decrement('qty', 1);
        }

        return redirect('transactions')->with('stok', $stok);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show($id, Transaction $transaction)
    {
        $transaction = Transaction::find($id);
        $members = Member::all();
        $tranDetails = TransactionDetail::select('*')->where('transaction_id', $id)->get();
        $books = Book::all();

        return view ('admin.transaction.show')
                    ->with('transaction', $transaction)
                    ->with('members', $members)
                    ->with('tranDetails', $tranDetails)
                    ->with('books', $books);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Transaction $transaction)
    {

        $transaction = Transaction::find($id);
        $members = Member::all();
        $books = Book::all();
        $tranDetails = TransactionDetail::select('*')->where('transaction_id', $id)->get();

        return view ('admin.transaction.edit')
                    ->with('transaction', $transaction)
                    ->with('members', $members)
                    ->with('tranDetails', $tranDetails)
                    ->with('books', $books);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Transaction $transaction)
    {
        $this->validate($request,[
            'member_id' => 'required',
            'date_start' => 'required|date',
            'date_end' => 'required|date',
            'book_id' => 'required',
            'status' => 'required',
        ]);

        $transactionDetail = TransactionDetail::select('*')->where('transaction_id', $id)->get();
        $tranDetID = $request->transaction_id;

        $transaction = DB::table('transactions')
                        ->where('id', $id)
                        ->update([
                            'member_id' => $request->member_id,
                            'date_start' => $request->date_start,
                            'date_end' => $request->date_end,
                            'status' => $request->status,
                        ]);

        $detDelete = TransactionDetail::where('transaction_id', $id)->delete();

        foreach($request->book_id as $row => $val){
            $tranDetails = TransactionDetail::create([
                'transaction_id' => $id,
                'book_id' => $request->book_id[$row],
                'qty' => 1,
            ]);

            if($request->status == 0){
                DB::table('books')->where('id', '=', $val)->increment('qty', 1);
            }
        }

        return redirect('transactions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Transaction $transaction)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();

        return redirect('transactions');
    }
}
