<?php

class AuthController extends BaseController {
	public function login(){
		$user = array(
            'username' => Input::get('username'),
            'password' => Input::get('password')
        );
        
        if (Auth::attempt($user)) {
            return Redirect::to('/');
        }
        
        // authentication failure! lets go back to the login page
        return Redirect::to('login')
            ->with('error', 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง')
            ->withInput();
	}

	public function logout(){
		Auth::logout();
    	return Redirect::to('login')
       				->with('notice', 'การออกจากระบบเสร็จสมบูรณ์');
	}
}