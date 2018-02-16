<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artist;
use App\Audio;

class ArtistController extends Controller
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
        $artist = Artist::find($id);
        $uploaded_list = $artist->audio_list;
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
        $playlist_title = "Songs of ".$artist->name;

//        echo $playlist_title.'<br>';
//        for($i = 0 ; $i < sizeof($audio_arr) ; $i++){
//            echo $id_arr[$i]." ".$title_arr[$i]." ".$path_arr[$i].'<br>';
//        }

        return view('MusicPlayer' , compact('id_arr' , 'title_arr' , 'path_arr' , 'playlist_title'));
    }

    public function showAllArtists()
    {
        $allArtists = Artist::orderBy('name')->paginate(10);
        $title = 'Artists';
        return view('ArtistList' , compact('allArtists' , 'title'));
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
