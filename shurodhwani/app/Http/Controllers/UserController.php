<?php

namespace App\Http\Controllers;

use App\Comment;
use App\UserCustomizedList;
use Illuminate\Http\Request;
use App\User;
use App\Audio;
use App\Album;
use Auth;

class UserController extends Controller
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user = User::find($id);
        $allSong = Audio::all();
        $uploaded_song = [];
//        $uploaded_song = Audio::where('added_by' , 'id')->get();
        for($i = 0 ; $i < sizeof($allSong) ; $i++){
            $song = $allSong[$i];
            if($song->added_by == $id) {
                $uploaded_song = array_prepend($uploaded_song , $song);
                //echo $song->title.'<br>';
            }
        }
//        echo " ====> ".$user->id.'<br>';
//        foreach($uploaded_song as $song){
//            echo $song->title.'<br>';
//        }
        $recentList = [];
        $artistArr = [];
        $limit = 40;
        for($i = 0 ; $i<10 && $i<sizeof($user->listen_list) ; $i++) {
            $song = Audio::find($user->listen_list[$i]);
            if($song == null) continue;
            $recentList = array_prepend($recentList , $song);
            $art = "";
            for($j = 0 ; $j < sizeof($song->artist_arr) ; $j++){
                if(strlen($art) + strlen($song->artist_arr[$j]) > $limit){
                    for($k = 0 ; $k < strlen($song->artist_arr[$j]) ; $k++){
                        $art = $art.$song->artist_arr[$j][$k];
                        if(strlen($art) == $limit){
                            $art = $art." ....";
                            break;
                        }
                    }
                }
                else{
                    if($j > 0) $art = $art." ";
                    $art = $art.$song->artist_arr[$j];
                    if($j < sizeof($song->artist_arr) - 1) $art = $art.",";
                }
            }
            $artistArr = array_prepend($artistArr , $art);
            //for($j = 0 ; $j < sizeof($song->artist_arr) ; $j++) echo $song->artist_arr[$j].", ";
            //echo " :::==>".$song->title." ".$art."<br>";
        }
        $recentList = array_reverse($recentList);
        $artistArr = array_reverse($artistArr);

        $point = sizeof($uploaded_song)*10;
        $comments = Comment::where('user_id' , $id)->get();
        $point += sizeof($comments)*3;

        //echo sizeof($comments);

        foreach ($comments as $comment){
            $point += $comment->up;
            $point -= $comment->down;
        }

        $album_list = Album::where('addedBy' , $id)->get();

        return view('UserProfile' , compact('user' , 'uploaded_song' , 'recentList' , 'artistArr' , 'point' , 'album_list'));
    }

    public function showAllUploadedSongs($id){
        $user = User::find($id);
        $audio_list = Audio::where('added_by' , $id)->paginate(16);
        return view('UploadedSongList' , compact('audio_list', 'user'));
    }
    public function showAllUploadedAlbums($id){
        $user = User::find($id);
        $album_list = Album::where('addedBy' , $id)->paginate(16);
        return view('UploadedAlbumList' , compact('album_list', 'user'));
    }
    public function showAllCustomizedLists($id){
        $user = User::find($id);
        $album_list = UserCustomizedList::where('addedBy' , $id)->paginate(16);
        return view('ShowPersonalList' , compact('album_list', 'user'));
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
    public function viewUpdateUserPage($id){
        $user = User::find($id);
        return view('UpdateUserProfile' , compact('user'));
    }

    public function saveEdited(Request $request){
        $id = $request->id;
        $user = User::find($id);
        $user->name = $request->name;
        $user->about_me = $request->aboutMe;

        //echo $id." ".$name;
        if($request->proPic != null){
            $img = $request->proPic;
            $name = $img->getClientOriginalName();
            $img->move('profilePic/' . $user->_id, $name);
            $user->profilePic = 'profilePic/' . $user->_id . "/" . $name;
        }
        $user->save();
        return redirect('/user/'.$request->id);
    }

    public function addToFav(Request $request)
    {
        $user_id = $request->user_id;
        $target_id = $request->target_id;
        $user = User::find($user_id);
        $arr = $user->fav_list;
        if (($key = array_search($target_id, $arr)) !== false) {
            unset($arr[$key]);
        }
        else $arr = array_prepend($arr ,  $target_id);
        $user->fav_list = $arr;
        $user->save();
        return response()->json(['success'=>'fav_list updated']);
    }

    public function showFavourites($id){
        $user = User::find($id);
        if(Auth::check() == false) return redirect('/');
        if(Auth::user()->_id != $user->_id) return redirect('/');

        $uploaded_list = $user->fav_list;
        $audio_arr = [];
        $id_arr = [];
        $title_arr = [];
        $path_arr = [];
        foreach($uploaded_list as $idd) {
            //echo $id_arr[$i].'<br>';

            $audio = Audio::find($idd);
            if($audio == null) continue;
            //echo $uploaded_list[$i]." ".$audio.'<br>';
            $id_arr = array_prepend($id_arr , $idd);
            $audio_arr = array_prepend($audio_arr , $audio);
            $title_arr = array_prepend($title_arr , $audio->title);
            $path_arr = array_prepend($path_arr , $audio->file_path);

        }

        $id_arr = array_reverse($id_arr);
        $title_arr = array_reverse($title_arr);
        $path_arr = array_reverse($path_arr);
//
        $playlist_title = "Favourites of ".$user->name;

//        echo $playlist_title.'<br>';
//        for($i = 0 ; $i < sizeof($audio_arr) ; $i++){
//            echo $id_arr[$i]." ".$title_arr[$i]." ".$path_arr[$i].'<br>';
//        }

        return view('MusicPlayer' , compact('id_arr' , 'title_arr' , 'path_arr' , 'playlist_title'));
    }

    public function update(Request $request , $id)
    {
        //
        echo "called ".$id;
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
