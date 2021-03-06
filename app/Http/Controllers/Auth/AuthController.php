<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Input;
use Auth;
use DB;
use Hash;
use View;
use Session;

class AuthController extends Controller
{
    use ThrottlesLogins;

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'employee_code' => 'max:20',
        ]);
    }

    protected function register()
    {
        $user_authorization = 2;
        $data = array('first_name' => Input::get('first_name'), 'last_name' => Input::get('last_name'), 'phone' => Input::get('phone'), 'email' => Input::get('email'), 'password' => Input::get('password'), 'password_confirmation' => Input::get('password_confirmation'));
        $validator = $this->validator($data);
        if(Input::has('employee_code'))
        {
            $validator->after(function($validator) 
            {
                $employee_code = DB::select('select authentication_code from user_type where authentication_level = ?', [1]);
                if(!Hash::check(Input::get('employee_code'), $employee_code[0]->authentication_code))
                {
                    $validator->errors()->add('employee_code', 'Incorrect employee code.');
                }
            });
            $user_authorization = 1;

        }

        if($validator->fails()){
            return redirect('register')
            ->withErrors($validator)
            ->withInput();
        }

        User::create([
            'first_name' => ucfirst(strtolower($data['first_name'])),
            'last_name' => ucfirst(strtolower($data['last_name'])),
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'authorization' => $user_authorization,
        ]);

        return $this->login();
    }

    public function login()
    {
        if (Auth::attempt(['email' => Input::get('email'), 'password' => Input::get('password')])) {
            $authorization = DB::select('select authorization from users where email = ?', [Input::get('email')]);
            $url = '/';
            if(Session::has('last_request'))
            { 
                $url = Session::get('last_request');
                Session::forget('last_request');
            }
            return redirect($url);
        }
        return redirect('/login')->with('error', 'Your password or email is incorrect.');
    }

    protected function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('/');

    }

    public function get_login_view()
    {
        if(Auth::guest())return View::make('auth/login');
        
        //$authorization = DB::select('select authorization from users where email = ?', [Auth::user()->email]);
        //if($authorization[0]->authorization == '1')
        //return View::make('add_stone', ['current_page' => 'add_stone' , 'user_name' => Auth::user() , 'stone_types' =>   $page_data['stone_types'] = DB::select('select * from stone_types')]);
        //else
        return View::make('home');

    }

    public function get_register_view()
    {
        if(Auth::guest())return View::make('auth/register');
        
        $authorization = DB::select('select authorization from users where email = ?', [Auth::user()->email]);
        if($authorization[0]->authorization == '1')
        return View::make('add_stone', ['current_page' => 'add_stone' , 'user_name' => Auth::user() , 'stone_types' =>   $page_data['stone_types'] = DB::select('select * from stone_types')]);
        else
        return View::make('home');

    }
}
