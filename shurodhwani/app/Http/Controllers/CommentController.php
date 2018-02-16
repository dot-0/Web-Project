<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\User;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function addComment(Request $request)
    {
        $cmt = new Comment();
        $cmt->target_id = $request->target_id;
        $cmt->content = $request->comment;
        $cmt->user_id = $request->user_id;
        $cmt->up = 0;
        $cmt->down = 0;
        $cmt->upDownUsers = [];
        $cmt->save();
        $user = User::find($request->user_id);
        $username = $user->name;
        $created_at = $cmt->created_at;
        $proPc = $user->profilePic;
        return response()->json(['success'=>'comment added' , 'userName'=>$username , 'tym'=>$created_at , 'proPic'=>$proPc , 'id'=>$cmt->_id]);
    }

    public function upComment(Request $request)
    {
        $id = $request->target_id;
        $user_id = $request->user_id;

        $cmt = Comment::find($id);
        if($user_id != -1) {
            $flag = true;
            foreach($cmt->upDownUsers as $user){
                if($user == $user_id){
                    $flag = false;
                    break;
                }
            }
            if($flag == true){
                $cmt->up++;
                $cmt->upDownUsers = array_prepend($cmt->upDownUsers, $user_id);
                $cmt->save();
            }
        }
        return response()->json(['success'=>'comment liked' , 'up'=>$cmt->up]);
    }

    public function downComment(Request $request)
    {
        $id = $request->target_id;
        $user_id = $request->user_id;

        $cmt = Comment::find($id);
        if($user_id != -1) {
            $flag = true;
            foreach($cmt->upDownUsers as $user){
                if($user == $user_id){
                    $flag = false;
                    break;
                }
            }
            if($flag == true){
                $cmt->down++;
                $cmt->upDownUsers = array_prepend($cmt->upDownUsers, $user_id);
                $cmt->save();
            }
        }
        return response()->json(['success'=>'comment disliked' , 'down'=>$cmt->down]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
