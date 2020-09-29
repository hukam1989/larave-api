@extends('layouts.admin')
@section('title')
Edit Registered  | LARAVEL
@endsection
@section('content')

<div class="container">
<div class="row">

<div class="col-md-12">
	<div class="card">
		<div class="col-md-6">
		<div class="card-header">	
		<h4> Edit Role for Registered User	</h4>		
		</div>
	
			<div class="card-body">	
			<form action="/role-register-update/{{$edit_users->id}}" method="POST">
			{{ csrf_field() }}
			{{ method_field('PUT') }}
				<div class="form-group">
				<label for="exampleInputEmail1">Name</label>
				<input type="name" name="name" value="{{$edit_users->name}}" class="form-control" id="exampleInputEmail1" placeholder="Enter Name">		
				</div>		
					
				<div class="form-group">
				<label for="exampleFormControlSelect2">User Type</label>	
				<select name="userType" class="form-control">
				<option value="admin">Admin</option>
				<option value="user">User</option>		
				</select>		
				</div>
			</div>		
		
				<button type="submit" class="btn btn-success">Update</button>
				<a href="/role-register" class="btn btn-danger">Cancel</a>
			</form>
	
		</div>
	</div>
</div>
</div>

</div>
</div>
            
@endsection
@section('secripts')
@endsection