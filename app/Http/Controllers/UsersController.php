<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',[
            'except' =>['show','create','store','index'],
        ]);

        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    //用户列表
    public function index()
    {
        // $users = User::all();
        $users = User::paginate(10);
        return view('users.index',compact('users'));
    }

    //注册界面
    public function create()
    {
    	return view('users.create');
    }

    //用户信息
    public function show(User $user)
    {
    	return view('users.show',compact('user'));
    }

    //注册
    public function store(Request $request)
    {
    	// dd($request);
    	$this->validate($request, [
    		'name' => 'required|max:50',
    		'email' => 'required|email|unique:users|max:255',
    		'password' => 'required|confirmed|min:6'
    	]);

    	$user = User::create([
    		'name' => $request->name,
    		'email' => $request->email,
    		'password' => bcrypt($request->password),
    	]);

        Auth::login($user);
    	session()->flash('success','注册成功，欢迎加入');
    	return redirect()->route('users.show', [$user]);
    }

    //编辑界面
    public function edit(User $user)
    {
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }

    //更新
    public function update(User $user,Request $request)
    {
        $this->authorize('update',$user);
        $this->validate($request, [
            'name' => 'required|max:50',
            // 'name' => [
            //     'required|max:6',
            //     Rule::unique('users')->ignore($user->id)
            // ],
            'password' => 'nullable|confirmed|min:6'
        ]);

        $user->name = $request->name;
        if($request->password){
            $user->password = bcrypt($request->password);
        }

        $user->save();

        session()->flash('success','更新成功');
        return redirect()->route('users.show', $user->id);
    }


    //删除
    public function destroy(User $user)
    {
        $this->authorize('destroy',$user);
        $user->delete();
        session()->flash('success','删除成功');
        return back();
    }
}
