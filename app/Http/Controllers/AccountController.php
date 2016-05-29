<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\Controllers;
use Auth;
use App\Http\Controllers\AccountController;
use \Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller {
    
    public function index() {
//        dd(Auth::check());
        if (!Auth::check()) {
            return Redirect::to('login');
        } else {
            return Redirect::to('home');
        };
    }
    public function doLogin() {
        // Get all post data
        $data = Input::all();
       
        // Apply validation rules.
        $rules = array(
            'email' => 'Required|Between:3,64|Email|Exists:users',
            'password' => 'required|min:6',
        );
       
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            // If there are errors
            return Redirect::to('login')->withInput(Input::except('password'))->withErrors($validator);
        } else {
            $userdata = array(
                'email' => Input::get('email'),
                'password' => Input::get('password'),
            );
           // Lets login
            if (Auth::validate($userdata)) {
                if (Auth::attempt($userdata)) {
                    return Redirect::intended('/');
                }
            } else {
                // Server error
                Session::flash('error','Something went wrong');
                return Redirect::to('login')->withErrors($validator);
            }
        }
    }
    public function doLogout() {
        Auth::logout(); // log the user out of our application
        return Redirect::to('login'); // redirect the user to the login screen
    }
}

