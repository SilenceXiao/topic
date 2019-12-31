<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    //
    public function create()
    {
    	return view('sessions.create');

    }

    //
    public function store(Request $request)
    {
    	$user = $this->validate($request,[
    		'email' => 'required|email|max:255',
    		'password' =>'required',
    	]);

    	if(Auth::attempt($user, $request->has('remember'))){ //匹配用户成功
    		session()->flash('success','登陆成功');
    		return redirect()->route('users.show',[Auth::user()]);

    	}else{//匹配用户失败

    		session()->flash('danger','邮箱和密码不匹配');
    		return redirect()->back()->withInput();
    	}

    }

    public function destroy(Request $request)
    {
    	Auth::logout();
    	session()->flash('success','退出成功');
    	return redirect('login');
    }
}
