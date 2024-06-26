<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Admin;
use App\User;
use App\Roles;
use Session;
use Auth;
use Hash;
class AuthController extends Controller
{
    public function register_auth(){
    	return view('admin.custom_auth.register');
    }
    public function login_auth(){
        return view('admin.custom_auth.login_auth');
    }
    public function logout_auth(){
        Auth::logout();
        Session::forget('admin_name');
        Session::forget('admin_id');
        Session::forget('login_normal');
        return redirect('/admin')->with('message','Đăng xuất thành công');
    }
    public function login(Request $request){
        $this->validate($request,[
            'admin_email' => 'required|email|max:255', 
            'admin_password' => 'required|max:255'
        ]);
        // $data = $request->all();

        if(Auth::attempt(['email'=>$request->admin_email,'password'=>$request->admin_password ])){
            return redirect('/dashboard');
        }else{
            return redirect('/admin')->with('message','Lỗi đăng nhập mời nhập lại ');
        }

    }
    public function register(Request $request){
		$this->validation($request);
		$data = $request->all();

		$admin = new User();
		$admin->name = $data['admin_name'];
		$admin->email = $data['admin_email'];
		$admin->password = Hash::make($data['admin_password']);
		$admin->save();
       

		return redirect('/admin')->with('message','Đăng ký thành công');

    }
    public function validation($request){
    	return $this->validate($request,[
    		'admin_name' => 'required|max:255', 
    		'admin_phone' => 'required|max:255', 
    		'admin_email' => 'required|email|max:255', 
    		'admin_password' => 'required|max:255', 
    	]);
    }
}
