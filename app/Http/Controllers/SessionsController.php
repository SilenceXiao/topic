<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{

	public function __construct()
    {
        $this->middleware('guest',[
            'only' => ['create'],
        ]);
    }


    //
    public function create()
    {
    	if(Auth::user()){
    		return redirect()->route('users.show',[Auth::user()]);
    	}

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
            if(Auth::user()->activated){

        		session()->flash('success','登陆成功');
        		$fallback = route('users.show', Auth::user());
        		// return redirect()->route('users.show',[Auth::user()]);
               	return redirect()->intended($fallback);
            }else{

                Auth::logout();
                session()->flash('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活。');
                return redirect('/');
            }

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
