<?php
use App\Demo;
use App\User;
use App\Audio;
use App\Tag;
use App\Comment;
use App\Artist;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/insert' , function(){
//    echo "called";
//    $demo = new Demo();
//    $demo->name = "arnab";
//    $demo->profile = "he is joss";
//    $demo->save();
//});

Route::get('/query' , function(){
    echo "testing testing 123".'<br>';
//    $users = User::orderBy('name')->get();
//    foreach($users as $usr) echo $usr->name." ".$usr->email.'<br>';
//
//    $query = User::whereIn('name', ['arnab' , 'mridul'])->get();
//    foreach($query as $data) {
////    $data->name = "arnab";
////    $data->save();
//        echo " >>>>> " . $data->name.'<br>';
//    }
//    $query = User::where('name' , '=' , 'test')->get();
//    foreach($query as $data) {
//        echo " --> " . $data->name.'<br>';
//    }
//    //echo User::count();
//    $usr = User::find("5a0a790f28168120e000608e");
////    $usr->favList = [10,12,14,15];
////    $usr->save();
//    $usr->favList = array_prepend($usr->favList , 15);
//    $usr->favList = array_prepend($usr->favList , "api");
//    foreach($usr->favList as $fav) echo $fav." ";
//    echo '<br>';
//    $usr->favList = array_diff($usr->favList , array(15 , 'api'));
//    foreach($usr->favList as $fav) echo $fav." ";
//    echo '<br>';
//    $usr->favList = array_slice($usr->favList , 0 , -1); // pop the last element
//    $usr->favList = array_slice($usr->favList , 1); // pop the first element
//    foreach($usr->favList as $fav) echo $fav." ";
//    $name = "Arnab,    Sen   ,   Sharma    ";
//    $arr = explode( ',' , $name);
//    foreach($arr as $nm) echo $nm."--".'<br>';
//    for($i = 0 ; $i < sizeof($arr) ; $i++){
//        $arr[$i] = trim($arr[$i]);
//    }
//    foreach($arr as $nm) echo " ===> ".$nm."--".'<br>';
//    $allSong = Audio::groupBy('title')->get(['title']);
//    echo(sizeof($allSong)).'<br>';
//    foreach($allSong as $song) echo $song.'<br>';
//    $allSong = Audio::orderBy('title')->get();
//    $sz = sizeof($allSong);
//    $title_arr = array_fill(0 , $sz , null);
//    $id_arr = array_fill(0 , $sz , null);
//
//    for($i = 0 ; $i < $sz ; $i++){
//        $title_arr[$i] = $allSong[$i]->title;
//        $id_arr[$i] = $allSong[$i]->_id;
//
//        echo $i." ".$id_arr[$i]." ".$title_arr[$i].'<br>';
//    }
//    $txt = "la";
//    $exp = '/.*'.$txt.'.*/i';
//    echo $exp.'<br>';
//    $allSong = Audio::where('title' , 'regexp' , $exp)->get();
//    $song = Audio::where('title' , 'regexp' , $exp)->first();
//    if($song != null) echo "========> " . $song->title . " " . strlen($song->title).'<br>';
//    else echo "Nothing Found".'<br>';
//
//    echo sizeof($allSong).'<br>';
//
//    foreach($allSong as $song) {
//        echo "====> " . $song->title . " " . strlen($song->title).'<br>';
//    }
//    echo "Finished";

//    $txt ="   Arnab   "; echo $txt." ".strlen($txt).'<br>';
//    $txt =trim($txt); echo $txt." ".strlen($txt).'<br>';



//    $user_id = "5a356260281681052000215a";
//    $id = "5a1ad5a928168117a000631a";
//    $user = User::find($user_id);
//    $arr = $user->listen_list;
//    if (($key = array_search($id, $arr)) !== false) {
//        echo "HI";
//        unset($arr[$key]);
//    }
//    $user->listen_list = array_prepend($arr , $id);
//    $user->save();
////
//    $arr = [1,2,3,4,5];
//    foreach($arr as $a) echo $a." ";
    //$arr = array_reverse($arr);
    //foreach($arr as $a) echo $a." ";
//    echo '<br>';
//    $fnd = 3;
//    if (($key = array_search($fnd,$arr)) !== false) {
//        unset($arr[$key]);
//    }
//    $arr = array_prepend($arr , $fnd);
//    foreach($arr as $a) echo $a." ";

//    $audio = Audio::all();
//    for($i = 0 ; $i < sizeof($audio) ; $i++){
//        $audio[$i]->rating = 0.0;
//        $audio[$i]->save();
//    }
//    $comments = Comment::all();
//    for($i = 0 ; $i < sizeof($comments) ; $i++) {
//        $comments[$i]->up = 0;
//        $comments[$i]->down = 0;
//        $comments[$i]->upDownUsers = [];
//        $comments[$i]->save();
//    }
    $allAudio = Audio::all();
    for($i = 0 ; $i < sizeof($allAudio) ; $i++){
        if($allAudio[$i]->poster == null) $allAudio[$i]->poster = 'images/defaultMusic.png';
        $allAudio[$i]->save();
    }
});

