@extends('layouts.admin')
@section('header', 'Transaction')

@section('css')
<!-- Datatables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
@role('admin')                       
<div id="controller">
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-md-7">
					<a href="{{ url("transactions/create") }}" class="btn btn-sm btn-primary pull-right">Add Transaction</a>
				</div>	
				<div class="col-md-2">
					<select class="form-control" name="status" id="status">
						<option value="">State Filter</option>
						<option value="1">Borrowed</option>
						<option value="0">Returned</option>
					</select>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="date_start" id="date_start" >
						<option value="">Loan Date Filter</option>
						<option value="01">January</option>	
						<option value="02">February</option>	
						<option value="03">March</option>	
						<option value="04">April</option>	
						<option value="05">May</option>	
						<option value="06">June</option>	
						<option value="07">July</option>	
						<option value="08">August</option>	
						<option value="09">September</option>	
						<option value="10">October</option>	
						<option value="11">November</option>	
						<option value="12">December</option>	
					</select>
				</div>
			</div>			
		</div>
		<div class="card-body">
			<table id="datatable" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th>Date of Loam</th>
						<th>Date of Return</th>								
						<th>Name</th>
						<th>Length of Lease(Days)</th>	
						<th>Book Totals</th>	
                        <th>Total Price</th>	
						<th>Status</th>					
						<th class="text-center">Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>	
</div>
@endrole
@endsection

@section('js')
<!-- DataTables & Plugins -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script type="text/javascript">
	var actionUrl = '{{ url('transactions') }}';
	var apiUrl = '{{ url('api/transactions') }}';
	var columns = [
		{data: 'DT_RowIndex', class: 'text-center', orderable: true},
		{data: 'date_start', class: 'text-center', orderable: true},
		{data: 'date_end', class: 'text-center', orderable: true},
		{data: 'name', class: 'text-center', orderable: true},
		{data: 'durasi', class: 'text-center', orderable: true},
		{data: 'total_buku', class: 'text-center', orderable: true},
		{data: 'total_bayar', class: 'text-center', orderable: true},
		{data: 'status', class: 'text-center', orderable: true},
		{render: function (index, row, data, meta) {
			return `
			<a href="{{ url('/transactions/${data.id}') }}" class="btn btn-info btn-sm">Detail</a>
			<a href="{{ url('/transactions/${data.id}/edit') }}" class="btn btn-warning btn-sm">Edit</a>
			<form action="{{ url('/transactions/${data.id}') }}" method="post" class="d-inline">
				@csrf
				@method('delete')
				<button class="btn btn-danger btn-sm" type="submit" onsubmit="return confirm('Are you sure?')">Delete</button>
			</form>`;
		}, orderable: false, width: '200px', class: 'text-center'},
	];
</script>
<script src="{{ asset('js/data.js') }}"></script> 
<script type="text/javascript">
$('select[name=status]').on('change', function() {
	status = $('select[name=status]').val();

	if (status == '1' || status == '0') {
		controller.table.ajax.url(apiUrl+'?status='+status).load();
		
	} else {
		controller.table.ajax.url(apiUrl).load();
	}
});	

$('select[name=date_start]').on('change', function() {
	date_start = $('select[name=date_start]').val();

	if (date_start == null) {
		controller.table.ajax.url(apiUrl).load();
	} else {
		controller.table.ajax.url(apiUrl+'?date_start='+date_start).load();
	}
});	 
	
</script>
@endsection