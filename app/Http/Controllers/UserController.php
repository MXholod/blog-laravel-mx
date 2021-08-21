<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
	public function create(){
		return view('user.create');
	}
	//
	public function store(Request $request){
		//Validation rules
		$request->validate([
			'name' => 'required',
			'email' => 'required|email|unique:users',
			'password' => 'required|confirmed'
		]);
		//Set the role for a user 'admin' - 1, others - 0
		$defineRole = 0;
			$users = DB::table('users')->select(DB::raw('count(*) as user_count'))->get();
		//Table users is empty. Who is first that is 'admin' 
		if($users[0]->user_count == 0){
			$defineRole = 1;
		}else{
			$defineRole = 0;
		}
		//Create new User
		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			//'password' => Hash::make($request->password)
			'password' => bcrypt($request->password),
			'is_admin' => $defineRole
		]);
		//Show a message to the user
		session()->flash('success', "You have registered" );
		//Authorize the user
		Auth::login($user);
		//Go to the route 'home'
		return redirect()->home();
		//dd($request->all());
	}
}
