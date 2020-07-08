<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Hash;
use Validator;
use Auth;
use DB;
use Carbon\Carbon;

class AdminLoginController extends Controller
{    
	private $table = "ms_user";

    public function get_login(){  
    	return view ('Login.login',[
            
        ]);
    }

    public function postLogin(Request $request)
    {
        $condition = false;
        $user = $this->find_user($request->get('username'));

        $test = \Hash::check($request->get('password'), $user->password);
        if ($user != null) {                
              if ($user->username == $request->get('username') && $test) {
                  $condition = true;
              }
        }     
        // dump($user);
        if ($condition) {
            $photo = ($user->photo) ? asset($user->photo) : asset('vendor/crudbooster/avatar.jpg');
            Session::put('is_login', true);
            Session::put('id',$user->id);         
            Session::put('name',$user->name);
            Session::put('id_role',$user->id_role);
            Session::put('role',$user->role);
            Session::put('image',$photo);
            return [
                "status" => "success",
                "redirect_route" => "dashboard" 
            ];
        }

        return [
            "status" => "error",
            "message" => "User not valid"
        ];

    }

    public function find_user($username)
    {
        return DB::table($this->table)
            ->join('ms_role', 'ms_user.id_role', '=', 'ms_role.id')
            ->select('ms_user.*', 'ms_role.name as role')
            ->where('username', $username)
            ->first();
    }

   public function logout(){
      Auth::logout();
      Session::flush();
      return redirect('login')->with('status','Logout Successfully');
   }
   public function genPassword(Request $request)
   {
       $password = \Hash::make($request->input('username'));
        return [
            "new_password" => $password
        ];
   }
}
