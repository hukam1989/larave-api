@extends('layouts.admin')

@section('title')
Registered Roles 
@endsection

@section('content')
 <div class="col-md-12">
            <div class="card card-plain">
              <div class="card-header">
                <h4 class="card-title"> Registered Roles </h4>
					@if (session('status'))
					<div class="alert alert-success" role="alert">
					{{ session('status') }}
					</div>
					@endif
                <p class="category"> Here is a subtitle for this table</p>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        Name
                      </th>
                      <th>
                        Phone No
                      </th>
                      <th>
                        Email
                      </th>
					     <th>
                        Type
                      </th>
                      <th class="text-right">
                        Edit 
                      </th>
					  <th class="text-right">
                        Delete 
                      </th>
                    </thead>
                    <tbody>               
					@foreach($users as $row)					  
					<tr>					  
					  <td>
					  {{$row->name}}
                        </td>
                        <td>
                          {{$row->phone}}
                        </td>
                        <td>
                            {{$row->email}}
                        </td>
                        <td>
                            {{$row->user_type}}
                        </td>
                        <td class="text-right">
                       <a href="/role-edit/{{$row->id}}" class="btn btn-success">Edit</a>
                        </td>
						
						 <td>
						 <form action="/role-delete/{{$row->id}}" method="POST">
							{{ csrf_field() }}
							{{ method_field('DELETE') }}						
                        <button type="submit" class="btn btn-danger">DELETE</button>
						 </form>
                        </td>
                     </tr>                      
					@endforeach
                     
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
</div>
            
@endsection

@section('secripts')

@endsection