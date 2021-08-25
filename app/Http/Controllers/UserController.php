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
		//Go to the route 'home' - main page
		return redirect()->home();
		//dd($request->all());
	}
	//User authentication form
	public function loginForm(){
		return view('user.login');
	}
	//Authenticate a user
	public function login(Request $request){
		//Validation rules
		$request->validate([
			'email' => 'required|email',
			'password' => 'required'
		]);
		//Authenticate user by two fields
		if(Auth::attempt([
			'email' => $request->email,
			'password' => $request->password
		])){
			session()->flash('success', 'You are logged in');
			//Check user role. If he is the administrator?
			if(Auth::user()->is_admin == 1){//Admin - 1, User - 0. Property 'is_admin' from 'users' table
				$request->session()->regenerate();
				//return redirect()->route('admin.index');
				return redirect()->intended(route('admin.index'));
			}else{
				//If not Admin. Go to the route 'home' - main page
				return redirect()->home();
			}
		}
		//If Authentication failed go back to the Authentication page and add the session 'error' - with() method
		return redirect()->back()->with('error', 'Your e-mail address or password is incorrect');
		//dd($request->all());
	}
	//Logout the user
	public function logout(Request $request){
		Auth::logout();
		return redirect()->route('register.create');
	}
}
