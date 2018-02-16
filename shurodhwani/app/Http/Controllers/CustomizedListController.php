<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Audio;
use App\UserCustomizedList;


class CustomizedListController extends Controller
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
        if(Auth::check() == false) return redirect('/');
        $audio_list = Audio::orderBy('title')->get();
        return view('CreatePersonalList' , compact('audio_list'));
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
        $album = new UserCustomizedList();
        $album->title = $request->albumTitle;
        $album->audio_list = $request->audio_list;
        //foreach($album->audio_arr as $id) echo $id.'<br>';
        $user = Auth::user();
        $album->addedBy = $user->id;

        if($request->albumBack != null){
            $img = $request->albumBack;
            $name = $img->getClientOriginalName();
            $img->move('uploadedCustomizedListBack/' . $user->id , $name);
            $album->poster = 'uploadedCustomizedListBack/' . $user->id . "/" . $name;
        }
        else{
            $album->poster = 'images/albumDefault.jpg';
        }

        $album->save();
        return redirect('/customizedList/'.$album->_id);
    }

    public function editList($id)
    {
        if(Auth::check() == false) return redirect('/');
        $album = UserCustomizedList::find($id);
        if($album == null) return redirect('/');
        if(Auth::user()->_id !== $album->addedBy) return redirect('/');

        $audio_list = [];
        $id_arr = [];
        foreach($album->audio_list as $audio_id){
            $audio = Audio::find($audio_id);
            if($audio == null) continue;
            $audio_list = array_prepend($audio_list , $audio);
            $id_arr = array_prepend($id_arr , $audio_id);
            //echo $audio->title.' '.$audio_id.'<br>';
        }
        $audio_list = array_reverse($audio_list);
        $id_arr = array_reverse($id_arr);
        $uploadedSong = Audio::orderBy('title')->get();

        return view('EditPersonalList' , compact('album' , 'audio_list' , 'uploadedSong' , 'id_arr'));
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
        $album = UserCustomizedList::find($id);
        $uploaded_list = $album->audio_list;
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
        $playlist_title = "Songs of the Playlist:: ".$album->title;

//        echo $playlist_title.'<br>';
//        for($i = 0 ; $i < sizeof($audio_arr) ; $i++){
//            echo $id_arr[$i]." ".$title_arr[$i]." ".$path_arr[$i].'<br>';
//        }

        return view('MusicPlayer' , compact('id_arr' , 'title_arr' , 'path_arr' , 'playlist_title'));
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
        $album = UserCustomizedList::find($id);
        if($album == null) return redirect('/');
        if(Auth::user()->_id !== $album->addedBy) return redirect('/');

        $album->title = $request->albumTitle;
        $album->audio_list = $request->audio_list;
        //foreach($album->audio_arr as $id) echo $id.'<br>';
        $user = Auth::user();
        $album->addedBy = $user->id;

        if($request->albumBack != null){
            $img = $request->albumBack;
            $name = $img->getClientOriginalName();
            $img->move('uploadedCustomizedList/' . $user->id , $name);
            $album->poster = 'uploadedCustomizedList/' . $user->id . "/" . $name;
        }

        $album->save();
        return redirect('/customizedList/'.$album->_id);
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

    public function deleteAlbum($id){
        if(Auth::check() == false) return redirect('/');
        $song = UserCustomizedList::find($id);
        if($song == null) return redirect('/');
        if(Auth::user()->_id !== $song->addedBy) return redirect('/');

        $song->delete();
        return redirect('/');
    }
}
