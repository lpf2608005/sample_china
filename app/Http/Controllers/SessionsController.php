<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
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
        //验证通过后，将返回对应包含数据的数组
        $credentials = $this->validate($request,[
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials, $request->has('remember'))){
            //登录成功
            session()->flash('success','欢迎回来！');
            return redirect()->route('users.show',[Auth::user()]);
        }else{
            //登陆失败
            session()->flash('danger','很抱歉，您的用户名和密码不匹配');
            return redirect()->back();
        }
        return;
    }

    //注销登录
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
}
