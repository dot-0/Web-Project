<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Audio;
use App\User;
use App\Artist;
use App\Tag;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Comment;

class AudioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        echo "I'm the index ===> ";
        try {
            $user_id = Auth::user()->_id;
            $user = User::find($user_id);
            echo "logged in ".$user->name." ".$user_id;
        }catch(\Exception $e){
            echo "You are not logged in";
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //echo "I'm the creator ===> ";
        return view('audio_upload');
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
//        echo "called ===> ";
//        echo " ===> ".request()->audio.'<br>';
//        echo $request->audio->path().'<br>';
//        echo "called222 ===> ";
        $flag = true;
        try {
            $user_id = Auth::user()->_id;
        }catch(\Exception $e){
            echo "You are not logged in";
            $flag = false;
        }

        if($flag == true) {
            //echo $request->audio->getClientOriginalName() . ' ===> <br>';
            if ($request->audio) {
                $audio = $request->audio;
                $ext = $audio->getClientOriginalExtension();
                if ($ext == 'mp3') {
                    //$name = $audio->getClientOriginalName();
                    $name = $request->songTitle.".".$ext;
                    //echo $name . '<br>';
                    $audio->move('uploadedAudio/' . $user_id, $name);

                    $song = new Audio();
                    $song->title = $request->songTitle;
                    $song->save();

                    if ($request->description != null) $song->description = $request->description;
                    else $song->description = "No description added by uploader";

                    if ($request->songArtist != null){
                        $artist_arr = explode( ',' , $request->songArtist);
                        for($i = 0 ; $i < sizeof($artist_arr) ; $i++){
                            $artist_arr[$i] = trim($artist_arr[$i]);
                        }
                        $art_arr = [];
                        for($i = 0 ; $i < sizeof($artist_arr) ; $i++){
                            //echo " ================> ".$artist_arr[$i]." ".strlen($artist_arr[$i]).'<br>';
                            $exp = '/.*'.$artist_arr[$i].'*/i';
                            $artist_match = Artist::where('name' , 'regexp' , $exp)->get();
                            $artist = null;
                            if(sizeof($artist_match) != 0){
                                foreach($artist_match as $art){
                                    //echo " ------> ".$art->name." ".strlen($art->name).'<br>';
                                    if(strlen($art->name) == strlen($artist_arr[$i])){
                                        $artist = $art;
                                        break;
                                    }
                                }
                            }
                            if($artist == null){
                                $artist = new Artist();
                                $artist->name = $artist_arr[$i];
                                $artist->audio_list = [];
                                $artist->album_list = [];
                                $artist->description = "No description has been added";
                            }
                            $artist->audio_list = array_prepend($artist->audio_list , $song->_id);
                            $art_arr = array_prepend($art_arr , $artist->name);
                            $artist->save();
                        }
                        $song->artist_arr = $art_arr;
                    }
                    else $song->artist_arr = [];

                    if ($request->songGenre != null){
                        $tag_arr = explode( ',' , $request->songGenre);
                        for($i = 0 ; $i < sizeof($tag_arr) ; $i++){
                            $tag_arr[$i] = trim($tag_arr[$i]);
                        }
                        $tagArr = [];
                        if(sizeof($tag_arr) != 0) {
                            for ($i = 0; $i < sizeof($tag_arr); $i++) {
                                //echo "===============> ".$tag_arr[$i]." ".strlen($tag_arr[$i]).'<br>';
                                $exp = '/.*' . $tag_arr[$i] . '*/i';
                                $tag_match = Tag::where('name', 'regexp', $exp)->get();
                                $tag = null;
                                if (sizeof($tag_match) != 0) {
                                    foreach ($tag_match as $tg) {
                                       // echo "---> ".$tg->name." ".strlen($tg->name).'<br>';
                                        if (strlen($tg->name) == strlen($tag_arr[$i])) {
                                            $tag = $tg;
                                            break;
                                        }
                                    }
                                }
                                if ($tag == null) {
                                    $tag = new Tag();
                                    $tag->name = $tag_arr[$i];
                                    $tag->audio_list = [];
                                    $tag->album_list = [];
                                    $tag->description = "No description has been added";
                                }
                                $tag->audio_list = array_prepend($tag->audio_list, $song->_id);
                                $tagArr = array_prepend($tagArr , $tag->name);
                                $tag->save();
                            }
                        }
                        $song->tag_arr = $tagArr;
                    }
                    else $song->tag_arr = [];

                    $song->added_by = $user_id;

                    $song->users_given_rating = [];
                    $song->rating_arr = [];
                    $song->rating_sum = 0;
                    $song->rating = 0.0;

                    $song->users_listened = 0;
                    $song->file_path = 'uploadedAudio/' . $user_id . "/" . $name;

                    if($request->songBack != null){
                        $img = $request->songBack;
                        $name = $img->getClientOriginalName();
                        $img->move('uploadedAudioBack/' . $user_id, $name);
                        $song->poster = 'uploadedAudioBack/' . $user_id . "/" . $name;
                    }
                    else{
                        $song->poster = 'images/defaultMusic.png';
                    }
                    $song->save();

                    $user = User::find($user_id);
                    $user->upload_list = array_prepend($user->upload_list , $song->id);
                    $user->save();
                    //echo "successfully uploaded" . "<br>";
                    return redirect('/audio/'.$song->id);
                } else {
                    echo "uploaded file is not mp3" . '<br>';
                }
                //echo "Process terminated";
            } else {
                echo "No file has been uploaded";
            }
        }
    }

    public function updateRating(Request $request){
        $id = $request->target_id;
        $song = Audio::find($id);
        $user_id = $request->user_id;
        $len = sizeof($song->users_given_rating);
        $fl = false;
        for($i = 0 ; $i < $len ; $i++){
            if($song->users_given_rating[$i] == $user_id){
                $song->rating_sum -= $song->rating_arr[$i];
                $arr = $song->rating_arr;
                $arr[$i] = $request->given_rating;
                $song->rating_arr = $arr;
                $song->rating_sum += $song->rating_arr[$i];
                $fl = true;
                break;
            }
        }
        if($fl == false){
            $song->users_given_rating = array_prepend($song->users_given_rating , $user_id);
            $song->rating_arr = array_prepend($song->rating_arr , $request->given_rating);
            $song->rating_sum += $request->given_rating;
        }
        if(sizeof($song->rating_arr) > 0) $song->rating = $song->rating_sum/sizeof($song->rating_arr);
        else $song->rating = 0.0;
        $song->save();
        return response()->json(['success'=>'rating updated' , 'new_rating'=>$song->rating]);
    }

    public function updateHitNumber(Request $request){
        $id = $request->id;
        $audio = Audio::find($id);
        $audio->users_listened += 1;
        $audio->save();

        $user_id = $request->user_id;
        if($user_id != -1){
            $user = User::find($user_id);
            $arr = $user->listen_list;
            if (($key = array_search($id, $arr)) !== false) {
                unset($arr[$key]);
            }
            $user->listen_list = array_prepend($arr , $id);
            $user->save();
        }
        return response()->json(['success'=>'yesss hit number updated' , 'id'=>$audio->_id]);
    }

    public function paginateComments(Request $request)
    {
        $id = $request->id;
        $from = $request->from;
        $to = $request->to;

        $allComments = Comment::where('target_id' , $id)->orderBy('_id' , 'desc')->get();
        $commenter = [];
        $comments = [];
        for($i = $from ; $i < $to && $i < sizeof($allComments); $i++){
            $comments = array_prepend($comments , $allComments[$i]);
            $user = User::find($allComments[$i]->user_id);
            $commenter = array_prepend($commenter , $user);
        }
        $comments = array_reverse($comments);
        $commenter = array_reverse($commenter);
        return view('paginateComments' , compact('comments' , 'commenter'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateHitRouteCall($id){
        $audio = Audio::find($id);
        $audio->users_listened += 1;
        $audio->save();

        if(Auth::check()){
            $user = Auth::user();
            $arr = $user->listen_list;
            if (($key = array_search($id, $arr)) !== false) {
                unset($arr[$key]);
            }
            $user->listen_list = array_prepend($arr , $id);
            $user->save();
        }
    }

    public function show($id)
    {
        //
        //echo "Hello ===> ".$id.'<br>';

        $this->updateHitRouteCall($id);

        $audio = Audio::find($id);
        $user_id = $audio->added_by;
        $addedBy = User::find($user_id);
        $paginateLimit = 7;
        $comments = Comment::where('target_id' , $id)->orderBy('_id' , 'desc')->get();
        $commentSize = sizeof($comments);
        $comments = Comment::where('target_id' , $id)->orderBy('_id' , 'desc')->take($paginateLimit)->get();
        $commenter = [];
        foreach($comments as $cmt){
            $user = User::find($cmt->user_id);
            $commenter = array_prepend($commenter , $user);
        }
        $commenter = array_reverse($commenter);
        $title = $audio->title;
        $path = $audio->file_path;
//        foreach($comments as $cmt) {
//            echo $cmt->content.' ::'.$cmt->created_at."<br>";
//        }
        //$comments = array_reverse($comments);
        //echo $audio->rating;
        $fav = 0;
        $rating = 0.0;
        try{
            $currentUser = Auth::user();
            if (($key = array_search($id, $currentUser->fav_list)) !== false) $fav = 1;
            $len = sizeof($audio->users_given_rating);
            for($i = 0 ; $i < $len ; $i++){
                if($audio->users_given_rating[$i] == $currentUser->id){
                    $rating = $audio->rating_arr[$i];
                    break;
                }
            }
        }catch(\Exception $e){

        }
        //echo $id." ".$currentUser->_id." :: ".$fav;

        $recommendedSong = [];
        $artist_arr = $audio->artist_arr;
        $tag_arr = $audio->tag_arr;

        $searchArtist = [];
        $searchTag = [];
        for($i = 0 ; $i < sizeof($artist_arr) ; $i++){
            //echo " ================> ".$artist_arr[$i]." ".strlen($artist_arr[$i]).'<br>';
            $exp = '/.*'.$artist_arr[$i].'*/i';
            $artist_match = Artist::where('name' , 'regexp' , $exp)->get();
            $artist = null;
            if(sizeof($artist_match) != 0){
                foreach($artist_match as $art){
                    //echo " ------> ".$art->name." ".strlen($art->name).'<br>';
                    if(strlen($art->name) == strlen($artist_arr[$i])){
                        $artist = $art;
                        break;
                    }
                }
            }
            if($artist !== null) {
                //echo ">>> ".$artist->name.'<br>';
                $searchArtist = array_prepend($searchArtist , $artist);
            }
        }
        //echo '<br>';
        for($i = 0 ; $i < sizeof($tag_arr) ; $i++){
           // echo " ================> ".$tag_arr[$i]." ".strlen($tag_arr[$i]).'<br>';
            $exp = '/.*'.$tag_arr[$i].'*/i';
            $tag_match = Tag::where('name' , 'regexp' , $exp)->get();
            $tag = null;
            if(sizeof($tag_match) != 0){
                foreach($tag_match as $tg){
                    //echo " ------> ".$tg->name." ".strlen($tg->name).'<br>';
                    if(strlen($tg->name) == strlen($tag_arr[$i])){
                        $tag = $tg;
                        break;
                    }
                }
            }
            if($tag !== null) {
                //echo ">>> ".$tag->name.'<br>';
                $searchTag = array_prepend($searchTag , $tag);
            }
        }

        foreach($searchTag as $tag){
            $id_arr = $tag->audio_list;
            $limit = 7;
            $audio_list = Audio::whereIn('_id' , $id_arr)->orderBy('rating' , 'desc')->get();
            foreach ($audio_list as $aaa){
                $limit--;
                if($limit == 0) break;
                if (($key = array_search($aaa, $recommendedSong)) !== false) continue;
                $recommendedSong = array_prepend($recommendedSong , $aaa);
            }
        }
        foreach($searchArtist as $art){
            $id_arr = $art->audio_list;
            $limit = 7;
            $audio_list = Audio::whereIn('_id' , $id_arr)->orderBy('rating' , 'desc')->get();
            foreach ($audio_list as $aaa){
                $limit--;
                if($limit == 0) break;
                if (($key = array_search($aaa, $recommendedSong)) !== false) continue;
                $recommendedSong = array_prepend($recommendedSong , $aaa);
            }
        }

        $allSongUsersListened = Audio::orderBy('users_listened' , 'desc')->get();
        $allSongRating = Audio::orderBy('rating' , 'desc')->get();
        $searchLimit = 3;
        for($i = 0 ; $i < sizeof($allSongUsersListened) && $i < $searchLimit; $i++){
            if (($key = array_search($allSongUsersListened[$i], $recommendedSong)) !== false) continue;
            $recommendedSong = array_prepend($recommendedSong , $allSongUsersListened[$i]);
            //echo "   ==> ".$allSongUsersListened[$i]->title.'<br>';
        }
        for($i = 0 ; $i < sizeof($allSongRating) && $i < $searchLimit; $i++){
            if (($key = array_search($allSongRating[$i], $recommendedSong)) !== false) continue;
            $recommendedSong = array_prepend($recommendedSong , $allSongRating[$i]);
            //echo "   ==> ".$allSongRating[$i]->title.'<br>';
        }

        if (($key = array_search($audio, $recommendedSong)) !== false) {
            unset($recommendedSong[$key]);
        }
        shuffle($recommendedSong);
        $sz = sizeof($recommendedSong);
        //echo '===>'.$sz.'<br>';
        $artist_arr = [];

        $lim = 35;
        for($i = 0 ; $i < $sz; $i++){
            $art = "";
            $song = $recommendedSong[$i];
            for($j = 0 ; $j < sizeof($song->artist_arr) ; $j++){
                if(strlen($art) + strlen($song->artist_arr[$j]) > $lim){
                    for($k = 0 ; $k < strlen($song->artist_arr[$j]) ; $k++){
                        $art = $art.$song->artist_arr[$j][$k];
                        if(strlen($art) == $lim){
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
            $artist_arr = array_prepend($artist_arr , $art);
//        echo $i." ".$song->title.' ==> '.$artist_arr[$i]." :: ";
//        foreach($song->artist_arr as $art) echo $art.", ";
//        echo '<br>';
        }

        //for($i = 0 ; $i < sizeof($recommendedSong) ; $i++) echo " ---> ".$recommendedSong[$i]->title.'<br>';

        //echo "found".'<br>';
        $artist_arr = array_reverse($artist_arr);

        $from = 0;
        $user = $addedBy;
        //echo "User::" . $addedBy;
        $artist_id = [];
        foreach($audio->artist_arr as $art){
            $exp = '/.*'.$art.'*/i';
            $artist_match = Artist::where('name' , 'regexp' , $exp)->get();
            $artist = null;
            if(sizeof($artist_match) != 0){
                foreach($artist_match as $a){
                    //echo " ------> ".$art->name." ".strlen($art->name).'<br>';
                    if(strlen($a->name) == strlen($art)){
                        $artist = $a;
                        break;
                    }
                }
            }
            if($artist !== null) {
                //echo ">>> ".$artist->name.'<br>';
                $artist_id = array_prepend($artist_id , $artist);
            }
        }

        $tag_id = [];
        foreach($audio->tag_arr as $art){
            $exp = '/.*'.$art.'*/i';
            $tag_match = Tag::where('name' , 'regexp' , $exp)->get();
            $tag = null;
            if(sizeof($tag_match) != 0){
                foreach($tag_match as $a){
                    //echo " ------> ".$art->name." ".strlen($art->name).'<br>';
                    if(strlen($a->name) == strlen($art)){
                        $tag = $a;
                        break;
                    }
                }
            }
            if($tag !== null) {
                //echo ">>> ".$artist->name.'<br>';
                $tag_id = array_prepend($tag_id , $tag);
            }
        }

        $artist_id = array_reverse($artist_id);
        $tag_id = array_reverse($tag_id);

        return view('SongProfile' , compact('from' , 'audio' , 'user' , 'title' , 'path' , 'id' , 'comments' , 'commenter' , 'fav' , 'rating' , 'recommendedSong' , 'artist_arr' , 'commentSize' , 'artist_id' , 'tag_id'));
    }

    public function showAudio(){
        $id = "5a366f7d2816813788003d75";
        $audio = Audio::find($id);
        $user_id = $audio->added_by;
        $user = User::find($user_id);
        //$comments = Comment::where('target_id' , '=' , $id);
        $title = $audio->title;
        $path = $audio->file_path;
        return view('SongProfile' , compact('audio' , 'user' , 'title' , 'path' , 'id'));
    }

    public function showRankList()
    {
        $recommendedSong = Audio::orderBy('rating' , 'desc')->get();

        $sz = sizeof($recommendedSong);
        //echo '===>'.$sz.'<br>';
        $artist_arr = [];

        $lim = 35;
        for($i = 0 ; $i < $sz; $i++){
            $art = "";
            $song = $recommendedSong[$i];
            for($j = 0 ; $j < sizeof($song->artist_arr) ; $j++){
                if(strlen($art) + strlen($song->artist_arr[$j]) > $lim){
                    for($k = 0 ; $k < strlen($song->artist_arr[$j]) ; $k++){
                        $art = $art.$song->artist_arr[$j][$k];
                        if(strlen($art) == $lim){
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
            $artist_arr = array_prepend($artist_arr , $art);
//        echo $i." ".$song->title.' ==> '.$artist_arr[$i]." :: ";
//        foreach($song->artist_arr as $art) echo $art.", ";
//        echo '<br>';
        }

        //echo "found".'<br>';
        $artist_arr = array_reverse($artist_arr);

        $ratingSorted = $recommendedSong;
        $rating_artist_arr = $artist_arr;

        $recommendedSong = Audio::orderBy('users_listened' , 'desc')->get();

        $sz = sizeof($recommendedSong);
        //echo '===>'.$sz.'<br>';
        $artist_arr = [];

        $lim = 35;
        for($i = 0 ; $i < $sz; $i++){
            $art = "";
            $song = $recommendedSong[$i];
            for($j = 0 ; $j < sizeof($song->artist_arr) ; $j++){
                if(strlen($art) + strlen($song->artist_arr[$j]) > $lim){
                    for($k = 0 ; $k < strlen($song->artist_arr[$j]) ; $k++){
                        $art = $art.$song->artist_arr[$j][$k];
                        if(strlen($art) == $lim){
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
            $artist_arr = array_prepend($artist_arr , $art);
//        echo $i." ".$song->title.' ==> '.$artist_arr[$i]." :: ";
//        foreach($song->artist_arr as $art) echo $art.", ";
//        echo '<br>';
        }

        $listenSorted = $recommendedSong;
        $listen_artist_arr = $artist_arr;

        return view('RankList' , compact('ratingSorted' , 'rating_artist_arr' , 'listenSorted' , 'listen_artist_arr'));
    }

    public function editSong($id)
    {
        if(Auth::check() == false) return redirect('/');
        $song = Audio::find($id);
        if($song == null) return redirect('/');
        if(Auth::user()->_id !== $song->added_by) return redirect('/');

        $song = Audio::find($id);
        $artist_arr = "";
        if($song->artist_arr) {
            for($i = 0 ; $i < sizeof($song->artist_arr) ; $i++) {
                $artist = $song->artist_arr[$i];
                $artist_arr = $artist_arr.$artist;
                if($i < sizeof($song->artist_arr) - 1) $artist_arr = $artist_arr.", ";
            }
        }

        $tag_arr = "";
        if($song->tag_arr) {
            for($i = 0 ; $i < sizeof($song->tag_arr) ; $i++) {
                $tag = $song->tag_arr[$i];
                $tag_arr = $tag_arr.$tag;
                if($i < sizeof($song->tag_arr) - 1) $tag_arr = $tag_arr.", ";
            }
        }

        return view('EditSong' , compact('song' , 'artist_arr' , 'tag_arr'));
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
        if(Auth::check() == false) return redirect('/');
        $song = Audio::find($id);
        if($song == null) return redirect('/');
        if(Auth::user()->_id !== $song->added_by) return redirect('/');

        echo "edit song called ".$id.'<br>';
        echo $request->songTitle.'<br>';
        echo $request->songArtist.'<br>';
        echo $request->songGenre.'<br>';


        $song->title = $request->songTitle;
        $user_id = Auth::user()->_id;

            //echo $request->audio->getClientOriginalName() . ' ===> <br>';
        foreach ($song->artist_arr as $prevArt){
            $exp = '/.*'.$prevArt.'*/i';
            $artist_match = Artist::where('name' , 'regexp' , $exp)->get();
            $artist = null;
            if(sizeof($artist_match) != 0){
                foreach($artist_match as $art){
                    //echo " ------> ".$art->name." ".strlen($art->name).'<br>';
                    if(strlen($art->name) == strlen($prevArt)){
                        $artist = $art;
                        break;
                    }
                }
            }
            if($artist == null) continue;
            $arr = $artist->audio_list;
            if (($key = array_search($id, $arr)) !== false) {
                unset($arr[$key]);
            }
            $artist->audio_list = $arr;
            $artist->save();
        }
        if ($request->songArtist != null){
            $artist_arr = explode( ',' , $request->songArtist);
            for($i = 0 ; $i < sizeof($artist_arr) ; $i++){
                $artist_arr[$i] = trim($artist_arr[$i]);
            }
            $art_arr = [];
            for($i = 0 ; $i < sizeof($artist_arr) ; $i++){
                //echo " ================> ".$artist_arr[$i]." ".strlen($artist_arr[$i]).'<br>';
                $exp = '/.*'.$artist_arr[$i].'*/i';
                $artist_match = Artist::where('name' , 'regexp' , $exp)->get();
                $artist = null;
                if(sizeof($artist_match) != 0){
                    foreach($artist_match as $art){
                        //echo " ------> ".$art->name." ".strlen($art->name).'<br>';
                        if(strlen($art->name) == strlen($artist_arr[$i])){
                            $artist = $art;
                            break;
                        }
                    }
                }
                if($artist == null){
                    $artist = new Artist();
                    $artist->name = $artist_arr[$i];
                    $artist->audio_list = [];
                    $artist->album_list = [];
                    $artist->description = "No description has been added";
                }
                $artist->audio_list = array_prepend($artist->audio_list , $song->_id);
                $art_arr = array_prepend($art_arr , $artist->name);
                $artist->save();
            }
            $song->artist_arr = $art_arr;
        }
        else $song->artist_arr = [];

        foreach ($song->tag_arr as $prevTag){
            $exp = '/.*'.$prevTag.'*/i';
            $tag_match = Tag::where('name' , 'regexp' , $exp)->get();
            $tag = null;
            if(sizeof($tag_match) != 0){
                foreach($tag_match as $tg){
                    //echo " ------> ".$art->name." ".strlen($art->name).'<br>';
                    if(strlen($tg->name) == strlen($prevTag)){
                        $tag = $tg;
                        break;
                    }
                }
            }
            if($tag == null) continue;
            $arr = $tag->audio_list;
            if (($key = array_search($id, $arr)) !== false) {
                unset($arr[$key]);
            }
            $tag->audio_list = $arr;
            $tag->save();
        }
        if ($request->songGenre != null){
            $tag_arr = explode( ',' , $request->songGenre);
            for($i = 0 ; $i < sizeof($tag_arr) ; $i++){
                $tag_arr[$i] = trim($tag_arr[$i]);
            }
            $tagArr = [];
            if(sizeof($tag_arr) != 0) {
                for ($i = 0; $i < sizeof($tag_arr); $i++) {
                    //echo "===============> ".$tag_arr[$i]." ".strlen($tag_arr[$i]).'<br>';
                    $exp = '/.*' . $tag_arr[$i] . '*/i';
                    $tag_match = Tag::where('name', 'regexp', $exp)->get();
                    $tag = null;
                    if (sizeof($tag_match) != 0) {
                        foreach ($tag_match as $tg) {
                            // echo "---> ".$tg->name." ".strlen($tg->name).'<br>';
                            if (strlen($tg->name) == strlen($tag_arr[$i])) {
                                $tag = $tg;
                                break;
                            }
                        }
                    }
                    if ($tag == null) {
                        $tag = new Tag();
                        $tag->name = $tag_arr[$i];
                        $tag->audio_list = [];
                        $tag->album_list = [];
                        $tag->description = "No description has been added";
                    }
                    $tag->audio_list = array_prepend($tag->audio_list, $song->_id);
                    $tagArr = array_prepend($tagArr , $tag->name);
                    $tag->save();
                }
            }
            $song->tag_arr = $tagArr;
        }
        else $song->tag_arr = [];

        if($request->songBack != null){
            $img = $request->songBack;
            $name = $img->getClientOriginalName();
            $img->move('uploadedAudioBack/' . $user_id, $name);
            $song->poster = 'uploadedAudioBack/' . $user_id . "/" . $name;
        }
        $song->save();

        return redirect('/audio/'.$song->id);
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
    public function deleteAudio($id){
        if(Auth::check() == false) return redirect('/');
        $song = Audio::find($id);
        if($song == null) return redirect('/');
        if(Auth::user()->_id !== $song->added_by) return redirect('/');

        $song->delete();
        return redirect('/');
    }
}
