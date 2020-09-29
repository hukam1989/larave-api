<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class DashboardController extends Controller
{
	public function registered(){
	   
	   $users = User::all();
	   return view('admin.register')->with('users',$users);
	}
	
	public function register_edit(Request $request, $id){
		
		$edit_users= User::findOrFail($id);
		return view('admin.register-edit')->with('edit_users',$edit_users);
	}
	
	public function register_update(Request $request, $id){
		
		$update_users= User::find($id);
		$update_users->name = $request->input('name');
		$update_users->user_type = $request->input('userType');
		$update_users->update();
		
		return redirect('/role-register')->with('status','User data updated');
		
	}
	
	public function register_delete($id){
		
		$delete_users = User::findOrFail($id);
		$delete_users->delete();
		
		return redirect('/role-register')->with('status','User data deleted successfully.');
	}
	
	
}
