@extends('layouts.admin')
@section('header', 'Transaction')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">

@endsection

@section('content')
<a href="{{ url("transactions") }}" class="btn btn-sm btn-primary pull-right my-2">Back to Transaction</a>
<div class="row">  
	<div class="col-md-7">     
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title">Create New Transaction</h3>
			</div>
			<form method="post" action="{{ url('transactions') }}">
				@csrf

				<div class="card-body">                
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <select name="member_id" id="member_id" class="form-control @error('member_id') is-invalid @enderror" required="">
                            <option value="">Select a Name</option>					
                                @foreach($members as $member)
                                    <option value="{{ $member->id}}">{{ $member->name }}</option>
                                @endforeach                             
							</select>
                            @error('member_id')
							    <div class="invalid-feedback">{{ $message }}</div>
						    @enderror
                         </div>
                    </div>
                    <div class="form-group row">
                        <label for="date_start" class="col-sm-3 col-form-label">Date of Loan</label>
                        <div class="col-sm-4">
                            <input type="date" id="date_start" class="form-control @error('date_start') is-invalid @enderror" name="date_start" value="{{ date('Y-m-d') }}" required="">
                            @error('date_start')
							    <div class="invalid-feedback">{{ $message }}</div>
						    @enderror                          
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Date of Return</label>
                        <div class="col-sm-4">
                            <input type="date" id="date_end" class="form-control @error('date_end') is-invalid @enderror" name="date_end" required="">
                            @error('date_end')
						        <div class="invalid-feedback">{{ $message }}</div>
						    @enderror 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Book</label>
                        <div class="col-sm-9">
                            <select id="select2" class="form-control @error('book_id') is-invalid @enderror" multiple="multiple" data-placeholder="Select a Book" id="book_id" name="book_id[]" style="width: 100%;" required="">                           
                                @foreach($books as $book)
                                    @if($book->qty > 0)
                                    <option value="{{ $book->id }}">{{ $book->title }}</option> 
                                    @endif                                
                                @endforeach
                            </select>
                            @error('book_id')
							    <div class="invalid-feedback">{{ $message }}</div>
						    @enderror 
                        </div>
                    </div>										
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <div class="form-check">
                                <input class="form-check-input @error('status') is-invalid @enderror" type="radio" id="status" name="status"  value="1">
                                <label class="form-check-label">Borrowed</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('status') is-invalid @enderror" type="radio" id="status" name="status" value="0">
                                <label class="form-check-label">Returned</label>
                            </div> 
                            @error('status')
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

@section('js')
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script type="text/javascript">
    $(function () {
    //Initialize Select2 Elements
    $('#select2').select2()
    });
</script>
@endsection