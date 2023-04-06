@extends('layouts.admin')
@section('header', 'Transaction')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">

@endsection

@section('content')
<a href="{{ url("details") }}" class="btn btn-sm btn-primary pull-right my-2">Back to Transaction</a>
<div class="row">  
	<div class="col-md-7">     
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title">Create New Transaction</h3>
			</div>
			<form method="post" action="{{ url('details') }}">
				@csrf

				<div class="card-body">                
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Transaction ID</label>
                        <div class="col-sm-9">
                            <select name="transaction_id" id="transaction_id" class="form-control @error('transaction_id') is-invalid @enderror" required="">
                            <option value="">Select an ID</option>					
                                @foreach($tranDetails as $detail)
                                    <option value="{{ $detail->id}}">{{ $detail->id }}</option>
                                @endforeach                             
							</select>
                            @error('transaction_id')
							    <div class="invalid-feedback">{{ $message }}</div>
						    @enderror
                         </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Book ID</label>
                        <div class="col-sm-9">
                            <select name="book_id" id="book_id" class="form-control @error('book_id') is-invalid @enderror" required="">
                            <option value="">Select an ID</option>					
                                @foreach($books as $book)
                                    <option value="{{ $book->id}}">{{ $book->id }}</option>
                                @endforeach                             
							</select>
                            @error('transaction_id')
							    <div class="invalid-feedback">{{ $message }}</div>
						    @enderror
                         </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Qty</label>
                        <div class="col-sm-4">
                            <input type="text" id="qty" class="form-control @error('qty') is-invalid @enderror" name="qty" required="">
                            @error('qty')
						        <div class="invalid-feedback">{{ $message }}</div>
						    @enderror 
                        </div>
                    </div>
                    									
                  
					<div class="card-footer">
						<button type="submit" class="btn btn-primary float-right">Submit</button>
					</div>
                </div>
			</form>
		</div>
	</div>
</div>
@endsection