//Route::get('/', function () {
//    return view('welcome');
//});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('audio' , 'AudioController');
Route::resource('artist' , 'ArtistController');
Route::resource('search' , 'SearchController');
Route::resource('user' , 'UserController');
Route::resource('album' , 'AlbumController');
Route::resource('tag' , 'TagController');
Route::resource('customizedList' , 'CustomizedListController');

Route::post('/upload' , 'AudioController@store');

Route::get('/master', function () {
    return view('MasterLayout');
});

Route::get('/testHome', function () {
//    $allSong = Audio::orderBy('title')->get();
    $allSong = Audio::orderBy('users_listened' , 'desc')->get();
    $sz = sizeof($allSong);
    $title_arr = array_fill(0 , $sz , null);
    $id_arr = array_fill(0 , $sz , null);
    $path_arr = array_fill(0 , $sz , null);

    for($i = 0 ; $i < $sz ; $i++){
        $title_arr[$i] = $allSong[$i]->title;
        $id_arr[$i] = $allSong[$i]->_id;
        $path_arr[$i] = $allSong[$i]->file_path;

        //echo $i." ".$id_arr[$i]." ".$title_arr[$i].'<br>';
    }


    return view('HomePageTest' , compact('title_arr' , 'id_arr', 'path_arr'));
});

Route::get('/audioProfile', function () {
    return view('SongProfile');
});

Route::get('/showAudio','AudioController@showAudio');

