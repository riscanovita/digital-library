@extends('layouts.admin')
@section('header', 'Transaction Detail')

@section('css')
<!-- Datatables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
<div id="controller">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
				</div>
				<div class="card-body mr-3">
					<table id="datatable" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Transaction ID</th>
								<th>Book ID</th>
								<th>Title</th>
								<th>Qty</th>
								<th>Created At</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>

</div>
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
	var actionUrl = '{{ url('details') }}';
	var apiUrl = '{{ url('api/details') }}';
	var columns = [
		{data: 'DT_RowIndex', class: 'text-center', orderable: false},
		{data: 'transaction_id', class: 'text-center', orderable: false},
		{data: 'book_id', class: 'text-center', orderable: true},
		{data: 'title', class: 'text-center', orderable: true},
		{data: 'qty', class: 'text-center', orderable: true},
		{data: 'date', class: 'text-center', orderable: true},
		{render: function (index, row, data, meta) {
			return `
			<form action="{{ url('/details/${data.id}') }}" method="post" class="d-inline">
				@csrf
				@method('delete')
				<button class="btn btn-danger btn-sm" type="submit" onsubmit="return confirm('Are you sure?')">Delete</button>
			</form>`;
		}, orderable: false, width: '200px', class: 'text-center'},
	];
</script>
{{-- <script src="{{ asset('js/data.js') }}"></script> --}}
<script>
	var controller = new Vue({
	el: '#controller',
	data: {
		data: {},
		actionUrl,
		apiUrl
	},
	mounted: function () {
		this.datatable();
	},
	methods: {
		datatable() {
			const _this = this;
			_this.table = $('#datatable').DataTable({
				ajax: {
					url: _this.apiUrl,
					type: 'GET',
				},
				columns: columns
			}).on('xhr', function () {
				_this.datas = _this.table.ajax.json().data;
			});
		},

	}
});
</script>

@endsection
