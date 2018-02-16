<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    public function ajaxRequest()
    {
        $users = User::all();
        return view('ajaxRequest' , compact('users'));
    }

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function ajaxRequestPost(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->password = bcrypt($request->input( 'password' ));
        $user->email = $request->input( 'email' );
        $user->save();
        return response()->json(['success'=>'Got Simple Ajax Request.' , 'id'=>$user->_id]);
    }
    public function ajaxTestDelete($id){
        $user = User::find($id);
        $user->delete();
        //echo "HI HI HI";
        return response()->json(['success'=>'removed.' , 'id'=>$user->_id]);
    }
}
