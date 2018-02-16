<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/';

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
    protected function create(array $data)
    {
        $temp = new User();
        $temp->name = $data['name'];
        $temp->email = $data['email'];
        $temp->password = bcrypt($data['password']);
        $temp->my_lists = [];
        $temp->listen_list = [];
        $temp->upload_list = [];
        $temp->up_down_arr = [];
        $temp->rating_arr = [];
        $temp->review_arr = [];
        $temp->recent_type = [];
        $temp->recent_artist = [];
        $temp->fav_list = [];
        $temp->points = 0.0;
        $temp->about_me = "not added yet";
        $temp->profilePic = "images/pro_pic_icon.jpg";
        $temp->is_admin = 0;
        //$temp->profile_pic = "...";
        $temp->save();
        return $temp;
//        return User::create([
//            'name' => $data['name'],
//            'email' => $data['email'],
//            'password' => bcrypt($data['password']),
//        ]);
    }
}