Route::get('/', function () {

    $allSong = Audio::orderBy('rating' , 'desc')->get();
    $allSongUsersListened = Audio::orderBy('users_listened' , 'desc')->get();
    $allSongRating = Audio::orderBy('rating' , 'desc')->get();
//    $recommendedSong = $allSong;
    //$allSong = Audio::all();
    $limit = 15;
    $checkPrevious = 30;
    $limit = min(sizeof($allSong) , $limit);
    if(Auth::check() == false){
        $recommendedSong = [];
        for($i = 0 ; $i < $limit ; $i++){
            $recommendedSong = array_prepend($recommendedSong , $allSong[$i]);
        }
        $recommendedSong = array_reverse($recommendedSong);
    }
    else{
        $user = Auth::user();
        $listenedSong = Audio::whereIn('_id' , $user->listen_list)->get();
        $map = [];
        $allTag = Tag::all();
        //echo '<br>';
        foreach($allTag as $tag) $map[$tag->name] = 0;
        for($i = 0 ; $i < $checkPrevious && $i < sizeof($listenedSong) ; $i++){
            $song = $listenedSong[$i];
            $tags = $song->tag_arr;
            foreach($tags as $tg) {
                //echo $tg.", ";
                try {
                    $map[$tg]++;
                }catch(\Exception $e){}
            }
            //echo '<br>';
        }
        //echo '<br>';
        //foreach($allTag as $tag) echo $tag->name." ".$map[$tag->name].'<br>';

        $recommendedSong = [];
        $it = 10;
        while(sizeof($recommendedSong) < $limit && $it != 0){
            $max = 0;
            $maxTag = "Tag";
            foreach($allTag as $tag){
                if($map[$tag->name]>$max){
                    $max = $map[$tag->name];
                    $maxTag = $tag->name;
                }
            }
            //echo $maxTag." --> ".$max.'<br>';
            if($max == 0) break;
            try {
                $tg = Tag::where('name', $maxTag)->first();
                $audioList = Audio::whereIn('_id' , $tg->audio_list)->orderBy('rating' , 'desc')->get();
                for($i = 0 ; $i < 5 && $i < sizeof($audioList); $i++){
                    if (($key = array_search($audioList[$i], $recommendedSong)) !== false) continue;
                    $recommendedSong = array_prepend($recommendedSong , $audioList[$i]);
                    //echo "   => ".$audioList[$i]->title.'<br>';
                }
            }catch(\Exception $e){
                //echo "caught exception".'<br>';
            }
            $map[$maxTag] = 0;
            $it--;
        }

        $searchLimit = 10;
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

       // echo '<br>';
        $recommendedSong = array_reverse($recommendedSong);
//        foreach($recommendedSong as $audio) {
//            echo $audio->title.'  => ';
//            foreach($audio->tag_arr as $tg) echo $tg.', ';
//            echo '<br>';
//        }
//        $recommendedSong = [];
//        for($i = 0 ; $i < $limit ; $i++){
//            $recommendedSong = array_prepend($recommendedSong , $allSong[$i]);
//        }
//        $recommendedSong = array_reverse($recommendedSong);
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

    //echo "found".'<br>';
    $artist_arr = array_reverse($artist_arr);
    //echo sizeof($artist_arr)."<br>";
    //for($i = 0 ; $i<$sz ; $i++) echo $i." ".$recommendedSong[$i]->title." :: ".$artist_arr[$i]."<br>";
    $newReleases = Audio::orderBy('created_at' , 'desc')->take(20)->get();

    $trending = Audio::orderBy('created_at' , 'desc')->take(40)->orderBy('users_listened' , 'desc')->take(5)->get();

    return view('HomePage' , compact('recommendedSong' , 'artist_arr' , 'newReleases' , 'trending' ));
});

Route::get('/temp', function () {
    return view('temp');
});

Route::get('/laravelHome', function () {
    return view('home');
});

Route::get('/laravelWelcome', function () {
    return view('welcome');
});

Route::get('/upload', function () {
    if(Auth::check() == true){
        $uploadedSong = [];
        $user = Auth::user();
        $upload_list = $user->upload_list;
        foreach($upload_list as $id){
            $audio = Audio::find($id);
            if($audio == null) continue;
            $uploadedSong = array_prepend($uploadedSong , $audio);
        }
        return view('UploadSong' , compact('uploadedSong'));
    }
    return redirect('/');
});

Route::get('/test', function () {
    return view('test');
});

Route::get('/userProfile/{id}', 'UserController@show');
Route::get('/musicPlayer' , function(){
    $audio_arr = Audio::orderBy('users_listened' , 'desc')->get();
    $title_arr = [];
    $path_arr = [];
    $id_arr = [];
    foreach($audio_arr as $audio){
        $id_arr = array_prepend($id_arr , $audio->_id);
        $title_arr = array_prepend($title_arr , $audio->title);
        $path_arr = array_prepend($path_arr , $audio->file_path);
    }
    $title_arr = array_reverse($title_arr);
    $path_arr = array_reverse($path_arr);
    $id_arr = array_reverse($id_arr);

    $playlist_title = "My Playlist";
    return view('MusicPlayer' , compact('id_arr' , 'title_arr' , 'path_arr' , 'playlist_title'));
});

Route::get('/updateUserProfile/{id}', 'UserController@viewUpdateUserPage');
Route::post('addComment', 'CommentController@addComment');

Route::post('/searchResult', 'SearchController@showSearchResult');

Route::post('/saveEdited' , 'UserController@saveEdited');
Route::get('ajaxRequest', 'HomeController@ajaxRequest');
Route::post('ajaxRequest', 'HomeController@ajaxRequestPost');
Route::post('ajaxTestDelete/{id}', 'HomeController@ajaxTestDelete');

Route::get('/allArtists' , 'ArtistController@showAllArtists');
Route::get('/allTags' , 'TagController@showAllTags');
Route::get('/rankList' , 'AudioController@showRankList');

Route::get('/showFavourites/{id}' , 'UserController@showFavourites');
Route::get('/albumList', 'AlbumController@showAll');
Route::get('/uploadedSongList/{id}', 'UserController@showAllUploadedSongs');
Route::get('/uploadedAlbumList/{id}', 'UserController@showAllUploadedAlbums');
Route::get('/editSong/{id}', 'AudioController@editSong');
Route::get('/editAlbum/{id}', 'AlbumController@editAlbum');
Route::get('/showPersonalList/{id}', 'UserController@showAllCustomizedLists');
Route::get('/editPersonalList/{id}', 'CustomizedListController@editList');

Route::get('/deleteAudio/{id}' , 'AudioController@deleteAudio');
Route::get('/deleteAlbum/{id}' , 'AlbumController@deleteAlbum');
Route::get('/deleteCustomizedList/{id}' , 'CustomizedListController@deleteAlbum');