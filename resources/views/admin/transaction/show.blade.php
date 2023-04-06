@extends('layouts.admin')
@section('header', 'Transaction')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">

@endsection

@section('content')
<div class="row">  
	<div class="col-md-7">     
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title">Show Transaction</h3>
			</div>
				<div class="card-body">                
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Name</label>
                    @foreach($members as $member)
                        {{ $member->id == $transaction->member_id ? $member->name :'' }}  
                    @endforeach
                </div>
                <div class="form-group row">
                    <label for="date_start" class="col-sm-3 col-form-label">Date of Loan</label>
                    {{ convert_date($transaction->date_start) }}
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Date of Return</label>
                    {{ convert_date($transaction->date_end) }}
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Book</label>
                    @foreach($tranDetails as $tranDetail)
                        @foreach($books as $book)
                           {{ $book->id == $tranDetail->book_id ? $book->title :'' }} 
                        @endforeach
                    @endforeach
                </div>										
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Status</label>
                    {{ $transaction->status == 1 ? 'Borrowed' : 'Returned' }}
                </div>
                <div class="card-footer">
                    <a href="{{ url("transactions") }}" class="btn btn-sm btn-primary float-right">Back to Transaction</a>                   
                </div>
            </div>
		</div>
	</div>
</div>
@endsection

@section('js')
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script type="text/javascript">
    $(function () {
    //Initialize Select2 Elements
    $('#select2').select2()
    });
</script>
@endsection