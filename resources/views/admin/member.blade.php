@extends('layouts.admin')
@section('header', 'Member')

@section('css')
<!-- Datatables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
<div id="controller">
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-md-10">
					<a href="#" @click="addData()" class="btn btn-sm btn-primary pull-right">Create New Member</a>
				</div>
				<div class="col-md-2">
					<select class="form-control" name="gender">
						<option value="0">All Genders</option>
						<option value="male">Male</option>
						<option value="female">Female</option>
					</select>
				</div>
			</div>
		</div>

		<div class="card-body mr-3">
			<table id="datatable" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th>Name</th>
						<th>Gender</th>
						<th>Phone Number</th>
						<th>Address</th>
						<th>Email</th>
						<th>Role</th>
						<th>Created At</th>
						<th class="text-right">Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>

	<div class="modal fade" id="modal-default">
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" :action="actionUrl" autocomplete="off" @submit="submitForm($event, data.id)">
					<div class="modal-header">

						<h4 class="modal-title">Member</h4>

						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						@csrf

						<input type="hidden" name="_method" value="PUT" v-if="editStatus">

						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" id="name" class="form-control" name="name" v-model="data.name" required="">
						</div>
						<div class="form-group">
							<label for="gender">Gender</label>
							<select class="form-control" name="gender" id="gender" v-model="data.gender" required="">
								<option value="male">male</option>
								<option value="female">female</option>
							</select>
						</div>
						<div class="form-group">
							<label for="phone_number">Phone Number</label>
							<input type="number" id="phone_number" class="form-control" name="phone_number" v-model="data.phone_number" required="">
						</div>
						<div class="form-group">
							<label for="address">Address</label>
							<input type="text" id="address" class="form-control" name="address" v-model="data.address" required="">
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" id="email" class="form-control" name="email" v-model="data.email" required="">
						</div>
						<div class="form-group">
							<label for="role">Role</label>
							<select class="form-control" name="role" id="gender" v-model="data.role" required="">
								<option value="admin">admin</option>
								<option value="user">user</option>
							</select>
						</div>
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
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
	var actionUrl = '{{ url("members") }}';
	var apiUrl = '{{ url("api/members") }}';
	var columns = [
		{data: 'DT_RowIndex', class: 'text-center', orderable: true},
		{data: 'name', class: 'text-center', orderable: true},
		{data: 'gender', class: 'text-center', orderable: true},
		{data: 'phone_number', class: 'text-center', orderable: true},
		{data: 'address', class: 'text-center', orderable: true},
		{data: 'email', class: 'text-center', orderable: true},
		{data: 'role', class: 'text-center', orderable: true},
		{data: 'date', class: 'text-center', orderable: true},
		{render: function (index, row, data, meta) {
			return `
			<a href="#" class="btn btn-warning btn-sm" onclick="controller.editData(event, ${meta.row})">Edit</a>
			<a href="#" class="btn btn-danger btn-sm" onclick="controller.deleteData(event, ${data.id})">Delete</a>`;
		}, orderable: false, width: '200px', class: 'text-center'},
	];

</script>
<script src="{{ asset('js/data.js') }}"></script>
<script type="text/javascript">
	$('select[name=gender]').on('change', function() {
		gender = $('select[name=gender]').val();

		if (gender == 0) {
			controller.table.ajax.url(apiUrl).load();
		} else {
			controller.table.ajax.url(apiUrl+'?gender='+gender).load();
		}
	});
</script>
@endsection
