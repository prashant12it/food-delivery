<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function login(Request $request)
    {
        View::share('title', 'Login');
        $res = User::where('email',$request->email)->first();
        if (! $res || ! Hash::check($request->password, $res->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }else{
            Session::put('user_id',$res->id);
        }
        return redirect(url('/'));

    }

    public function store_user(Request $request){
       
            $validator = Validator::make($request->all(),[
                'name' => 'required|string|max:150',
                'email' => 'required|string|max:150|unique:users',
                'password' => 'required_with:cpassword|same:cpassword|string|max:150',
                'cpassword' => 'string|max:150',
            ]);
        if($validator->fails()){
//            dd('Password and confirm password must be same');
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
//       if($request->password == $request->cpassword){
           $res = new User();
           $res->name =$request->name;
           $res->email =$request->email;
           $res->password =Hash::make($request->password);
           $res->save();
           Session::put('user_id',$res->id);
           session()->flash('success', 'User Registered successfully');
           return redirect(url('/'));
       /*}else{
           echo "Password and confirm password must be same";
       }*/

}
}
