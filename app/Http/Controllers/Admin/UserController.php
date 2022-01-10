<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    public function login(Request $request)
    {
        View::share('title', 'Login');
        $res = new User();
        if (! $res || ! Hash::check($request->password, $res->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        return redirect(url('/'));

    }

    public function store_user(Request $request){
       
            $validator = Validator::make($request->all(),[
                'name' => 'required|string|max:150',
                'email' => 'required|string|max:150|unique:users',
                'password' => 'required|string|max:150',
            ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
       
        $res = new User();
        $res->name =$request->name;
        $res->email =$request->email;
        $res->password =Hash::make($request->password);
        $res->cpassword =Hash::make($request->cpassword);      
        // 'email_verified_at' => date('Y-m-d');
        if($res->cpassword == $res->password)
        {
        $res->save();        
        session()->flash('success', 'User Registered successfully');
        return redirect(url('/')); 
        } 
        else{
            echo "Password and confirm password must be same";
        }

}
}