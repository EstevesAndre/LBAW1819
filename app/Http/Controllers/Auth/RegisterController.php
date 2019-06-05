<?php

namespace App\Http\Controllers\Auth;

use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(Request $data)
    {    
        $dec1 = rand(0, 1);
        $dec2 = rand(0, 1);
            
        $user = User::create([
            'username' => $data['name'],
            'name' => $data['char_name'],
            'birthdate' => $data['birthday'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'gender' => $dec1 == 1 ? $data['emotional'] : $data['outness'],
            'race' => $data['happiness'],
            'class' => $dec2 == 1 ? $data['angriness'] : $data['best'],
        ]);

        $user->save();

        Auth::login($user);

        return redirect('home');
    }

    public function createCharacter(Request $data){
        return view('pages.createCharacter', ['data' => $data]);
    }
}
