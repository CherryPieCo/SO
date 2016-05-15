<?php

namespace App\Http\Controllers;

use Input;
use Sentinel;
use Mail;
use App\Helpers\Email as EmailHelper;


class HomeController extends Controller
{
    
    public function showIndex()
    {
        return view('index');
    } // end showIndex
    
    public function createAccount()
    {
        // csrf
        $fullName = Input::get('name');
        $names = explode(' ', $fullName);
        $firstName = array_shift($names);
        $lastName = implode(' ', $names);
        
        $email = Input::get('email');
        $password = str_random(8);
        
        $error = '';
        if (!Sentinel::findByCredentials(['email' => $email])) {
            if (EmailHelper::exist($email)) {
                $user = Sentinel::registerAndActivate([
                    'email'       => $email,
                    'password'    => $password,
                    'first_name'  => $firstName,
                    'last_name'   => $lastName,
                    'token'       => str_random(32),
                ]);
            
                // $activation = Activation::create($user);
                // Activation::complete($user, $activation->code);
                
                Sentinel::login($user);
                
                Mail::send('emails.new_account', compact('fullName', 'password'), function($message) use($fullName, $email) {
                    $message->to($email, $fullName);
                    $message->subject('Your account password');
                });
            } else {
                $error = 'Email doesnt exist';
            }
        } else {
            $error = 'Email is currently in use';
        }
        
        return response()->json([
            'status' => !$error,
            'error'  => $error,
        ]);
    } // end createAccount
    
    public function login()
    {
        $user = false;
        $error = 'User not found';
        try {
            $user = Sentinel::authenticate([
                'email'    => Input::get('email'), 
                'password' => Input::get('password')
            ], true);
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }
        
        
        return response()->json([
            'status' => !!$user,
            'error'  => $error,
        ]);
    } // end login
    
}